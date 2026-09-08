<?php
/**
 * Plugin Name: Diggity Jr Registration Guard
 * Description: Blocks standalone signup and limits automated checkout account creation.
 * Version: 1.0.0
 */

defined( 'ABSPATH' ) || exit;

// Keep registration at checkout only, including direct POSTs to the old form.
add_filter( 'pre_option_woocommerce_enable_myaccount_registration', function () { return 'no'; } );
add_filter( 'pre_option_users_can_register', '__return_zero' );
add_filter( 'woocommerce_process_registration_errors', function ( $errors ) {
    $errors->add( 'djr_registration_closed', 'Please create your account during checkout.' );
    return $errors;
} );

// Not required to be present: this does not break cached or customized checkout forms.
add_action( 'woocommerce_after_checkout_billing_form', function () {
    if ( is_user_logged_in() ) {
        return;
    }
    echo '<div aria-hidden="true" style="position:absolute;left:-10000px;width:1px;height:1px;overflow:hidden">';
    echo '<label for="djr_registration_website">Leave this field empty</label>';
    echo '<input type="text" id="djr_registration_website" name="djr_registration_website" value="" tabindex="-1" autocomplete="off" />';
    echo '</div>';
} );

/**
 * Atomically allow five new-account attempts per network address per 15 minutes.
 * Uses WooCommerce's existing rate-limit table and expiry cleanup. Store only an
 * HMAC, never the raw address; ignore spoofable forwarded headers. Nginx must set
 * REMOTE_ADDR to the real client if a trusted reverse proxy is introduced.
 */
function djr_registration_take_slot( $address ) {
    global $wpdb;
    $packed = @inet_pton( $address );
    if ( false === $packed ) {
        return true; // CLI/background integrations may not have a client address.
    }
    // Treat an IPv6 /64 as one client network, preventing trivial address rotation.
    if ( 16 === strlen( $packed ) ) {
        $packed = substr( $packed, 0, 8 );
    }
    $key = 'djr_registration_' . hash_hmac( 'sha256', $packed, wp_salt( 'auth' ) );
    $now = time();
    $result = $wpdb->query( $wpdb->prepare(
        "INSERT INTO {$wpdb->prefix}wc_rate_limits
            (rate_limit_key, rate_limit_expiry, rate_limit_remaining) VALUES (%s, %d, 4)
         ON DUPLICATE KEY UPDATE
            rate_limit_remaining = IF(rate_limit_expiry <= %d, 4, GREATEST(rate_limit_remaining - 1, 0)),
            rate_limit_expiry = IF(rate_limit_expiry <= %d, VALUES(rate_limit_expiry), rate_limit_expiry)",
        $key, $now + 15 * MINUTE_IN_SECONDS, $now, $now
    ) );
    if ( false === $result ) {
        error_log( 'Diggity Jr registration rate-limit storage failed.' );
        return false;
    }
    return $result > 0;
}

// This shared hook covers both classic checkout and Store API account creation.
add_filter( 'woocommerce_registration_errors', function ( $errors ) {
    if ( $errors->has_errors() || ( defined( 'WP_CLI' ) && WP_CLI ) || current_user_can( 'create_users' ) ) {
        return $errors;
    }
    if ( ! empty( $_POST['djr_registration_website'] ) ) {
        $errors->add( 'djr_registration_bot', 'Account creation could not be completed. Please refresh the page and try again.' );
        return $errors;
    }
    $address = isset( $_SERVER['REMOTE_ADDR'] ) ? (string) $_SERVER['REMOTE_ADDR'] : '';
    if ( ! djr_registration_take_slot( $address ) ) {
        $errors->add( 'djr_registration_limit', 'Too many account creation attempts. Please try again in 15 minutes, or uncheck Create an account to check out as a guest.' );
    }
    return $errors;
}, 100 );
