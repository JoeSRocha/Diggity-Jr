<?php


/**
* Enqueue parent CSS
*/

add_action( 'wp_enqueue_scripts', 'enqueue_parent_theme_style' );
function enqueue_parent_theme_style() {

    wp_enqueue_style( 'parent-style', get_template_directory_uri().'/style.css' );
    wp_enqueue_style( 'child-style', get_stylesheet_directory_uri().'/style.css' );

}



//* Add Auto-Updates
add_filter( 'auto_update_core', '__return_true' );                                // Enable core updates
add_filter( 'auto_update_plugin', '__return_true' );                             // Enable plugin updates
add_filter( 'automatic_updates_is_vcs_checkout', '__return_false', 1 );  // Enable updates, despite .git


// Hide Woothemes Updater notification
//remove_action( 'admin_notices', 'woothemes_updater_notice' );

// Hide Billing Phone
add_filter( 'woocommerce_billing_fields', 'wc_npr_filter_phone', 10, 1 );
 
function wc_npr_filter_phone( $address_fields ) {
$address_fields['billing_phone']['required'] = false;
return $address_fields;
}

//remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
//remove_action( 'wp_print_styles', 'print_emoji_styles' );


// Remove WP Version From Styles	
add_filter( 'style_loader_src', 'remove_ver_css_js', 9999 );
// Remove WP Version From Scripts
add_filter( 'script_loader_src', 'remove_ver_css_js', 9999 );
// Function to remove version numbers
function remove_ver_css_js( $src ) {
	if ( strpos( $src, 'ver=' ) )
		$src = remove_query_arg( 'ver', $src );
	return $src;
}


// CDN jQuery
add_action( 'wp_enqueue_scripts', 'register_cdns' );
function register_cdns() {
	
	//Don't use jQuery CDN... 
    
    wp_deregister_script( 'shopkeeper-fitvids' );
    wp_register_script( 'shopkeeper-fitvids', 'https://cdnjs.cloudflare.com/ajax/libs/fitvids/1.1.0/jquery.fitvids.min.js', array('jquery'), '1.1.0', TRUE);
    wp_enqueue_script( 'shopkeeper-fitvids' );

}


// Remove CF Scripts
add_action( 'wp_print_scripts', 'my_deregister_contact', 100 );
function my_deregister_contact() {
   if ( !is_page('contact-us') ) {
	wp_deregister_script( 'contact-form-7' );
     }
}

// Remove CF CSS
add_action( 'wp_print_scripts', 'my_deregister_contact_css', 100 );
function my_deregister_contact_css() {
   if ( !is_page('contact-us') ) {
	wp_deregister_style( 'contact-form-7' );
     }
}



// Remove Scripts
add_action( 'wp_print_scripts', 'remove_scripts', 999 );
function remove_scripts()
{

    wp_deregister_script( 'shopkeeper-google-maps' );
    wp_dequeue_script( 'shopkeeper-google-maps' );

    wp_deregister_script( 'shopkeeper-fresco' );
    wp_dequeue_script( 'shopkeeper-fresco' );

    wp_deregister_script( 'shopkeeper-nanoscroller' );
    wp_dequeue_script( 'shopkeeper-nanoscroller' );

}


// Remove CSS

add_action( 'wp_print_styles', 'my_deregister_styles', 100 );
function my_deregister_styles() {

	wp_deregister_style('woocommerce_enqueue_styles');
	wp_dequeue_style('woocommerce_enqueue_styles');

	wp_deregister_style('shopkeeper-animate');
	wp_dequeue_style('shopkeeper-animate');

	wp_deregister_style('shopkeeper-font-linea-arrows');
	wp_dequeue_style('shopkeeper-font-linea-arrows');
	
	wp_deregister_style('shopkeeper-font-linea-basic');
	wp_dequeue_style('shopkeeper-font-linea-basic');

	wp_deregister_style('shopkeeper-font-linea-basic_elaboration');
 	wp_dequeue_style('shopkeeper-font-linea-basic_elaboration');

	wp_deregister_style('shopkeeper-font-linea-ecommerce');
	wp_dequeue_style('shopkeeper-font-linea-ecommerce');

	wp_deregister_style('shopkeeper-font-linea-music');
	wp_dequeue_style('shopkeeper-font-linea-music');

	wp_deregister_style('shopkeeper-font-linea-software');
	wp_dequeue_style('shopkeeper-font-linea-software');

	wp_deregister_style('shopkeeper-font-linea-weather');
	wp_dequeue_style('shopkeeper-font-linea-weather');

	wp_deregister_style('shopkeeper-fresco');
	wp_dequeue_style('shopkeeper-fresco');

	wp_deregister_style('shopkeeper-top-bar');
	wp_dequeue_style('shopkeeper-top-bar');

	wp_deregister_style('shopkeeper-nanoscroller');
	wp_dequeue_style('shopkeeper-nanoscroller');

}


/**
 * Optimize WooCommerce Scripts
 * Remove WooCommerce Generator tag, styles, and scripts from non WooCommerce pages.
 */
add_action( 'wp_enqueue_scripts', 'child_manage_woocommerce_styles', 99 );
 
function child_manage_woocommerce_styles() {
	//remove generator meta tag
	remove_action( 'wp_head', array( $GLOBALS['woocommerce'], 'generator' ) );
 
	//first check that woo exists to prevent fatal errors
	if ( function_exists( 'is_woocommerce' ) ) {
		//dequeue scripts and styles
		if ( ! is_woocommerce() && ! is_cart() && ! is_checkout() ) {
			wp_dequeue_style( 'woocommerce_frontend_styles' );
			wp_dequeue_style( 'woocommerce_fancybox_styles' );
			wp_dequeue_style( 'woocommerce_chosen_styles' );
			wp_dequeue_style( 'woocommerce_prettyPhoto_css' );
			wp_dequeue_script( 'wc_price_slider' );
			wp_dequeue_script( 'wc-single-product' );
			wp_dequeue_script( 'wc-add-to-cart' );
			wp_dequeue_script( 'wc-cart-fragments' );
			wp_dequeue_script( 'wc-checkout' );
			wp_dequeue_script( 'wc-add-to-cart-variation' );
			wp_dequeue_script( 'wc-single-product' );
			wp_dequeue_script( 'wc-cart' );
			wp_dequeue_script( 'wc-chosen' );
			wp_dequeue_script( 'woocommerce' );
			wp_dequeue_script( 'prettyPhoto' );
			wp_dequeue_script( 'prettyPhoto-init' );
			wp_dequeue_script( 'jquery-blockui' );
			wp_dequeue_script( 'jquery-placeholder' );
			wp_dequeue_script( 'fancybox' );
			wp_dequeue_script( 'jqueryui' );
		}
	}
 
}


/**
 * Trim zeros in price decimals
 **/
 add_filter( 'woocommerce_price_trim_zeros', '__return_true' );


/**
 * Add size.js enqueue
 */

add_filter( 'template_include', 'check_page_template', 999 );

function check_page_template( $template ) {
	if ( is_product() ) {
	   wp_register_script('js-sizes', get_stylesheet_directory_uri().'/js/sizes.js','','1.1', true);
	   wp_enqueue_script('js-sizes');
	}
	return $template;
}
