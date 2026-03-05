<?php
/**
 * Slikk background_image
 *
 * @package WordPress
 * @subpackage Slikk
 * @version 1.4.2
 */

defined( 'ABSPATH' ) || exit;

/**
 * Backgorund image mods
 *
 * @param array $mods Array of mods.
 * @return array
 */
function slikk_set_background_image_mods( $mods ) {

	/* Move background image setting here and rename the seciton title */
	$mods['background_image'] = array(
		'icon'    => 'format-image',
		'id'      => 'background_image',
		'title'   => esc_html__( 'Background Image', 'slikk' ),
		'options' => array(),
	);

	return $mods;
}
add_filter( 'slikk_customizer_mods', 'slikk_set_background_image_mods' );
