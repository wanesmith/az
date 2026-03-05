<?php
/**
 * Slikk admin activation
 *
 * @package WordPress
 * @subpackage Slikk
 * @version 1.4.2
 */

defined( 'ABSPATH' ) || exit;

/**
 * Hook WWPBPBE plugin activation to save theme fonts in plugins settings
 *
 * Import the default fonts from the theme in the page builder settings
 *
 * @param array $settings The WVC settings array.
 */
function slikk_set_page_builder_default_google_fonts( $settings ) {

	/* Get theme fonts */
	$theme_google_font_option = slikk_get_option( 'fonts', 'google_fonts' );

	if ( $theme_google_font_option ) {

		$settings['fonts']['google_fonts'] = $theme_google_font_option;
	}

	return $settings;
}
add_filter( 'wvc_default_settings', 'slikk_set_page_builder_default_google_fonts' );
add_filter( 'wolf_core_default_settings', 'slikk_set_page_builder_default_google_fonts' );

/**
 * Get all social networks URL from plugin if plugin is installed before the theme
 *
 * @param array $mods The theme mods.
 * @return array $mods
 */
function slikk_set_default_social_networks( $mods ) {

	if ( function_exists( 'wvc_get_socials' ) ) {
		$wvc_socials = wvc_get_socials();

		foreach ( $wvc_socials as $service ) {
			$link = wolf_vc_get_option( 'socials', $service );

			if ( $link ) {
				set_theme_mod( $service, $link );
			}
		}
	}

	if ( function_exists( 'wolf_core_get_socials' ) ) {
		$wolf_core_socials = wolf_core_get_socials();

		foreach ( $wolf_core_socials as $service ) {
			$link = wolf_core_get_option( 'socials', $service );

			if ( $link ) {
				set_theme_mod( $service, $link );
			}
		}
	}

	return $mods;
}
add_filter( 'slikk_default_mods', 'slikk_set_default_social_networks' );

/**
 * Define WooCommerce image sizes on theme activation
 *
 * Can be overwritten with the slikk_woocommerce_thumbnail_sizes filter
 */
function slikk_woocommerce_image_sizes() {

	global $pagenow;

	if ( ! isset( $_GET['activated'] ) || 'themes.php' !== $pagenow ) { // phpcs:ignore WordPress.Security.NonceVerification
		return;
	}

	$woocommerce_thumbnails = apply_filters(
		'slikk_woocommerce_thumbnail_sizes',
		array(
			'catalog'   => array(
				'width'  => '400',
				'height' => '400',
				'crop'   => 1,
			),

			'single'    => array(
				'width'  => '600',
				'height' => '600',
				'crop'   => 1,
			),

			'thumbnail' => array(
				'width'  => '120',
				'height' => '120',
				'crop'   => 0,
			),
		)
	);

	/* Image sizes */
	update_option( 'shop_catalog_image_size', $woocommerce_thumbnails['catalog'] ); // Product category thumbs.
	update_option( 'shop_single_image_size', $woocommerce_thumbnails['single'] ); // Single product image.
	update_option( 'shop_thumbnail_image_size', $woocommerce_thumbnails['thumbnail'] ); // Image gallery thumbs.

	/* Enable ajax cart */
	update_option( 'woocommerce_enable_ajax_add_to_cart', 'yes' );

	/* Disable WooCommerce lightbox so we can handle it */
	update_option( 'woocommerce_enable_lightbox', 'no' );
}
add_action( 'after_switch_theme', 'slikk_woocommerce_image_sizes', 1 );

/**
 * Set default WP options on theme activation
 */
function slikk_default_wp_options_init() {

	if ( ! get_option( slikk_get_theme_slug() . '_wp_options_init' ) ) {

		/**
		 * A custom hook to set default options on theme activation
		 */
		do_action( 'slikk_wp_default_options_init' );

		/*
		 * Another custom hook to set default 3rd party plugin options on theme activation
		 */
		do_action( 'slikk_plugins_default_options_init' );

		/* Default WP options */
		update_option( 'image_default_link_type', 'file' );

		/* Add option to flag that the default mods have been set */
		add_option( slikk_get_theme_slug() . '_wp_options_init', true );

		update_option( 'wpb_js_gutenberg_disable', true );
	}
}
add_action( 'init', 'slikk_default_wp_options_init' );
