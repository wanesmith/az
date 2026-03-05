<?php
/**
 * Slikk loading
 *
 * @package WordPress
 * @subpackage Slikk
 * @version 1.4.2
 */

defined( 'ABSPATH' ) || exit;

/**
 * Loading animation mods
 *
 * @param array $mods Array of mods.
 * @return array
 */
function slikk_set_loading_mods( $mods ) {

	$mods['loading'] = array(

		'id'      => 'loading',
		'title'   => esc_html__( 'Loading', 'slikk' ),
		'icon'    => 'update',
		'options' => array(

			array(
				'label'   => esc_html__( 'Loading Animation Type', 'slikk' ),
				'id'      => 'loading_animation_type',
				'type'    => 'select',
				'choices' => array(
					'spinner' => esc_html__( 'Spinner', 'slikk' ),
					'none'    => esc_html__( 'None', 'slikk' ),
				),
			),
		),
	);
	return $mods;
}
add_filter( 'slikk_customizer_mods', 'slikk_set_loading_mods' );
