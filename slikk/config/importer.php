<?php
/**
 * Slikk demo importer
 *
 * @package WordPress
 * @subpackage Slikk
 * @since Slikk 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

/**
 * Demo files
 *
 * @see http://proteusthemes.github.io/one-click-demo-import/
 */
function slikk_import_files() {

	$theme_slug = slikk_get_theme_slug();
	$domain_name = 'https://updates.wolfthemes.com';
	$root_url = $domain_name . '/' . $theme_slug . '/demos';

	return array(
		array(
			'import_file_name' => esc_html__( 'All Demo Pages', 'slikk' ),
			'categories' => array( esc_html__( 'Standard', 'slikk' ) ),
			'import_file_url' => esc_url( $root_url ) . '/main/content.xml',
			'import_widget_file_url' => esc_url( $root_url ) . '/main/widgets.wie',
			'import_customizer_file_url' => esc_url( $root_url ) . '/main/customizer.dat',
			'import_preview_image_url' => esc_url( $root_url ) . '/main/preview.jpg',
		),
	);
}
add_filter( 'pt-ocdi/import_files', 'slikk_import_files' );

/**
 * Set menus after import
 */
function slikk_after_import_setup() {

	// Assign menus to their locations.
	slikk_set_menu_locations(
		array(
			'primary' => 'Primary Menu',
			'secondary' => 'Secondary Menu',
			//'tertiary' => 'Tertiary Menu',
		)
	);
}
add_action( 'pt-ocdi/after_import', 'slikk_after_import_setup' );
