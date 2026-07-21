<?php
/**
 * ACF blocks: custom editor categories + a single registry.
 *
 * Templates live in blocks/<category>/<name>.php (folder = editor category).
 * Field groups come from acf-json/ (one group per block, location: block).
 * Per-block assets: list registered handles in 'assets' — they are enqueued
 * only on pages where the block is actually present.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Theme block categories, shown above the core ones in the inserter.
 */
add_filter( 'block_categories_all', 'ccn_block_categories' );
function ccn_block_categories( $categories ) {
	$custom = array(
		array(
			'slug'  => 'ccn-banners',
			'title' => __( 'COIN Banners', 'containertheme' ),
		),
		array(
			'slug'  => 'ccn-lists',
			'title' => __( 'COIN Lists', 'containertheme' ),
		),
		array(
			'slug'  => 'ccn-products',
			'title' => __( 'COIN Products', 'containertheme' ),
		),
		array(
			'slug'  => 'ccn-text',
			'title' => __( 'COIN Text', 'containertheme' ),
		),
	);
	return array_merge( $custom, $categories );
}

add_action( 'acf/init', 'ccn_register_blocks' );
function ccn_register_blocks() {
	if ( ! function_exists( 'acf_register_block_type' ) ) {
		return;
	}

	$blocks = array(
		array(
			'name'        => 'home-hero',
			'title'       => __( 'Home hero', 'containertheme' ),
			'description' => __( 'Full-screen hero: background photo, dark gradient, big left-aligned heading.', 'containertheme' ),
			'category'    => 'ccn-banners',
			'icon'        => 'cover-image',
			'keywords'    => array( 'hero', 'banner', 'cover' ),
			'template'    => 'blocks/banners/home-hero.php',
		),
		array(
			'name'        => 'contact-cards',
			'title'       => __( 'Contact cards', 'containertheme' ),
			'description' => __( 'Email / phone / address cards fed by Site Settings (no own fields).', 'containertheme' ),
			'category'    => 'ccn-banners',
			'icon'        => 'id-alt',
			'keywords'    => array( 'contact', 'cards', 'email', 'phone' ),
			'template'    => 'blocks/banners/contact-cards.php',
		),
		array(
			'name'        => 'intro',
			'title'       => __( 'Intro', 'containertheme' ),
			'description' => __( 'Heading with a yellow accent line, bold subheading, text and a CTA button.', 'containertheme' ),
			'category'    => 'ccn-text',
			'icon'        => 'text-page',
			'keywords'    => array( 'intro', 'text', 'heading' ),
			'template'    => 'blocks/text/intro.php',
		),
		array(
			'name'        => 'text-section',
			'title'       => __( 'Text section', 'containertheme' ),
			'description' => __( 'Optional photo, heading with an inline yellow accent, rich text — landing content section.', 'containertheme' ),
			'category'    => 'ccn-text',
			'icon'        => 'editor-alignleft',
			'keywords'    => array( 'text', 'section', 'landing' ),
			'template'    => 'blocks/text/text-section.php',
		),
		array(
			'name'        => 'featured-products',
			'title'       => __( 'Featured products', 'containertheme' ),
			'description' => __( 'WooCommerce product grid: featured products or a chosen category.', 'containertheme' ),
			'category'    => 'ccn-products',
			'icon'        => 'products',
			'keywords'    => array( 'products', 'woocommerce', 'grid' ),
			'template'    => 'blocks/products/featured-products.php',
		),
		array(
			'name'        => 'text-image',
			'title'       => __( 'Text + image', 'containertheme' ),
			'description' => __( 'Heading, text, bold highlight and CTA on the left; photo collage on the right.', 'containertheme' ),
			'category'    => 'ccn-text',
			'icon'        => 'align-pull-right',
			'keywords'    => array( 'text', 'image', 'collage' ),
			'template'    => 'blocks/text/text-image.php',
		),
		array(
			'name'        => 'services',
			'title'       => __( 'Services strip', 'containertheme' ),
			'description' => __( 'Accent heading and a full-width photo strip with numbered service columns.', 'containertheme' ),
			'category'    => 'ccn-banners',
			'icon'        => 'columns',
			'keywords'    => array( 'services', 'strip', 'numbers' ),
			'template'    => 'blocks/banners/services.php',
		),
		array(
			'name'        => 'stats',
			'title'       => __( 'Stats', 'containertheme' ),
			'description' => __( 'Centered accent heading with animated counters.', 'containertheme' ),
			'category'    => 'ccn-lists',
			'icon'        => 'chart-bar',
			'keywords'    => array( 'stats', 'numbers', 'counters' ),
			'template'    => 'blocks/lists/stats.php',
		),
		array(
			'name'        => 'cta-banner',
			'title'       => __( 'CTA banner', 'containertheme' ),
			'description' => __( 'Full-width photo banner with logo, heading and a yellow button.', 'containertheme' ),
			'category'    => 'ccn-banners',
			'icon'        => 'megaphone',
			'keywords'    => array( 'cta', 'banner' ),
			'template'    => 'blocks/banners/cta-banner.php',
		),
		array(
			'name'        => 'info-cards',
			'title'       => __( 'Info cards', 'containertheme' ),
			'description' => __( 'White cards in a grid: photo, title, text (accessory trio of the original).', 'containertheme' ),
			'category'    => 'ccn-lists',
			'icon'        => 'grid-view',
			'keywords'    => array( 'cards', 'grid', 'info' ),
			'template'    => 'blocks/lists/info-cards.php',
		),
		array(
			'name'        => 'numbered-list',
			'title'       => __( 'Numbered list', 'containertheme' ),
			'description' => __( 'Accent heading with numbered items (01, 02, …).', 'containertheme' ),
			'category'    => 'ccn-lists',
			'icon'        => 'editor-ol',
			'keywords'    => array( 'numbered', 'list', 'steps' ),
			'template'    => 'blocks/lists/numbered-list.php',
		),
		array(
			'name'        => 'news',
			'title'       => __( 'News', 'containertheme' ),
			'description' => __( 'Latest posts as cards with category badges and dates.', 'containertheme' ),
			'category'    => 'ccn-lists',
			'icon'        => 'admin-post',
			'keywords'    => array( 'news', 'posts', 'blog' ),
			'template'    => 'blocks/lists/news.php',
		),
	);

	foreach ( $blocks as $block ) {
		$args = array(
			'name'            => $block['name'],
			'title'           => $block['title'],
			'description'     => $block['description'] ?? '',
			'category'        => $block['category'] ?? 'ccn-banners',
			'icon'            => $block['icon'] ?? 'block-default',
			'keywords'        => $block['keywords'] ?? array(),
			'mode'            => 'preview',
			'supports'        => array(
				'align'  => false,
				'anchor' => true,
				'jsx'    => false,
			),
			'render_template' => $block['template'],
		);

		if ( ! empty( $block['assets'] ) ) {
			$handles                = $block['assets'];
			$args['enqueue_assets'] = function () use ( $handles ) {
				foreach ( $handles as $handle ) {
					if ( wp_script_is( $handle, 'registered' ) ) {
						wp_enqueue_script( $handle );
					}
					if ( wp_style_is( $handle, 'registered' ) ) {
						wp_enqueue_style( $handle );
					}
				}
			};
		}

		acf_register_block_type( $args );
	}
}
