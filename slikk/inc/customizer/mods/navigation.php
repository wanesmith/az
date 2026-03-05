<?php
/**
 * Slikk navigation
 *
 * @package WordPress
 * @subpackage Slikk
 * @version 1.4.2
 */

defined( 'ABSPATH' ) || exit;

/**
 * Navigation mods
 *
 * @param array $mods Array of mods.
 * @return array
 */
function slikk_set_navigation_mods( $mods ) {

	$mods['navigation'] = array(
		'id'      => 'navigation',
		'icon'    => 'menu',
		'title'   => esc_html__( 'Navigation', 'slikk' ),
		'options' => array(

			'menu_layout'           => array(
				'id'      => 'menu_layout',
				'label'   => esc_html__( 'Main Menu Layout', 'slikk' ),
				'type'    => 'select',
				'default' => 'top-justify',
				'choices' => array(
					'top-right'        => esc_html__( 'Top Right', 'slikk' ),
					'top-justify'      => esc_html__( 'Top Justify', 'slikk' ),
					'top-justify-left' => esc_html__( 'Top Justify Left', 'slikk' ),
					'centered-logo'    => esc_html__( 'Centered', 'slikk' ),
					'top-left'         => esc_html__( 'Top Left', 'slikk' ),
					'offcanvas'        => esc_html__( 'Off Canvas', 'slikk' ),
					'overlay'          => esc_html__( 'Overlay', 'slikk' ),
					'lateral'          => esc_html__( 'Lateral', 'slikk' ),
				),
			),

			'menu_width'            => array(
				'id'        => 'menu_width',
				'label'     => esc_html__( 'Main Menu Width', 'slikk' ),
				'type'      => 'select',
				'choices'   => array(
					'wide'  => esc_html__( 'Wide', 'slikk' ),
					'boxed' => esc_html__( 'Boxed', 'slikk' ),
				),
				'transport' => 'postMessage',
			),

			'menu_style'            => array(
				'id'        => 'menu_style',
				'label'     => esc_html__( 'Main Menu Style', 'slikk' ),
				'type'      => 'select',
				'choices'   => array(
					'semi-transparent-white' => esc_html__( 'Semi-transparent White', 'slikk' ),
					'semi-transparent-black' => esc_html__( 'Semi-transparent Black', 'slikk' ),
					'solid'                  => esc_html__( 'Solid', 'slikk' ),
					'transparent'            => esc_html__( 'Transparent', 'slikk' ),
				),
				'transport' => 'postMessage',
			),

			'menu_hover_style'      => array(
				'id'        => 'menu_hover_style',
				'label'     => esc_html__( 'Main Menu Hover Style', 'slikk' ),
				'type'      => 'select',
				'choices'   => apply_filters(
					'slikk_main_menu_hover_style_options',
					array(
						'none'               => esc_html__( 'None', 'slikk' ),
						'opacity'            => esc_html__( 'Opacity', 'slikk' ),
						'underline'          => esc_html__( 'Underline', 'slikk' ),
						'underline-centered' => esc_html__( 'Underline Centered', 'slikk' ),
						'border-top'         => esc_html__( 'Border Top', 'slikk' ),
						'plain'              => esc_html__( 'Plain', 'slikk' ),
					)
				),
				'transport' => 'postMessage',
			),

			'mega_menu_width'       => array(
				'id'        => 'mega_menu_width',
				'label'     => esc_html__( 'Mega Menu Width', 'slikk' ),
				'type'      => 'select',
				'choices'   => array(
					'boxed'     => esc_html__( 'Boxed', 'slikk' ),
					'wide'      => esc_html__( 'Wide', 'slikk' ),
					'fullwidth' => esc_html__( 'Full Width', 'slikk' ),
				),
				'transport' => 'postMessage',
			),

			'menu_breakpoint'       => array(
				'id'          => 'menu_breakpoint',
				'label'       => esc_html__( 'Main Menu Breakpoint', 'slikk' ),
				'type'        => 'text',
				'description' => esc_html__( 'Below each width would you like to display the mobile menu? 0 will always show the desktop menu and 99999 will always show the mobile menu.', 'slikk' ),
			),

			'menu_sticky_type'      => array(
				'id'        => 'menu_sticky_type',
				'label'     => esc_html__( 'Sticky Menu', 'slikk' ),
				'type'      => 'select',
				'choices'   => array(
					'none' => esc_html__( 'Disabled', 'slikk' ),
					'soft' => esc_html__( 'Sticky on scroll up', 'slikk' ),
					'hard' => esc_html__( 'Always sticky', 'slikk' ),
				),
				'transport' => 'postMessage',
			),

			'menu_skin'             => array(
				'id'          => 'menu_skin',
				'label'       => esc_html__( 'Menu Skin', 'slikk' ),
				'type'        => 'select',
				'choices'     => array(
					'light' => esc_html__( 'Light', 'slikk' ),
					'dark'  => esc_html__( 'Dark', 'slikk' ),
				),
				'transport'   => 'postMessage',
				'description' => esc_html__( 'Can be overwite on single page.', 'slikk' ),
			),

			'menu_cta_content_type' => array(
				'id'      => 'menu_cta_content_type',
				'label'   => esc_html__( 'Additional Content', 'slikk' ),
				'type'    => 'select',
				'default' => 'icons',
				'choices' => apply_filters(
					'slikk_menu_cta_content_type_options',
					array(
						'search_icon'    => esc_html__( 'Search Icon', 'slikk' ),
						'secondary-menu' => esc_html__( 'Secondary Menu', 'slikk' ),
						'none'           => esc_html__( 'None', 'slikk' ),
					)
				),
			),
		),
	);

	$mods['navigation']['options']['menu_socials'] = array(
		'id'          => 'menu_socials',
		'label'       => esc_html__( 'Menu Socials', 'slikk' ),
		'type'        => 'text',
		'description' => esc_html__( 'The list of social services to display in the menu. (eg: facebook,twitter,instagram)', 'slikk' ),
	);

	$mods['navigation']['options']['side_panel_position'] = array(
		'id'          => 'side_panel_position',
		'label'       => esc_html__( 'Side Panel', 'slikk' ),
		'type'        => 'select',
		'choices'     => array(
			'none'  => esc_html__( 'None', 'slikk' ),
			'right' => esc_html__( 'At Right', 'slikk' ),
			'left'  => esc_html__( 'At Left', 'slikk' ),
		),
		'description' => esc_html__( 'Note that it will be disable with a vertical menu layout (offcanvas and lateral layout).', 'slikk' ),
	);

	return $mods;
}
add_filter( 'slikk_customizer_mods', 'slikk_set_navigation_mods' );
