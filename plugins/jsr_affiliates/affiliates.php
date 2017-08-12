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
	function affiliates_shortcode( $atts = [], $content = null ) {

		// do something to $content
		include('input-page.php');
		$content = '';

		// always return
		return $content;
	}
	add_shortcode('affiliates', 'affiliates_shortcode');
}
add_action( 'init', 'aff_shortcode_init' );




// add_option($name, $value, $deprecated, $autoload);
// ie. add_option( 'affiliates_coupons', $affiliate, null, 'yes' );
// get_option($option);
// update_option($option_name, $newvalue);