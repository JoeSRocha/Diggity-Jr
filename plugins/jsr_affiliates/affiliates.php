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
			$email = htmlspecialchars( $_POST[ 'inputEmail' ] );
			$instagram = htmlspecialchars( $_POST[ 'instagramUser' ] );
			$coupon_code = htmlspecialchars( $_POST[ 'couponCode' ] );

			require_once( 'affiliates.class.php' );

			$affiliate_list = new Affiliates;
			$affiliate_list->all_affiliates = get_option( 'affiliates' );
			$affiliate_list->input_affiliate( $first_name, $last_name, $email, $instagram , $coupon_code );
			$affiliates = $affiliate_list->get_affiliates();

			update_option( 'affiliates', $affiliates );

			echo "<br/><h2>Awesome! Looking forward to working together.<br/><br/>Talk to you soon  $first_name 😉.</h2>";
		}

		$content = '';

		return $content;
	}
	add_shortcode('affiliates', 'affiliates_shortcode');
}
add_action( 'init', 'aff_shortcode_init' );

include( 'admin/admin-functions.php' );
