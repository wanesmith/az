<?php
/**
 * Slikk plugin extend functions
 *
 * @package WordPress
 * @subpackage Slikk
 * @version 1.4.2
 */

defined( 'ABSPATH' ) || exit;

if ( ! function_exists( 'slikk_set_albums_template_url' ) ) {
	/**
	 * Set albums template folder
	 *
	 * @param string $template_url
	 * @return void
	 */
	function slikk_set_albums_template_url( $template_url ) {

		return slikk_get_template_url() . '/albums/';

	}
	add_filter( 'wolf_albums_url', 'slikk_set_albums_template_url' );
}

if ( ! function_exists( 'slikk_set_artists_template_url' ) ) {
	/**
	 * Set artists template folder
	 *
	 * @param string $template_url
	 * @return void
	 */
	function slikk_set_artists_template_url( $template_url ) {

		return slikk_get_template_dirname() . '/artists/';
	}
	add_filter( 'wolf_artists_template_folder', 'slikk_set_artists_template_url' );
}

if ( ! function_exists( 'slikk_set_discography_template_url' ) ) {
	/**
	 * Set discography template folder
	 *
	 * @param string $template_url
	 * @return void
	 */
	function slikk_set_discography_template_url( $template_url ) {

		return slikk_get_template_url() . '/discography/';
	}
	add_filter( 'wolf_discography_template_url', 'slikk_set_discography_template_url' );
	add_filter( 'wolf_discography_url', 'slikk_set_discography_template_url' );
}

if ( ! function_exists( 'slikk_set_events_template_url' ) ) {
	/**
	 * Set events template folder
	 *
	 * @param string $template_url
	 * @return void
	 */
	function slikk_set_events_template_url( $template_url ) {

		return slikk_get_template_url() . '/events/';
	}
	add_filter( 'wolf_events_template_url', 'slikk_set_events_template_url' );
}

if ( ! function_exists( 'slikk_set_portfolio_template_url' ) ) {
	/**
	 * Set portfolio template folder
	 *
	 * @param string $template_url
	 * @return void
	 */
	function slikk_set_portfolio_template_url( $template_url ) {

		return slikk_get_template_url() . '/portfolio/';
	}
	add_filter( 'wolf_portfolio_template_url', 'slikk_set_portfolio_template_url' );
}

if ( ! function_exists( 'slikk_set_videos_template_url' ) ) {
	/**
	 * Set videos template folder
	 *
	 * @param string $template_url
	 * @return void
	 */
	function slikk_set_videos_template_url( $template_url ) {

		return slikk_get_template_url() . '/videos/';
	}
	add_filter( 'wolf_videos_template_url', 'slikk_set_videos_template_url' );
}

/**
 * Get single work layout
 *
 * @return string $layout
 */
function slikk_get_single_work_layout() {

	$single_work_layout = ( get_post_meta( get_the_ID(), '_single_work_layout', true ) ) ? get_post_meta( get_the_ID(), '_single_work_layout', true ) : 'small-width';

	if ( is_singular( 'work' ) ) {
		return apply_filters( 'slikk_single_work_layout', $single_work_layout );
	}
}

/**
 * Filter add to wishlist button class
 *
 * @return string $layout
 */
function slikk_filter_addo_to_wishlist_button_class( $class ) {

	$class = str_replace( 'button', '', $class );

	return $class;
}
add_filter( 'wolf_add_to_wishlist_class', 'slikk_filter_addo_to_wishlist_button_class' );

/**
 * Set Wolf Gram widget lightbox
 *
 * @return string $lightbox
 */
function slikk_set_wolf_gram_lightbox( $lightbox ) {

	return 'fancybox';
}
add_filter( 'wolf_gram_lightbox', 'slikk_set_wolf_gram_lightbox' );

/**
 * Filter ticket link CSS class
 *
 * @param string $class
 * @param string $class
 */
function slikk_filter_ticket_link_css_class( $class ) {
	return 'button ticket-button';
}
add_filter( 'we_ticket_link_class', 'slikk_filter_ticket_link_css_class' );
