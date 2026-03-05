<?php
/**
 * Slikk events
 *
 * @package WordPress
 * @subpackage Slikk
 * @version 1.4.2
 */

defined( 'ABSPATH' ) || exit;

/**
 * Set artists mods
 *
 * @param array $mods Array of mods.
 * @return array
 */
function slikk_set_artist_mods( $mods ) {

	if ( class_exists( 'Wolf_Artists' ) ) {
		$mods['wolf_artists'] = array(
			'priority' => 45,
			'id'       => 'wolf_artists',
			'title'    => esc_html__( 'Artists', 'slikk' ),
			'icon'     => 'admin-users',
			'options'  => array(

				'artist_layout'       => array(
					'id'          => 'artist_layout',
					'label'       => esc_html__( 'Layout', 'slikk' ),
					'type'        => 'select',
					'choices'     => array(
						'standard'      => esc_html__( 'Standard', 'slikk' ),
						'fullwidth'     => esc_html__( 'Full width', 'slikk' ),
						'sidebar-right' => esc_html__( 'Sidebar at right', 'slikk' ),
						'sidebar-left'  => esc_html__( 'Sidebar at left', 'slikk' ),
					),
					'transport'   => 'postMessage',
					'description' => esc_html__( 'For "Sidebar" layouts, the sidebar will be visible if it contains widgets.', 'slikk' ),
				),

				'artist_display'      => array(
					'id'      => 'artist_display',
					'label'   => esc_html__( 'Display', 'slikk' ),
					'type'    => 'select',
					'choices' => apply_filters(
						'slikk_artist_display_options',
						array(
							'list' => esc_html__( 'List', 'slikk' ),
						)
					),
				),

				'artist_grid_padding' => array(
					'id'        => 'artist_grid_padding',
					'label'     => esc_html__( 'Padding', 'slikk' ),
					'type'      => 'select',
					'choices'   => array(
						'yes' => esc_html__( 'Yes', 'slikk' ),
						'no'  => esc_html__( 'No', 'slikk' ),
					),
					'transport' => 'postMessage',
				),

				'artist_pagination'   => array(
					'id'          => 'artist_pagination',
					'label'       => esc_html__( 'Artists Archive Pagination', 'slikk' ),
					'type'        => 'select',
					'choices'     => array(
						'none'                => esc_html__( 'None', 'slikk' ),
						'standard_pagination' => esc_html__( 'Numeric Pagination', 'slikk' ),
						'load_more'           => esc_html__( 'Load More Button', 'slikk' ),
					),
					'description' => esc_html__( 'You must set a number of posts per page below. The category filter will not be disabled.', 'slikk' ),
				),

				'artists_per_page'    => array(
					'label'       => esc_html__( 'Artists per Page', 'slikk' ),
					'id'          => 'artists_per_page',
					'type'        => 'text',
					'placeholder' => 6,
				),
			),
		);
	}

	return $mods;

}
add_filter( 'slikk_customizer_mods', 'slikk_set_artist_mods' );
