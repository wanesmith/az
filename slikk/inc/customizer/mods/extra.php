<?php
/**
 * Slikk extra
 *
 * @package WordPress
 * @subpackage Slikk
 * @version 1.4.2
 */

defined( 'ABSPATH' ) || exit;

/**
 * Extra mods
 *
 * @param array $mods Array of mods.
 * @return array
 */
function slikk_set_extra_mods( $mods ) {

	$mods['extra'] = array(

		'id'      => 'extra',
		'title'   => esc_html__( 'Extra', 'slikk' ),
		'icon'    => 'plus-alt',
		'options' => array(
			array(
				'label' => esc_html__( 'Enable Scroll Animations on Mobile (not recommended)', 'slikk' ),
				'id'    => 'enable_mobile_animations',
				'type'  => 'checkbox',
			),
			array(
				'label' => esc_html__( 'Enable Parallax on Mobile (not recommended)', 'slikk' ),
				'id'    => 'enable_mobile_parallax',
				'type'  => 'checkbox',
			),
		),
	);
	return $mods;
}
add_filter( 'slikk_customizer_mods', 'slikk_set_extra_mods' );
