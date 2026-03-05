<?php
/**
 * Slikk photos
 *
 * @package WordPress
 * @subpackage Slikk
 * @version 1.4.2
 */

defined( 'ABSPATH' ) || exit;

/**
 * Attachment/photos mods
 *
 * @param array $mods Array of mods.
 * @return array
 */
function slikk_set_attachment_mods( $mods ) {

	if ( class_exists( 'Wolf_Photos' ) ) {
		$mods['photos'] = array(
			'priority' => 45,
			'id'       => 'photos',
			'title'    => esc_html__( 'Stock Photos', 'slikk' ),
			'icon'     => 'camera',
			'options'  => array(

				'attachment_layout'                  => array(
					'id'        => 'attachment_layout',
					'label'     => esc_html__( 'Layout', 'slikk' ),
					'type'      => 'select',
					'choices'   => array(
						'standard'  => esc_html__( 'Standard', 'slikk' ),
						'fullwidth' => esc_html__( 'Full width', 'slikk' ),
					),
					'transport' => 'postMessage',
				),

				'attachment_display'                 => array(
					'id'      => 'attachment_display',
					'label'   => esc_html__( 'Photos Display', 'slikk' ),
					'type'    => 'select',
					'choices' => apply_filters(
						'slikk_attachment_display_options',
						array(
							'grid' => esc_html__( 'Grid', 'slikk' ),
						)
					),
				),

				'attachment_grid_padding'            => array(
					'id'        => 'attachment_grid_padding',
					'label'     => esc_html__( 'Padding', 'slikk' ),
					'type'      => 'select',
					'choices'   => array(
						'yes' => esc_html__( 'Yes', 'slikk' ),
						'no'  => esc_html__( 'No', 'slikk' ),
					),
					'transport' => 'postMessage',
				),

				'attachment_author'                  => array(
					'id'    => 'attachment_author',
					'label' => esc_html__( 'Display Author on Single Page', 'slikk' ),
					'type'  => 'checkbox',
				),

				'attachment_likes'                   => array(
					'id'    => 'attachment_likes',
					'label' => esc_html__( 'Display Likes', 'slikk' ),
					'type'  => 'checkbox',
				),

				'attachment_multiple_sizes_download' => array(
					'id'    => 'attachment_multiple_sizes_download',
					'label' => esc_html__( 'Allow multiple sizes options for downloadable photos.', 'slikk' ),
					'type'  => 'checkbox',
				),

				'attachments_per_page'               => array(
					'label' => esc_html__( 'Photos per Page', 'slikk' ),
					'id'    => 'attachments_per_page',
					'type'  => 'text',
				),

				'attachments_pagination'             => array(
					'id'        => 'attachments_pagination',
					'label'     => esc_html__( 'Pagination Type', 'slikk' ),
					'type'      => 'select',
					'choices'   => array(
						'infinitescroll' => esc_html__( 'Infinite Scroll', 'slikk' ),
						'numbers'        => esc_html__( 'Numbers', 'slikk' ),
					),
					'transport' => 'postMessage',
				),
			),
		);
	}

	return $mods;
}
add_filter( 'slikk_customizer_mods', 'slikk_set_attachment_mods' );
