<?php
/** Run with wp eval-file scripts/setup-disney-collection.php after deploying collections. */
if ( ! defined( 'WP_CLI' ) || ! WP_CLI || ! function_exists( 'diggityjr_collection_settings' ) ) {
	exit( 1 );
}
$settings = diggityjr_collection_settings();
if ( ! isset( $settings['disney-inspired'] ) ) {
	WP_CLI::error( 'Deploy the Disney collection code first.' );
}
$term = term_exists( 'disney-inspired', 'product_cat' );
if ( ! $term ) {
	$term = wp_insert_term( 'Disney-Inspired Collection', 'product_cat', array( 'slug' => 'disney-inspired' ) );
}
if ( is_wp_error( $term ) ) {
	WP_CLI::error( $term->get_error_message() );
}
$term_id = (int) $term['term_id'];
$ids = get_posts( array(
	'post_type' => 'product', 'post_status' => 'publish', 'numberposts' => -1, 'fields' => 'ids',
	'tax_query' => array( array( 'taxonomy' => 'product_cat', 'field' => 'slug', 'terms' => array( 'disney-kids', 'disney-baby', 'disney-gear' ) ) ),
) );
foreach ( $ids as $id ) {
	$result = wp_set_object_terms( $id, array( $term_id ), 'product_cat', true );
	if ( is_wp_error( $result ) ) {
		WP_CLI::error( $result->get_error_message() );
	}
}
$page = get_page_by_path( 'disney-inspired-collection' );
if ( ! $page ) {
	$page_id = wp_insert_post( array(
		'post_type' => 'page', 'post_status' => 'publish',
		'post_title' => 'Disney-Inspired Collection', 'post_name' => 'disney-inspired-collection',
		'post_content' => '[diggityjr_collection category="disney-inspired"]', 'comment_status' => 'closed',
	), true );
	if ( is_wp_error( $page_id ) ) {
		WP_CLI::error( $page_id->get_error_message() );
	}
	update_post_meta( $page_id, '_wp_page_template', 'page-full-width.php' );
} else {
	$page_id = $page->ID;
}
$locations = get_nav_menu_locations();
$menu_id = $locations['main-navigation'] ?? 0;
if ( ! $menu_id ) {
	WP_CLI::error( 'No active main menu.' );
}
$items = wp_get_nav_menu_items( $menu_id );
$existing = 0;
$position = count( $items ) + 1;
foreach ( $items as $item ) {
	if ( 'product_cat' === $item->object && $term_id === (int) $item->object_id ) {
		$existing = $item->ID;
	}
	if ( 'Halloween Collection' === $item->title ) {
		$position = $item->menu_order + 1;
	}
}
if ( ! $existing ) {
	foreach ( $items as $item ) {
		if ( $item->menu_order >= $position ) {
			wp_update_post( array( 'ID' => $item->ID, 'menu_order' => $item->menu_order + 1 ) );
		}
	}
	$existing = wp_update_nav_menu_item( $menu_id, 0, array(
		'menu-item-title' => 'Disney-Inspired Collection', 'menu-item-object' => 'product_cat',
		'menu-item-object-id' => $term_id, 'menu-item-type' => 'taxonomy',
		'menu-item-status' => 'publish', 'menu-item-parent-id' => 0, 'menu-item-position' => $position,
	) );
	if ( is_wp_error( $existing ) ) {
		WP_CLI::error( $existing->get_error_message() );
	}
}
WP_CLI::success( wp_json_encode( array( 'page' => $page_id, 'category' => $term_id, 'products' => count( $ids ), 'menu_item' => $existing, 'url' => get_permalink( $page_id ) ) ) );
