<?php
/**
 * Functions which enhance the theme by hooking into WordPress
 *
 * @package CMK_Phra.in
 */

/**
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 * @return array
 */
function cmk_pi_body_classes( $classes ) {
	// Adds a class of hfeed to non-singular pages.
	if ( ! is_singular() ) {
		$classes[] = 'hfeed';
	}

	// Adds a class of no-sidebar when there is no sidebar present.
	if ( ! is_active_sidebar( 'sidebar-1' ) ) {
		$classes[] = 'no-sidebar';
	}

	return $classes;
}
add_filter( 'body_class', 'cmk_pi_body_classes' );

/**
 * Add a pingback url auto-discovery header for single posts, pages, or attachments.
 */
function cmk_pi_pingback_header() {
	if ( is_singular() && pings_open() ) {
		printf( '<link rel="pingback" href="%s">', esc_url( get_bloginfo( 'pingback_url' ) ) );
	}
	printf('<script>
	window.apiurl = "'.site_url().'/wp-json/wp/v2";
	</script>');
}
add_action( 'wp_head', 'cmk_pi_pingback_header' );

function enqueue_assets()
{
    // wp_enqueue_script('rx', get_template_directory_uri().'/dist/index.js?time='.time());
		wp_enqueue_style('rx', get_template_directory_uri().'/dist/style.css?time='.time());
}
add_action('wp_footer', 'enqueue_assets');