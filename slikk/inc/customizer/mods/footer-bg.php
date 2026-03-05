<?php
/**
 * Slikk footer_bg
 *
 * @package WordPress
 * @subpackage Slikk
 * @version 1.4.2
 */

defined( 'ABSPATH' ) || exit;

/**
 * Footer background mods
 *
 * @param array $mods Array of mods.
 * @return array
 */
function slikk_set_footer_bg_mods( $mods ) {

	$mods['footer_bg'] = array(
		'id'         => 'footer_bg',
		'label'      => esc_html__( 'Footer Background', 'slikk' ),
		'background' => true,
		'font_color' => true,
		'icon'       => 'format-image',
	);

	return $mods;
}
add_filter( 'slikk_customizer_mods', 'slikk_set_footer_bg_mods' );
