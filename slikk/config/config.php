<?php
/**
 * Theme configuration file
 *
 * @package WordPress
 * @subpackage Slikk
 * @version 1.4.2
 */

/**
 * Default Google fonts option
 */
function slikk_set_default_google_font() {
	return 'Lato:400,700|Oswald:400,500,700,800|Playfair+Display:400,700';
}
add_filter( 'slikk_default_google_fonts', 'slikk_set_default_google_font' );

/**
 * Set color scheme
 *
 * Add csutom color scheme
 *
 * @param array $color_scheme
 * @param array $color_scheme
 */
function slikk_set_color_schemes( $color_scheme ) {

	//unset( $color_scheme['default'] );

	$color_scheme['light'] = array(
		'label'  => esc_html__( 'Light', 'slikk' ),
		'colors' => array(
			'#000000', // body_bg
			'#ffffff', // page_bg
			'#ededed', // submenu_background_color
			'#000000', // submenu_font_color
			'#eb3d33', // '#c3ac6d', // accent
			'#444444', // main_text_color
			'#4c4c4c', // secondary_text_color
			'#0d0d0d', // strong_text_color
			'#d19433', // secondary accent
		)
	);

	$color_scheme['dark'] = array(
		'label'  => esc_html__( 'Dark', 'slikk' ),
		'colors' => array(
			'#1B1B1B', // body_bg
			'#232322', // page_bg
			'#1C1829', // submenu_background_color
			'#ffffff', // submenu_font_color
			'#c3ac6d', // accent
			'#f4f4f4', // main_text_color
			'#ffffff', // secondary_text_color
			'#ffffff', // strong_text_color
			'#FF396B', // secondary accent
		)
	);

	return $color_scheme;
}
add_filter( 'slikk_color_schemes', 'slikk_set_color_schemes' );

/**
 * Add additional theme support
 */
function slikk_additional_theme_support() {

	/**
	 * Enable WooCommerce support
	 */
	add_theme_support( 'woocommerce' );
}
add_action( 'after_setup_theme', 'slikk_additional_theme_support' );

/**
 * Set default WordPress option
 */
function slikk_set_default_wp_options() {

	update_option( 'medium_size_w', 500 );
	update_option( 'medium_size_h', 286 );

	update_option( 'thread_comments_depth', 2 );
}
add_action( 'slikk_default_wp_options_init', 'slikk_set_default_wp_options' );

/**
 * Filter WooCommerce image sizes
 *
 * @param array $woocommerce_thumbnails
 * @param array $woocommerce_thumbnails
 */
function slikk_set_woocommerce_image_sizes( $woocommerce_thumbnails ) {

	$woocommerce_thumbnails = array(
		'catalog' => array(
			'width' 	=> '500',	// px
			'height'	=> '638',	// px
			'crop'	=> 1 		// true
		),

		'single' => array(
			'width' 	=> '1000',	// px
			'height'	=> '1276',	// px
			'crop'	=> 1 		// true
		),

		'thumbnail' => array(
			'width' 	=> '100',	// px
			'height'	=> '137',	// px
			'crop'	=> 1 // true
		),
	);

	return $woocommerce_thumbnails;
}
add_filter( 'slikk_woocommerce_thumbnail_sizes', 'slikk_set_woocommerce_image_sizes' );

/**
 * Set mod files to include
 */
function slikk_customizer_set_mod_files( $mod_files ) {
	$mod_files = array(
		'loading',
		'logo',
		'layout',
		'colors',
		'navigation',
		'socials',
		'fonts',
		'header',
		'header-image',
		'blog',
		'portfolio',
		'shop',
		'background-image',
		'footer',
		'footer-bg',
		'wvc',
		'extra',
	);

	return $mod_files;
}
add_filter( 'slikk_customizer_mod_files', 'slikk_customizer_set_mod_files' );