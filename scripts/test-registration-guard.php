<?php
// Run with: ddev exec php scripts/test-registration-guard.php
if ( PHP_SAPI !== 'cli' ) {
    exit( 1 );
}
require dirname( __DIR__ ) . '/wp-load.php';
if ( ! str_ends_with( (string) wp_parse_url( home_url(), PHP_URL_HOST ), '.test' ) ) {
    exit( "Run only against the local .test site.\n" );
}
function djr_assert( $condition, $message ) {
    if ( ! $condition ) {
        throw new RuntimeException( $message );
    }
    echo "PASS: $message\n";
}
$address = '192.0.2.231';
$key = 'djr_registration_' . hash_hmac( 'sha256', inet_pton( $address ), wp_salt( 'auth' ) );
$wpdb->delete( $wpdb->prefix . 'wc_rate_limits', array( 'rate_limit_key' => $key ) );
try {
    djr_assert( 'no' === get_option( 'woocommerce_enable_myaccount_registration' ), 'Standalone form disabled' );
    djr_assert( ! get_option( 'users_can_register' ), 'WordPress public registration disabled' );
    $errors = apply_filters( 'woocommerce_process_registration_errors', new WP_Error(), '', '', 'test@example.invalid' );
    djr_assert( in_array( 'djr_registration_closed', $errors->get_error_codes(), true ), 'Direct registration POST validation blocked' );
    $_SERVER['REMOTE_ADDR'] = $address;
    $_POST['djr_registration_website'] = 'https://bot.invalid';
    $errors = apply_filters( 'woocommerce_registration_errors', new WP_Error(), 'test', 'test@example.invalid' );
    djr_assert( in_array( 'djr_registration_bot', $errors->get_error_codes(), true ), 'Filled honeypot rejected' );
    unset( $_POST['djr_registration_website'] );
    for ( $i = 1; $i <= 5; $i++ ) {
        $errors = apply_filters( 'woocommerce_registration_errors', new WP_Error(), 'test', 'test@example.invalid' );
        djr_assert( ! $errors->has_errors(), "Valid account attempt $i allowed" );
    }
    $_SERVER['HTTP_X_FORWARDED_FOR'] = '192.0.2.232';
    $errors = apply_filters( 'woocommerce_registration_errors', new WP_Error(), 'test', 'test@example.invalid' );
    djr_assert( in_array( 'djr_registration_limit', $errors->get_error_codes(), true ), 'Sixth attempt blocked despite spoofed forwarding header' );
    $wpdb->update( $wpdb->prefix . 'wc_rate_limits', array( 'rate_limit_expiry' => time() - 1 ), array( 'rate_limit_key' => $key ) );
    djr_assert( djr_registration_take_slot( $address ), 'Registration allowed after expiry' );
    ob_start();
    do_action( 'woocommerce_after_checkout_billing_form', null );
    $html = ob_get_clean();
    djr_assert( str_contains( $html, 'name="djr_registration_website"' ) && str_contains( $html, 'tabindex="-1"' ), 'Accessible hidden honeypot rendered' );
    echo "No accounts, orders, or emails were created.\n";
} finally {
    $wpdb->delete( $wpdb->prefix . 'wc_rate_limits', array( 'rate_limit_key' => $key ) );
}
