<?php
/**
 * Plugin Name: Diggity Jr Collections
 * Description: Age-grouped collection pages with canonical category links.
 */

defined( 'ABSPATH' ) || exit;

function diggityjr_collection_settings() {
	return array(
		'halloween' => array(
			'page' => 'halloween-collection',
			'intro' => 'A little spooky. A lot of personality. Find your Halloween favorites for every age.',
			'meta' => 'Shop the Halloween Collection at Diggity Jr. Discover spooky tees and bodysuits for babies, kids, youth, and adults, organized by age.',
		),
		'disney-inspired' => array(
			'page' => 'disney-inspired-collection',
			'intro' => 'A little nostalgia. A lot of personality. Explore Disney-inspired favorites for every age.',
			'meta' => 'Shop the Disney-Inspired Collection at Diggity Jr. Explore tees, bodysuits, and more for babies, kids, youth, and adults, organized by age.',
		),
	);
}

function diggityjr_collection_page_url( $category ) {
	$settings = diggityjr_collection_settings();
	if ( ! isset( $settings[ $category ] ) ) {
		return '';
	}
	$page = get_page_by_path( $settings[ $category ]['page'] );
	return $page && 'publish' === $page->post_status ? get_permalink( $page ) : '';
}

add_filter( 'term_link', function ( $url, $term, $taxonomy ) {
	if ( 'product_cat' === $taxonomy ) {
		return diggityjr_collection_page_url( $term->slug ) ?: $url;
	}
	return $url;
}, 10, 3 );

add_action( 'template_redirect', function () {
	if ( is_tax( 'product_cat' ) && ! is_feed() ) {
		$term = get_queried_object();
		$url = diggityjr_collection_page_url( $term->slug );
		if ( $url ) {
			wp_safe_redirect( $url, 301, 'Diggity Jr Collections' );
			exit;
		}
	}
}, 5 );

/** Group by existing categories; youth must precede its parent kids category. */
function diggityjr_collection_groups( $category ) {
	$groups = array(
		'babies' => array( 'title' => 'Babies', 'description' => 'Infant tees and bodysuits for the littlest boos.', 'slugs' => array( 'baby-sizes' ), 'ids' => array() ),
		'kids' => array( 'title' => 'Kids', 'description' => 'Little tees, big Halloween energy.', 'slugs' => array( 'kids' ), 'ids' => array() ),
		'youth' => array( 'title' => 'Youth', 'description' => 'Spooky favorites for the bigger kids.', 'slugs' => array( 'youth-8-12' ), 'ids' => array() ),
		'adults' => array( 'title' => 'Adults', 'description' => 'Join the fun with grown-up sizes.', 'slugs' => array( 'adult', 'women' ), 'ids' => array() ),
		'more' => array( 'title' => 'More Halloween favorites', 'description' => '', 'slugs' => array(), 'ids' => array() ),
	);
	if ( 'halloween' !== $category ) {
		$groups['babies']['description'] = 'Infant tees and bodysuits for your littlest fans.';
		$groups['kids']['description'] = 'Everyday favorites for little adventures.';
		$groups['youth']['description'] = 'Familiar characters and fresh looks for bigger kids.';
		$groups['adults']['description'] = 'Nostalgic favorites in grown-up sizes.';
		$groups['more']['title'] = 'More collection favorites';
	}
	$ids = get_posts( array(
		'post_type' => 'product', 'post_status' => 'publish', 'numberposts' => -1,
		'fields' => 'ids', 'orderby' => 'title', 'order' => 'ASC',
		'tax_query' => array( array( 'taxonomy' => 'product_cat', 'field' => 'slug', 'terms' => sanitize_title( $category ) ) ),
	) );
	foreach ( $ids as $id ) {
		$product = wc_get_product( $id );
		if ( ! $product || ! $product->is_visible() ) {
			continue;
		}
		$terms = wp_get_object_terms( $id, 'product_cat' );
		$slugs = array();
		foreach ( $terms as $term ) {
			$slugs[] = $term->slug;
			foreach ( get_ancestors( $term->term_id, 'product_cat', 'taxonomy' ) as $ancestor ) {
				$parent = get_term( $ancestor, 'product_cat' );
				if ( $parent && ! is_wp_error( $parent ) ) {
					$slugs[] = $parent->slug;
				}
			}
		}
		$matched = 'more';
		foreach ( array( 'babies', 'youth', 'kids', 'adults' ) as $key ) {
			if ( array_intersect( $slugs, $groups[ $key ]['slugs'] ) ) {
				$matched = $key;
				break;
			}
		}
		$groups[ $matched ]['ids'][] = $id;
	}
	return array_filter( $groups, function ( $group ) { return ! empty( $group['ids'] ); } );
}

