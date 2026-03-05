<?php
/**
 * Slikk customizer font mods
 *
 * @package WordPress
 * @subpackage Slikk
 * @version 1.4.2
 */

defined( 'ABSPATH' ) || exit;

/**
 * Font mods
 *
 * @param array $mods Array of mods.
 * @return array
 */
function slikk_set_font_mods( $mods ) {

	$mods['fonts'] = array(
		'id'      => 'fonts',
		'title'   => esc_html__( 'Fonts', 'slikk' ),
		'icon'    => 'editor-textcolor',
		'options' => array(),
	);

	if ( slikk_is_elementor_fonts_enabled() ) {

		$mods['fonts']['options']['no_font'] = array(
			'label'       => esc_html__( 'Theme Fonts Disabled', 'slikk' ),
			'id'          => 'no_font',
			'type'        => 'text_helper',
			'description' => sprintf(
				slikk_kses(
					__( 'Please disable the default fonts options in the <a href="%s" target="_blank">Elementor settings</a> to use the theme font options.', 'slikk' )
				),
				esc_url( admin_url( 'admin.php?page=elementor' ) )
			),
		);

		return $mods;
	}

	/**
	 * Get Google Fonts from Font loader
	 */
	$_fonts = apply_filters( 'slikk_mods_fonts', slikk_get_google_fonts_options() );

	$font_choices = array( 'default' => esc_html__( 'Default', 'slikk' ) );

	foreach ( $_fonts as $key => $value ) {
		$font_choices[ $key ] = $key;
	}

	$mods['fonts']['options']['body_font_name'] = array(
		'label'     => esc_html__( 'Body Font Name', 'slikk' ),
		'id'        => 'body_font_name',
		'type'      => 'select',
		'choices'   => $font_choices,
		'transport' => 'postMessage',
	);

	$mods['fonts']['options']['body_font_size'] = array(
		'label'       => esc_html__( 'Body Font Size', 'slikk' ),
		'id'          => 'body_font_size',
		'type'        => 'text',
		'transport'   => 'postMessage',
		'description' => esc_html__( 'Don\'t ommit px. Leave empty to use the default font size.', 'slikk' ),
	);

	/*************************Menu*/

	$mods['fonts']['options']['menu_font_name'] = array(
		'id'        => 'menu_font_name',
		'label'     => esc_html__( 'Menu Font', 'slikk' ),
		'type'      => 'select',
		'choices'   => $font_choices,
		'transport' => 'postMessage',
	);

	$mods['fonts']['options']['menu_font_weight'] = array(
		'label'     => esc_html__( 'Menu Font Weight', 'slikk' ),
		'id'        => 'menu_font_weight',
		'type'      => 'text',
		'transport' => 'postMessage',
	);

	$mods['fonts']['options']['menu_font_transform'] = array(
		'id'        => 'menu_font_transform',
		'label'     => esc_html__( 'Menu Font Transform', 'slikk' ),
		'type'      => 'select',
		'choices'   => array(
			'none'      => esc_html__( 'None', 'slikk' ),
			'uppercase' => esc_html__( 'Uppercase', 'slikk' ),
			'lowercase' => esc_html__( 'Lowercase', 'slikk' ),
		),
		'transport' => 'postMessage',
	);

	$mods['fonts']['options']['menu_font_letter_spacing'] = array(
		'label'     => esc_html__( 'Menu Letter Spacing (omit px)', 'slikk' ),
		'id'        => 'menu_font_letter_spacing',
		'type'      => 'int',
		'transport' => 'postMessage',
	);

	$mods['fonts']['options']['menu_font_style'] = array(
		'id'        => 'menu_font_style',
		'label'     => esc_html__( 'Menu Font Style', 'slikk' ),
		'type'      => 'select',
		'choices'   => array(
			'normal'  => esc_html__( 'Normal', 'slikk' ),
			'italic'  => esc_html__( 'Italic', 'slikk' ),
			'oblique' => esc_html__( 'Oblique', 'slikk' ),
		),
		'transport' => 'postMessage',
	);

	$mods['fonts']['options']['submenu_font_name'] = array(
		'id'        => 'submenu_font_name',
		'label'     => esc_html__( 'Submenu Font', 'slikk' ),
		'type'      => 'select',
		'choices'   => $font_choices,
		'transport' => 'postMessage',
	);

	$mods['fonts']['options']['submenu_font_weight'] = array(
		'label'     => esc_html__( 'Submenu Font Weight', 'slikk' ),
		'id'        => 'submenu_font_weight',
		'type'      => 'text',
		'transport' => 'postMessage',
	);

	$mods['fonts']['options']['submenu_font_transform'] = array(
		'id'        => 'submenu_font_transform',
		'label'     => esc_html__( 'Submenu Font Transform', 'slikk' ),
		'type'      => 'select',
		'choices'   => array(
			'none'      => esc_html__( 'None', 'slikk' ),
			'uppercase' => esc_html__( 'Uppercase', 'slikk' ),
			'lowercase' => esc_html__( 'Lowercase', 'slikk' ),
		),
		'transport' => 'postMessage',
	);

	$mods['fonts']['options']['submenu_font_style'] = array(
		'id'        => 'submenu_font_style',
		'label'     => esc_html__( 'Submenu Font Style', 'slikk' ),
		'type'      => 'select',
		'choices'   => array(
			'normal'  => esc_html__( 'Normal', 'slikk' ),
			'italic'  => esc_html__( 'Italic', 'slikk' ),
			'oblique' => esc_html__( 'Oblique', 'slikk' ),
		),
		'transport' => 'postMessage',
	);

	$mods['fonts']['options']['submenu_font_letter_spacing'] = array(
		'label'     => esc_html__( 'Submenu Letter Spacing (omit px)', 'slikk' ),
		'id'        => 'submenu_font_letter_spacing',
		'type'      => 'int',
		'transport' => 'postMessage',
	);

	/*************************Heading*/

	$mods['fonts']['options']['heading_font_name'] = array(
		'id'        => 'heading_font_name',
		'label'     => esc_html__( 'Heading Font', 'slikk' ),
		'type'      => 'select',
		'choices'   => $font_choices,
		'transport' => 'postMessage',
	);

	$mods['fonts']['options']['heading_font_weight'] = array(
		'label'       => esc_html__( 'Heading Font weight', 'slikk' ),
		'id'          => 'heading_font_weight',
		'type'        => 'text',
		'description' => esc_html__( 'For example: "400" is normal, "700" is bold.The available font weights depend on the font.', 'slikk' ),
		'transport'   => 'postMessage',
	);

	$mods['fonts']['options']['heading_font_transform'] = array(
		'id'        => 'heading_font_transform',
		'label'     => esc_html__( 'Heading Font Transform', 'slikk' ),
		'type'      => 'select',
		'choices'   => array(
			'none'      => esc_html__( 'None', 'slikk' ),
			'uppercase' => esc_html__( 'Uppercase', 'slikk' ),
			'lowercase' => esc_html__( 'Lowercase', 'slikk' ),
		),
		'transport' => 'postMessage',
	);

	$mods['fonts']['options']['heading_font_style'] = array(
		'id'        => 'heading_font_style',
		'label'     => esc_html__( 'Heading Font Style', 'slikk' ),
		'type'      => 'select',
		'choices'   => array(
			'normal'  => esc_html__( 'Normal', 'slikk' ),
			'italic'  => esc_html__( 'Italic', 'slikk' ),
			'oblique' => esc_html__( 'Oblique', 'slikk' ),
		),
		'transport' => 'postMessage',
	);

	$mods['fonts']['options']['heading_font_letter_spacing'] = array(
		'label'     => esc_html__( 'Heading Letter Spacing (omit px)', 'slikk' ),
		'id'        => 'heading_font_letter_spacing',
		'type'      => 'int',
		'transport' => 'postMessage',
	);

	return $mods;

}
add_filter( 'slikk_customizer_mods', 'slikk_set_font_mods', 10 );
