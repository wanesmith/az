<?php
/**
 * Slikk footer
 *
 * @package WordPress
 * @subpackage Slikk
 * @version 1.4.2
 */

defined( 'ABSPATH' ) || exit;

/**
 * Footer mods
 *
 * @param array $mods Array of mods.
 * @return array
 */
function slikk_set_footer_mods( $mods ) {

	$mods['footer'] = array(

		'id'      => 'footer',
		'title'   => esc_html__( 'Footer', 'slikk' ),
		'icon'    => 'welcome-widgets-menus',
		'options' => array(

			'footer_type'    => array(
				'label'     => esc_html__( 'Footer Type', 'slikk' ),
				'id'        => 'footer_type',
				'type'      => 'select',
				'choices'   => array(
					'standard' => esc_html__( 'Standard', 'slikk' ),
					'uncover'  => esc_html__( 'Uncover', 'slikk' ),
					'hidden'   => esc_html__( 'No Footer', 'slikk' ),
				),
				'transport' => 'postMessage',
			),

			array(
				'label'     => esc_html__( 'Footer Width', 'slikk' ),
				'id'        => 'footer_layout',
				'type'      => 'select',
				'choices'   => array(
					'boxed' => esc_html__( 'Boxed', 'slikk' ),
					'wide'  => esc_html__( 'Wide', 'slikk' ),
				),
				'transport' => 'postMessage',
			),

			array(
				'label'     => esc_html__( 'Foot Widgets Layout', 'slikk' ),
				'id'        => 'footer_widgets_layout',
				'type'      => 'select',
				'choices'   => array(
					'3-cols'               => esc_html__( '3 Columns', 'slikk' ),
					'4-cols'               => esc_html__( '4 Columns', 'slikk' ),
					'one-half-two-quarter' => esc_html__( '1 Half/2 Quarters', 'slikk' ),
					'two-quarter-one-half' => esc_html__( '2 Quarters/1 Half', 'slikk' ),
				),
				'transport' => 'postMessage',
			),

			array(
				'label'     => esc_html__( 'Bottom Bar Layout', 'slikk' ),
				'id'        => 'bottom_bar_layout',
				'type'      => 'select',
				'choices'   => array(
					'centered' => esc_html__( 'Centered', 'slikk' ),
					'inline'   => esc_html__( 'Inline', 'slikk' ),
				),
				'transport' => 'postMessage',
			),

			'footer_socials' => array(
				'id'          => 'footer_socials',
				'label'       => esc_html__( 'Socials', 'slikk' ),
				'type'        => 'text',
				'description' => esc_html__( 'The list of social services to display in the bottom bar. (eg: facebook,twitter,instagram)', 'slikk' ),
			),

			'copyright'      => array(
				'id'    => 'copyright',
				'label' => esc_html__( 'Copyright Text', 'slikk' ),
				'type'  => 'text',
			),
		),
	);

	if ( class_exists( 'Wolf_Vc_Content_Block' ) ) {
		$mods['footer']['options']['footer_type']['description'] = sprintf(
			slikk_kses(
				__( 'This is the default footer settings. You can leave the fields below empty and use a <a href="%s" target="_blank">content block</a> instead for more flexibility. See the customizer "Layout" tab or the page options below your text editor.', 'slikk' )
			),
			'http://wlfthm.es/content-blocks'
		);
	}

	return $mods;
}
add_filter( 'slikk_customizer_mods', 'slikk_set_footer_mods' );
