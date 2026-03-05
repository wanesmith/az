<?php
/**
 * Slikk header_image
 *
 * @package WordPress
 * @subpackage Slikk
 * @version 1.4.2
 */

defined( 'ABSPATH' ) || exit;

/**
 * Header image mods
 *
 * @param array $mods Array of mods.
 * @return array
 */
function slikk_set_header_image_mods( $mods ) {

	/* Move header image setting here and rename the section title */
	$mods['header_image'] = array(
		'id'      => 'header_image',
		'title'   => esc_html__( 'Header Image', 'slikk' ),
		'icon'    => 'format-image',
		'options' => array(),
	);

	return $mods;
}
add_filter( 'slikk_customizer_mods', 'slikk_set_header_image_mods' );
