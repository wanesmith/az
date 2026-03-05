<?php
/**
 * Slikk customizer color mods
 *
 * @package WordPress
 * @subpackage Slikk
 * @version 1.4.2
 */

defined( 'ABSPATH' ) || exit;

/**
 * Color scheme mods
 *
 * @param array $mods Array of mods.
 * @return array
 */
function slikk_set_colors_mods( $mods ) {

	if ( slikk_is_elementor_colors_enabled() ) {

		$mods['colors'] = array(
			'id'      => 'colors',
			'icon'    => 'admin-customizer',
			'title'   => esc_html__( 'Colors', 'slikk' ),
			'options' => array(),
		);

		$mods['colors']['options']['no_color'] = array(
			'label'       => esc_html__( 'Theme Colors Disabled', 'slikk' ),
			'id'          => 'no_color',
			'type'        => 'text_helper',
			'description' => sprintf(
				slikk_kses(
					__( 'Please disable the default colors options in the <a href="%s" target="_blank">Elementor settings</a> to use the theme font options.', 'slikk' )
				),
				esc_url( admin_url( 'admin.php?page=elementor' ) )
			),
		);

		return $mods;
	}

	$color_scheme = slikk_get_color_scheme();

	$mods['colors'] = array(
		'id'      => 'colors',
		'icon'    => 'admin-customizer',
		'title'   => esc_html__( 'Colors', 'slikk' ),
		'options' => array(
			array(
				'label'     => esc_html__( 'Color scheme', 'slikk' ),
				'id'        => 'color_scheme',
				'type'      => 'select',
				'choices'   => slikk_get_color_scheme_choices(),
				'transport' => 'postMessage',
			),

			'body_background_color'    => array(
				'id'        => 'body_background_color',
				'label'     => esc_html__( 'Body Background Color', 'slikk' ),
				'type'      => 'color',
				'transport' => 'postMessage',
				'default'   => $color_scheme[0],
			),

			'page_background_color'    => array(
				'id'        => 'page_background_color',
				'label'     => esc_html__( 'Page Background Color', 'slikk' ),
				'type'      => 'color',
				'transport' => 'postMessage',
				'default'   => $color_scheme[1],
			),

			'submenu_background_color' => array(
				'id'        => 'submenu_background_color',
				'label'     => esc_html__( 'Submenu Background Color', 'slikk' ),
				'type'      => 'color',
				'transport' => 'postMessage',
				'default'   => $color_scheme[2],
			),

			array(
				'id'        => 'submenu_font_color',
				'label'     => esc_html__( 'Submenu Font Color', 'slikk' ),
				'type'      => 'color',
				'transport' => 'postMessage',
				'default'   => $color_scheme[3],
			),

			'accent_color'             => array(
				'id'        => 'accent_color',
				'label'     => esc_html__( 'Accent Color', 'slikk' ),
				'type'      => 'color',
				'transport' => 'postMessage',
				'default'   => $color_scheme[4],
			),

			array(
				'id'        => 'main_text_color',
				'label'     => esc_html__( 'Main Text Color', 'slikk' ),
				'type'      => 'color',
				'transport' => 'postMessage',
				'default'   => $color_scheme[5],
			),

			array(
				'id'          => 'strong_text_color',
				'label'       => esc_html__( 'Strong Text Color', 'slikk' ),
				'type'        => 'color',
				'transport'   => 'postMessage',
				'default'     => $color_scheme[7],
				'description' => esc_html__( 'Heading, "strong" tags etc...', 'slikk' ),
			),
		),
	);

	return $mods;

}
add_filter( 'slikk_customizer_mods', 'slikk_set_colors_mods' );