add_shortcode( 'diggityjr_collection', function ( $attributes ) {
	if ( ! function_exists( 'wc_get_product' ) ) {
		return '';
	}
	$attributes = shortcode_atts( array( 'category' => 'halloween' ), $attributes, 'diggityjr_collection' );
	$category = sanitize_title( $attributes['category'] );
	$settings = diggityjr_collection_settings();
	if ( ! isset( $settings[ $category ] ) ) {
		return '';
	}
	$groups = diggityjr_collection_groups( $category );
	ob_start();
	?>
	<div class="dj-collection">
		<p class="dj-collection-intro"><?php echo esc_html( $settings[ $category ]['intro'] ); ?></p>
		<?php if ( $groups ) : ?>
		<nav class="dj-collection-ages" aria-label="Shop collection by age">
			<?php foreach ( $groups as $key => $group ) : ?>
				<a href="#<?php echo esc_attr( $category ); ?>-<?php echo esc_attr( $key ); ?>"><?php echo esc_html( $group['title'] ); ?></a>
			<?php endforeach; ?>
		</nav>
		<p class="dj-collection-help">Shop by age, then choose your size and color on the product page.</p>
		<?php foreach ( $groups as $key => $group ) : ?>
		<section class="dj-collection-group" id="<?php echo esc_attr( $category ); ?>-<?php echo esc_attr( $key ); ?>" aria-labelledby="<?php echo esc_attr( $category ); ?>-heading-<?php echo esc_attr( $key ); ?>">
			<h2 id="<?php echo esc_attr( $category ); ?>-heading-<?php echo esc_attr( $key ); ?>"><?php echo esc_html( $group['title'] ); ?></h2>
			<p><?php echo esc_html( $group['description'] ); ?></p>
			<?php echo do_shortcode( '[products ids="' . implode( ',', array_map( 'absint', $group['ids'] ) ) . '" columns="3" orderby="title" order="ASC" paginate="false"]' ); ?>
		</section>
		<?php endforeach; ?>
		<?php else : ?>
		<p>New collection favorites are on the way. Check back soon.</p>
		<?php endif; ?>
	</div>
	<?php
	return ob_get_clean();
} );

add_action( 'wp_head', function () {
	$settings = diggityjr_collection_settings();
	$setting = null;
	foreach ( $settings as $candidate ) {
		if ( is_page( $candidate['page'] ) ) {
			$setting = $candidate;
			break;
		}
	}
	if ( ! $setting ) {
		return;
	}
	?>
	<meta name="description" content="<?php echo esc_attr( $setting['meta'] ); ?>">
	<style>
	.dj-collection{max-width:1170px;margin:0 auto;padding:0 24px 64px}
	.dj-collection-intro{text-align:center;font-size:20px;max-width:720px;margin:0 auto 24px;line-height:1.6}
	.dj-collection-ages{display:flex;flex-wrap:wrap;justify-content:center;gap:12px;margin:24px 0}
	.dj-collection-ages a{display:inline-block;padding:12px 26px;border:1px solid #d6c8bb;border-radius:3px;background:#faf6f1;color:#24201d;font-weight:700}
	.dj-collection-ages a:hover,.dj-collection-ages a:focus-visible{background:#24201d;color:#fff;border-color:#24201d}
	.dj-collection-help{text-align:center;color:#615a54;margin:0 0 48px}
	.dj-collection-group{clear:both;scroll-margin-top:140px;padding-top:30px;margin-top:32px;border-top:1px solid #e8dfd6}
	.dj-collection-group h2{font-size:30px;margin-bottom:8px}
	.dj-collection-group>.woocommerce{margin-top:24px}
	@media(max-width:640px){.dj-collection{padding:0 16px 40px}.dj-collection-intro{font-size:18px}.dj-collection-ages a{padding:10px 18px}.dj-collection-group{scroll-margin-top:100px}}
	</style>
	<?php
} );
