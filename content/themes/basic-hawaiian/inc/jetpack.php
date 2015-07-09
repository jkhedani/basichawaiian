<?php
/**
 * Jetpack Compatibility File
 * See: https://jetpack.me/
 *
 * @package Basic Hawaiian
 */

/**
 * Add theme support for Infinite Scroll.
 * See: https://jetpack.me/support/infinite-scroll/
 */
function basic_hawaiian_jetpack_setup() {
	add_theme_support( 'infinite-scroll', array(
		'container' => 'main',
		'render'    => 'basic_hawaiian_infinite_scroll_render',
		'footer'    => 'page',
	) );
} // end function basic_hawaiian_jetpack_setup
add_action( 'after_setup_theme', 'basic_hawaiian_jetpack_setup' );

function basic_hawaiian_infinite_scroll_render() {
	while ( have_posts() ) {
		the_post();
		get_template_part( 'template-parts/content', get_post_format() );
	}
} // end function basic_hawaiian_infinite_scroll_render