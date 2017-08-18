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

			require_once( 'affiliates.class.php' );

			$affiliate_list = new Affiliates;
			$affiliate_list->all_affiliates = get_option( 'affiliates' );
			$affiliate_list->input_affiliate( $first_name, $last_name, $email, $instagram , $coupon_code );
			$affiliates = $affiliate_list->get_affiliates();

			update_option( 'affiliates', $affiliates );

			echo "<br/><h2>Awesome! Looking forward to working together.<br/><br/>Talk to you soon  $first_name 😉.</h2>";

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
				echo '<br/><h3>Fyi, your login Username is ' . $_POST['firstName'] . $_POST['lastName'] . '</h3>';
				echo '<h3>You may login <a href="/my-account/">here</a></h3>';
				wp_new_user_notification( $user_id, 'both' );
			}
		}

		$content = '';

		return $content;
	}
	add_shortcode('affiliates', 'affiliates_shortcode');
}
add_action( 'init', 'aff_shortcode_init' );

include( 'admin/admin-functions.php' );
