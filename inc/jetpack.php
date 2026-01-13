<?php
/**
 * Jetpack Compatibility File
 *
 * @link https://jetpack.com/
 *
 * @package Studio_Snap_Theme
 */

/**
 * Jetpack setup function.
 *
 * See: https://jetpack.com/support/infinite-scroll/
 * See: https://jetpack.com/support/responsive-videos/
 * See: https://jetpack.com/support/content-options/
 */
function studio_snap_theme_jetpack_setup() {
	// Add theme support for Infinite Scroll.
	add_theme_support( 'infinite-scroll', array(
		'container' => 'main',
		'render'    => 'studio_snap_theme_infinite_scroll_render',
		'footer'    => 'page',
	) );

	// Add theme support for Responsive Videos.
	add_theme_support( 'jetpack-responsive-videos' );

	// Add theme support for Content Options.
	add_theme_support( 'jetpack-content-options', array(
		'post-details'    => array(
			'blog-display' => 'post-meta',
			'post-classes' => array( 'entry-utility', 'entry-content' ),
		),
		'featured-images' => array(
			'archive' => true,
			'single'  => true,
		),
		'jp-widgets'      => array(
			'widget-tags' => array(
				'selector'           => '.widget_tag_cloud a',
				'color'              => '.widget_tag_cloud a',
				'background'         => '.widget_tag_cloud a',
				'border'             => '.widget_tag_cloud a',
				'hover_color'        => '.widget_tag_cloud a:hover',
				'hover_background'   => '.widget_tag_cloud a:hover',
				'hover_border'       => '.widget_tag_cloud a:hover',
				'active_color'       => '.widget_tag_cloud a:active',
				'active_background'  => '.widget_tag_cloud a:active',
				'active_border'      => '.widget_tag_cloud a:active',
			),
		),
	) );
}
add_action( 'after_setup_theme', 'studio_snap_theme_jetpack_setup' );

/**
 * Custom render function for Infinite Scroll.
 */
function studio_snap_theme_infinite_scroll_render() {
	while ( have_posts() ) {
		the_post();
		if ( is_search() ) :
			get_template_part( 'template-parts/content', 'search' );
		else :
			get_template_part( 'template-parts/content', get_post_type() );
		endif;
	}
}