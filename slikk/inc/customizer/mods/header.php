<?php
/**
 * Slikk header_settings
 *
 * @package WordPress
 * @subpackage Slikk
 * @version 1.4.2
 */

defined( 'ABSPATH' ) || exit;

function slikk_set_header_settings_mods( $mods ) {

	$mods['header_settings'] = array(

		'id'      => 'header_settings',
		'title'   => esc_html__( 'Header Layout', 'slikk' ),
		'icon'    => 'editor-table',
		'options' => array(

			'hero_layout'            => array(
				'label'     => esc_html__( 'Page Header Layout', 'slikk' ),
				'id'        => 'hero_layout',
				'type'      => 'select',
				'choices'   => array(
					'standard'   => esc_html__( 'Standard', 'slikk' ),
					'big'        => esc_html__( 'Big', 'slikk' ),
					'small'      => esc_html__( 'Small', 'slikk' ),
					'fullheight' => esc_html__( 'Full Height', 'slikk' ),
					'none'       => esc_html__( 'No header', 'slikk' ),
				),
				'transport' => 'postMessage',
			),

			'hero_background_effect' => array(
				'id'      => 'hero_background_effect',
				'label'   => esc_html__( 'Header Image Effect', 'slikk' ),
				'type'    => 'select',
				'choices' => array(
					'parallax' => esc_html__( 'Parallax', 'slikk' ),
					'zoomin'   => esc_html__( 'Zoom', 'slikk' ),
					'none'     => esc_html__( 'None', 'slikk' ),
				),
			),

			'hero_scrolldown_arrow'  => array(
				'id'      => 'hero_scrolldown_arrow',
				'label'   => esc_html__( 'Scroll Down arrow', 'slikk' ),
				'type'    => 'select',
				'choices' => array(
					'yes' => esc_html__( 'Yes', 'slikk' ),
					''    => esc_html__( 'No', 'slikk' ),
				),
			),

			array(
				'label'   => esc_html__( 'Header Overlay', 'slikk' ),
				'id'      => 'hero_overlay',
				'type'    => 'select',
				'choices' => array(
					''       => esc_html__( 'Default', 'slikk' ),
					'custom' => esc_html__( 'Custom', 'slikk' ),
					'none'   => esc_html__( 'None', 'slikk' ),
				),
			),

			array(
				'label' => esc_html__( 'Overlay Color', 'slikk' ),
				'id'    => 'hero_overlay_color',
				'type'  => 'color',
				'value' => '#000000',
			),

			array(
				'label' => esc_html__( 'Overlay Opacity (in percent)', 'slikk' ),
				'id'    => 'hero_overlay_opacity',
				'desc'  => esc_html__( 'Adapt the header overlay opacity if needed', 'slikk' ),
				'type'  => 'text',
				'value' => 40,
			),
		),
	);

	if ( class_exists( 'Wolf_Vc_Content_Block' ) ) {
		$mods['header_settings']['options']['hero_layout']['description'] = sprintf(
			slikk_kses(
				__( 'The header can be overwritten by a <a href="%s" target="_blank">content block</a> on all pages or on specific pages. See the customizer "Layout" tab or the page options below your text editor.', 'slikk' )
			),
			'http://wlfthm.es/content-blocks'
		);
	}

	return $mods;
}
add_filter( 'slikk_customizer_mods', 'slikk_set_header_settings_mods' );
