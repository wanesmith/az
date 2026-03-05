<?php
/**
 * Slikk Fonts helper
 *
 * This file will be enqueued in the admin and front-end
 *
 * @package WordPress
 * @subpackage Slikk
 * @version 1.4.2
 */

defined( 'ABSPATH' ) || exit;

if ( slikk_is_elementor_fonts_enabled() ) {
	return;
}

/**
 * Get loaded google fonts as a clean array
 *
 * @return array
 */
function slikk_get_google_fonts_options() {

	$google_fonts = array();

	$font_option = ( slikk_get_option( 'font', 'google_fonts' ) ) ? slikk_get_option( 'font', 'google_fonts' ) . '|' : null;

	if ( $font_option ) {

		$raw_fonts = explode( '|', preg_replace( '/\s+/', '', $font_option ) );

		foreach ( $raw_fonts as $font ) {

			$font_name = preg_replace( '/:[,0-9]+/', '', $font ); // replve font weight
			$font_name = str_replace( '+', ' ', $font_name );
			$font_name = str_replace( array( 'italic' ), '', $font_name );

			if ( '' !== $font_name ) {
				$google_fonts[ $font_name ] = $font;
			}
		}
	}

	return array_unique( apply_filters( 'slikk_google_fonts', $google_fonts ) );
}

/**
 * Get Google font URL
 */
function slikk_get_google_fonts_file_url() {

	$url = '';

	$google_fonts = slikk_get_google_fonts_options();

	if ( array() !== $google_fonts ) {

		$subsets = 'latin,latin-ext';

		$fonts = array_unique( $google_fonts );

		$browser_font_defaults = array(
			'Helvetica',
			'Arial',
			'Georgia',
			'Impact',
		);

		/* Unset non-google fonts from array */
		foreach ( $browser_font_defaults as $font_default ) {
			if ( isset( $fonts[ $font_default ] ) ) {
				unset( $fonts[ $font_default ] );
			}
		}

		/*
		 * Translators: To add an additional character subset specific to your language,
		 * translate this to 'greek', 'cyrillic', 'devanagari' or 'vietnamese'. Do not translate into your own language.
		 */
		$subset = _x( 'no-subset', 'Add new subset (greek, cyrillic, devanagari, vietnamese)', 'slikk' );

		if ( 'cyrillic' === $subset ) {
			$subsets .= ',cyrillic,cyrillic-ext';
		} elseif ( 'greek' === $subset ) {
			$subsets .= ',greek,greek-ext';
		} elseif ( 'devanagari' === $subset ) {
			$subsets .= ',devanagari';
		} elseif ( 'vietnamese' === $subset ) {
			$subsets .= ',vietnamese';
		}

		$url = add_query_arg(
			array(
				'family' => implode( rawurlencode( '|' ), $fonts ),
				'subset' => $subsets,
			),
			'https://fonts.googleapis.com/css'
		);

		return esc_url( $url );
	}
}

/**
 * Loads our special font CSS file.
 */
function slikk_enqueue_google_fonts() {

	/* Dequeue WVC fonts to avoid duplicated as Google Fonts option is sync with WVC */
	wp_dequeue_style( 'wvc-google-fonts' );
	wp_dequeue_style( 'wolf-core-google-fonts' );

	if ( slikk_get_google_fonts_file_url() ) {
		wp_enqueue_style( 'slikk-google-fonts', slikk_get_google_fonts_file_url(), array(), slikk_get_theme_version() );
	}
}
add_action( 'admin_enqueue_scripts', 'slikk_enqueue_google_fonts' ); // enqueue google font CSS in admin.
add_action( 'wp_enqueue_scripts', 'slikk_enqueue_google_fonts' ); // enqueue google font CSS in frontend.

/**
 * Filter the customizer settings to add your fonts to the list
 *
 * @param array $fonts The Typekit fonts option array.
 * @return array $fonts
 */
function slikk_add_typekit_fonts( $fonts ) {

	$typekit_fonts_option = ( slikk_get_option( 'font', 'typekit_fonts' ) ) ? slikk_get_option( 'font', 'typekit_fonts' ) . '|' : null;

	if ( $typekit_fonts_option ) {

		$raw_fonts = explode( '|', $typekit_fonts_option );

		foreach ( $raw_fonts as $font_name ) {

			if ( '' !== $font_name ) {
				$font_slug           = sanitize_title( $font_name );
				$fonts[ $font_slug ] = $font_name;
			}
		}
	}

	$fonts = array_unique( $fonts );

	return $fonts;
}
add_filter( 'slikk_mods_fonts', 'slikk_add_typekit_fonts' ); // add the fonts to the customizer.
add_filter( 'wvc_fonts', 'slikk_add_typekit_fonts' ); // add the fonts to the old Page Builder extension settings.
add_filter( 'wolf_core_fonts', 'slikk_add_typekit_fonts' ); // add the fonts to the new Page Builder extension settings.

/**
 * Add preconnect for Google Fonts.
 *
 * @param array  $urls           URLs to print for resource hints.
 * @param string $relation_type  The relation type the URLs are printed.
 * @return array $urls           URLs to print for resource hints.
 */
function slikk_resource_hints( $urls, $relation_type ) {

	if ( wp_style_is( 'slikk-google-fonts', 'queue' ) && 'preconnect' === $relation_type ) {
		$urls[] = array(
			'href' => 'https://fonts.gstatic.com',
			'crossorigin',
		);
	}

	return $urls;
}
add_filter( 'wp_resource_hints', 'slikk_resource_hints', 10, 2 );
