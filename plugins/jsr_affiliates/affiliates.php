<?php
/*
Plugin Name: Affiliate Coupon Manager
Plugin URI:  https://adroitgraphics.com
Description: Affiliate coupon code tracker and notification plugin.
Version:     0.1
Author:      Joe Rocha
Author URI:  https://adroitgraphics.com
License:     GPL2
License URI: https://www.gnu.org/licenses/gpl-2.0.html
Text Domain: affiliate_coupon
Domain Path: /languages
*/
defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

require_once( 'affiliates.class.php' );
$affiliate_list = new Affiliates;
// Shortcode Creation
function aff_shortcode_init() {
	function affiliates_shortcode( $content = null ) {

		if ( !isset($_POST['submitted'] ) ) {
			include( 'input-page.php' );
		} else {
			$first_name = htmlspecialchars( $_POST[ 'firstName' ] );
			$last_name = htmlspecialchars( $_POST[ 'lastName' ] );
			$email = htmlspecialchars( $_POST[ 'user_email' ] );
			$instagram = htmlspecialchars( $_POST[ 'instagramUser' ] );
			$coupon_code = htmlspecialchars( $_POST[ 'couponCode' ] );
			$affiliate_list->all_affiliates = get_option( 'affiliates' );
			$affiliate_list->input_affiliate( $first_name, $last_name, $email, $instagram , $coupon_code );
			$affiliates = $affiliate_list->get_affiliates();

			update_option( 'affiliates', $affiliates );

			echo "<br/><h2>Awesome! Looking forward to working together $first_name.<br/><br/>Your code, <u>$coupon_code</u> is now active 😉.</h2>";
			// Create User
			$userdata = array(
				'user_login' 	=> $_POST['firstName'] . $_POST['lastName'] ,
				'user_email' 	=> $_POST['user_email'],
				//'user_pass'   	=> wp_generate_password(6, false),
				'user_pass'   	=>	NULL,
				'first_name'    => $_POST['firstName'],
				'last_name'     => $_POST['lastName'],
			);
			$user_id = wp_insert_user( $userdata ) ;
			//On success
			if ( ! is_wp_error( $user_id ) ) {
				// echo '<br/><h3>Fyi, your new Username is ' . $_POST['firstName'] . $_POST['lastName'] . '</h3>';
				// echo '<h3>You should be receiving an email with further details.</h3>';
				wp_new_user_notification( $user_id, 'both' );
			}
			// Create Coupon
			//$coupon_code = 'UNIQUECODE'; // Code
			$amount = '15'; // Amount
			$discount_type = 'percent'; // Type: fixed_cart, percent, fixed_product, percent_product
			$person = $_POST['firstName'] . ' ' . $_POST['lastName'];
			$coupon = array(
				'post_title' => $coupon_code,
				'post_content' 	=> '',
				'post_status' 	=> 'publish',
				'post_author' 	=> 1,
				'post_type'		=> 'shop_coupon',
				'post_excerpt'	=> "$person\'s Affiliate Code gets you 15% off!",
			);

			$new_coupon_id = wp_insert_post( $coupon );

			// Add meta
			update_post_meta( $new_coupon_id, 'discount_type', $discount_type );
			update_post_meta( $new_coupon_id, 'coupon_amount', $amount );
			update_post_meta( $new_coupon_id, 'individual_use', 'no' );
			update_post_meta( $new_coupon_id, 'product_ids', '' );
			update_post_meta( $new_coupon_id, 'limit_usage_to_x_items', 2 );
			update_post_meta( $new_coupon_id, 'exclude_sale_items', 'yes' );
			update_post_meta( $new_coupon_id, 'usage_limit', '' );
			update_post_meta( $new_coupon_id, 'expiry_date', '' );
			update_post_meta( $new_coupon_id, 'apply_before_tax', 'yes' );
			update_post_meta( $new_coupon_id, 'free_shipping', 'no' );
		}

		$content = '';

		return $content;
	}
	add_shortcode('affiliates', 'affiliates_shortcode');
}
add_action( 'init', 'aff_shortcode_init' );

include( 'admin/admin-functions.php' );


/*
function custom_emails_on_applied_coupon( $coupon_code ) {
	$affiliates = $affiliate_list->all_affiliates = get_option( 'affiliates' );
	$affiliate = $affiliate_list->check_coupon_affiliates( $coupon_code );
	$to = $affiliate['email'];
	$subject = 'Someone is at checkout with your referral code!';
	$content = "The coupon code \"$coupon_code\" has been applied by a customer. SCORE! We will email you again, when the order completes!";
	$headers = array(
	'From: Savannah@DiggityJr.com <savannah@diggityjr.com>',
	'Bcc: Joe Adroit <joesrocha@gmail.com>',
	);
	wp_mail( $to, $subject, $content, $headers );
}
add_action( 'woocommerce_applied_coupon', 'custom_emails_on_applied_coupon', 10, 1 );


function orders_complete_affiliate( $coupon_code ) {
	$affiliates = $affiliate_list->all_affiliates = get_option( 'affiliates' );
	$affiliate = $affiliate_list->check_coupon_affiliates( $coupon_code );
	$to = $affiliate['email'];
	$subject = 'Someone completed an order at checkout with your referral code!';
	$content = "The coupon code $coupon_code has been used by a customer. SCORE!
	If this is the third purchase, email us back and let me know what tee in color and size to send ;).";
	$headers = array(
		'From: Savannah@DiggityJr.com <savannah@diggityjr.com>',
		'Bcc: Joe Adroit <joesrocha@gmail.com>',
		);
	wp_mail( $to, $subject, $content );
}
add_action( 'woocommerce_checkout_process', 'orders_complete_affiliate' );
*/
