<?php
/**
 * Slikk customizer blog mods
 *
 * @package WordPress
 * @subpackage Slikk
 * @version 1.4.2
 */

defined( 'ABSPATH' ) || exit;

/**
 * Blog mods
 *
 * @param array $mods Array of mods.
 * @return array
 */
function slikk_set_post_mods( $mods ) {

	$mods['blog'] = array(
		'id'      => 'blog',
		'icon'    => 'welcome-write-blog',
		'title'   => esc_html__( 'Blog', 'slikk' ),
		'options' => array(

			'post_layout'           => array(
				'id'          => 'post_layout',
				'label'       => esc_html__( 'Blog Archive Layout', 'slikk' ),
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

			'post_display'          => array(
				'id'      => 'post_display',
				'label'   => esc_html__( 'Blog Archive Display', 'slikk' ),
				'type'    => 'select',
				'choices' => apply_filters(
					'slikk_post_display_options',
					array(
						'standard' => esc_html__( 'Standard', 'slikk' ),
					)
				),
			),

			'post_grid_padding'     => array(
				'id'        => 'post_grid_padding',
				'label'     => esc_html__( 'Padding (for grid style display only)', 'slikk' ),
				'type'      => 'select',
				'choices'   => array(
					'yes' => esc_html__( 'Yes', 'slikk' ),
					'no'  => esc_html__( 'No', 'slikk' ),
				),
				'transport' => 'postMessage',
			),

			'date_format'           => array(
				'id'      => 'date_format',
				'label'   => esc_html__( 'Blog Date Format', 'slikk' ),
				'type'    => 'select',
				'choices' => array(
					''           => esc_html__( 'Default', 'slikk' ),
					'human_diff' => esc_html__( '"X Time ago"', 'slikk' ),
				),
			),

			'post_pagination'       => array(
				'id'      => 'post_pagination',
				'label'   => esc_html__( 'Blog Archive Pagination', 'slikk' ),
				'type'    => 'select',
				'choices' => array(
					'standard_pagination' => esc_html__( 'Numeric Pagination', 'slikk' ),
					'load_more'           => esc_html__( 'Load More Button', 'slikk' ),
				),
			),

			'post_excerpt_type'     => array(
				'id'          => 'post_excerpt_type',
				'label'       => esc_html__( 'Blog Archive Post Excerpt Type', 'slikk' ),
				'type'        => 'select',
				'choices'     => array(
					'auto'   => esc_html__( 'Auto', 'slikk' ),
					'manual' => esc_html__( 'Manual', 'slikk' ),
				),
				'description' => sprintf( slikk_kses( __( 'Only for the "Standard" display type. To split your post manually, you can use the <a href="%s" target="_blank">"read more"</a> tag.', 'slikk' ) ), 'https://codex.wordpress.org/Customizing_the_Read_More' ),
			),

			'post_single_layout'    => array(
				'id'      => 'post_single_layout',
				'label'   => esc_html__( 'Single Post Layout', 'slikk' ),
				'type'    => 'select',
				'choices' => array(
					'sidebar-right' => esc_html__( 'Sidebar Right', 'slikk' ),
					'sidebar-left'  => esc_html__( 'Sidebar Left', 'slikk' ),
					'no-sidebar'    => esc_html__( 'No Sidebar', 'slikk' ),
					'fullwidth'     => esc_html__( 'Full width', 'slikk' ),
				),
			),

			'post_author_box'       => array(
				'id'      => 'post_author_box',
				'label'   => esc_html__( 'Single Post Author Box', 'slikk' ),
				'type'    => 'select',
				'choices' => array(
					'yes' => esc_html__( 'Yes', 'slikk' ),
					'no'  => esc_html__( 'No', 'slikk' ),
				),
			),

			'post_related_posts'    => array(
				'id'      => 'post_related_posts',
				'label'   => esc_html__( 'Single Post Related Posts', 'slikk' ),
				'type'    => 'select',
				'choices' => array(
					'yes' => esc_html__( 'Yes', 'slikk' ),
					'no'  => esc_html__( 'No', 'slikk' ),
				),
			),

			'post_item_animation'   => array(
				'label'   => esc_html__( 'Blog Archive Item Animation', 'slikk' ),
				'id'      => 'post_item_animation',
				'type'    => 'select',
				'choices' => slikk_get_animations(),
			),

			'post_display_elements' => array(
				'id'          => 'post_display_elements',
				'label'       => esc_html__( 'Elements to show by default', 'slikk' ),
				'type'        => 'group_checkbox',
				'choices'     => array(
					'show_thumbnail'  => esc_html__( 'Thumbnail', 'slikk' ),
					'show_date'       => esc_html__( 'Date', 'slikk' ),
					'show_text'       => esc_html__( 'Text', 'slikk' ),
					'show_category'   => esc_html__( 'Category', 'slikk' ),
					'show_author'     => esc_html__( 'Author', 'slikk' ),
					'show_tags'       => esc_html__( 'Tags', 'slikk' ),
					'show_extra_meta' => esc_html__( 'Extra Meta', 'slikk' ),
				),
				'description' => esc_html__( 'Note that some options may be ignored depending on the post display.', 'slikk' ),
			),
		),
	);

	if ( class_exists( 'Wolf_Custom_Post_Meta' ) ) {

		$mods['blog']['options'][] = array(
			'label'   => esc_html__( 'Enable Custom Post Meta', 'slikk' ),
			'id'      => 'enable_custom_post_meta',
			'type'    => 'group_checkbox',
			'choices' => array(
				'post_enable_views'        => esc_html__( 'Views', 'slikk' ),
				'post_enable_likes'        => esc_html__( 'Likes', 'slikk' ),
				'post_enable_reading_time' => esc_html__( 'Reading Time', 'slikk' ),
			),
		);
	}

	return $mods;
}
add_filter( 'slikk_customizer_mods', 'slikk_set_post_mods' );
