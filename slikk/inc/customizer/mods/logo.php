<?php
/**
 * Slikk customizer logo mods
 *
 * @package WordPress
 * @subpackage Slikk
 * @version 1.4.2
 */

defined( 'ABSPATH' ) || exit;

/**
 * Logo mods
 *
 * @param array $mods Array of mods.
 * @return array
 */
function slikk_set_logo_mods( $mods ) {

	$mods['logo'] = array(
		'id'          => 'logo',
		'title'       => esc_html__( 'Logo', 'slikk' ),
		'icon'        => 'visibility',
		'description' => sprintf(
			wp_kses(
				__( 'Your theme recommends a logo size of <strong>%1$d &times; %2$d</strong> pixels and set the maximum width to <strong>%3$d</strong> below.', 'slikk' ),
				array(
					'strong' => array(),
				)
			),
			360,
			160,
			180
		),
		'options'     => array(

			'logo_dark'       => array(
				'id'    => 'logo_dark',
				'label' => esc_html__( 'Logo - Dark Version', 'slikk' ),
				'type'  => 'image',
			),

			'logo_light'      => array(
				'id'    => 'logo_light',
				'label' => esc_html__( 'Logo - Light Version', 'slikk' ),
				'type'  => 'image',
			),

			'logo_max_width'  => array(
				'id'    => 'logo_max_width',
				'label' => esc_html__( 'Logo Max Width (don\'t ommit px )', 'slikk' ),
				'type'  => 'text',
			),

			'logo_visibility' => array(
				'id'        => 'logo_visibility',
				'label'     => esc_html__( 'Visibility', 'slikk' ),
				'type'      => 'select',
				'choices'   => array(
					'always'      => esc_html__( 'Always', 'slikk' ),
					'sticky_menu' => esc_html__( 'When menu is sticky only', 'slikk' ),
				),
				'transport' => 'postMessage',
			),
		),
	);

	return $mods;

}
add_filter( 'slikk_customizer_mods', 'slikk_set_logo_mods' );
