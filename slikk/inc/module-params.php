<?php
/**
 * Custom Post Types module parameters
 *
 * @package WordPress
 * @subpackage Slikk
 * @version 1.4.2
 */

defined( 'ABSPATH' ) || exit;

if ( ! class_exists( 'Wolf_Core' ) ) {
	return;
}

/**
 * Common parameters  usedacross post type modules
 */
function slikk_common_module_params() {
	return apply_filters(
		'slikk_common_module_params',
		array(
			array(
				'type'        => 'text',
				'label'       => esc_html__( 'Index ID', 'slikk' ),
				'default'     => 'index-' . wp_rand( 0, 99999 ),
				'param_name'  => 'el_id',
				'description' => esc_html__( 'A unique identifier for the post module (required).', 'slikk' ),
			),
			array(
				'label'       => esc_html__( 'Animation', 'slikk' ),
				'param_name'  => 'item_animation',
				'type'        => 'select',
				'options'     => slikk_get_animations(),
				'default'     => 'none',
				'admin_label' => true,
			),

			array(
				'label'       => esc_html__( 'Number of Posts', 'slikk' ),
				'param_name'  => 'posts_per_page',
				'type'        => 'text',
				'placeholder' => 9,
				'description' => esc_html__( 'Leave empty to display all post at once.', 'slikk' ),
				'admin_label' => true,
			),

			array(
				'type'        => 'text',
				'label'       => esc_html__( 'Offset', 'slikk' ),
				'param_name'  => 'offset',
				'description' => esc_html__( 'The amount of posts that should be skipped in the beginning of the query. If an offset is set, sticky posts will be ignored.', 'slikk' ),
				'group'       => esc_html__( 'Query', 'slikk' ),
				'admin_label' => true,
			),

			array(
				'label'       => esc_html__( 'Quick CSS', 'wolf-core' ),
				'description' => esc_html__( 'CSS inline style', 'wolf-core' ),
				'param_name'  => 'inline_style',
				'type'        => 'textarea',
				'group'       => esc_html__( 'Extra', 'wolf-core' ),
			),
		)
	);
}

/**
 * Overlay appearance parameters used across post type modules
 *
 * @param string $post_type The post type, duh.
 */
function slikk_overlay_module_params( $post_type ) {
	return apply_filters(
		'slikk_overlay_module_params',
		array(
			/* Overlay Color for VC */
			array(
				'type'               => 'select',
				'label'              => esc_html__( 'Overlay Color', 'slikk' ),
				'param_name'         => 'overlay_color',
				'options'            => array_merge(
					array( 'auto' => esc_html__( 'Auto', 'slikk' ) ),
					slikk_shared_gradient_colors(),
					slikk_shared_colors(),
					array( 'custom' => esc_html__( 'Custom color', 'slikk' ) )
				),
				'default'            => apply_filters( 'wolf_core_default_item_overlay_color', 'black' ),
				'description'        => esc_html__( 'Select an overlay color.', 'slikk' ),
				'param_holder_class' => 'wolf_core_colored-select',
				'condition'          => array(
					$post_type . '_layout' => array( 'overlay' ),
				),
				'page_builder'       => 'vc',
			),

			array(
				'type'         => 'colorpicker',
				'label'        => esc_html__( 'Overlay Custom Color', 'slikk' ),
				'param_name'   => 'overlay_custom_color',
				'condition'    => array(
					$post_type . '_layout' => array( 'overlay' ),
					'overlay_color'        => array( 'custom' ),
				),
				'page_builder' => 'vc',
			),

			/* Overlay Color for Elementor */
			array(
				'label'        => esc_html__( 'Overlay Color', 'wolf-core' ),
				'type'         => 'select',
				'options'      => array_merge(
					array( 'auto' => esc_html__( 'Auto', 'slikk' ) ),
					slikk_shared_colors(),
					array( 'custom' => esc_html__( 'Custom color', 'slikk' ) )
				),
				'param_name'   => 'overlay_color',
				'default'      => 'auto',
				'page_builder' => 'elementor',
				'condition'    => array(
					$post_type . '_layout' => array( 'overlay' ),
				),
				'group'        => esc_html__( 'Style', 'wolf-core' ),
			),

			array(
				'type'         => 'colorpicker',
				'label'        => esc_html__( 'Overlay Color', 'wolf-core' ),
				'param_name'   => 'overlay_custom_color',
				'page_builder' => 'elementor',
				'selectors'    => array(
					'{{WRAPPER}} .bg-overlay' => 'background-color: {{VALUE}}!important;',
				),
				'group'        => esc_html__( 'Style', 'wolf-core' ),
				'condition'    => array(
					$post_type . '_layout' => array( 'overlay' ),
					'overlay_color'        => array( 'custom' ),
				),
				'page_builder' => 'elementor',
			),

			/* Overlay Opacity */
			array(
				'type'         => 'slider',
				'label'        => esc_html__( 'Overlay Opacity', 'slikk' ),
				'param_name'   => 'overlay_opacity',
				'min'          => 0,
				'max'          => 1,
				'step'         => 0.01,
				'default'      => apply_filters( 'wolf_core_default_item_overlay_opacity', 40 ) / 100,
				'condition'    => array(
					$post_type . '_layout' => array( 'overlay' ),
				),
				'selectors'    => array(
					'{{WRAPPER}} .bg-overlay' => 'opacity: {{SIZE}}!important;',
				),
				'group'        => esc_html__( 'Style', 'wolf-core' ),
				'page_builder' => 'elementor',
			),

			array(
				'type'         => 'slider',
				'label'        => esc_html__( 'Overlay Opacity in Percent', 'slikk' ),
				'param_name'   => 'overlay_opacity',
				'min'          => 0,
				'max'          => 100,
				'step'         => 1,
				'default'      => apply_filters( 'wolf_core_default_item_overlay_opacity', 40 ),
				'condition'    => array(
					$post_type . '_layout' => array( 'overlay' ),
				),
				'group'        => esc_html__( 'Style', 'wolf-core' ),
				'page_builder' => 'vc',
			),

			/* Overlay Text Color for VC */
			array(
				'type'               => 'select',
				'label'              => esc_html__( 'Overlay Text Color', 'slikk' ),
				'param_name'         => 'overlay_text_color',
				'options'            => array_merge(
					array( 'auto' => esc_html__( 'Auto', 'slikk' ) ),
					slikk_shared_gradient_colors(),
					slikk_shared_colors(),
					array( 'custom' => esc_html__( 'Custom color', 'slikk' ) )
				),
				'default'            => apply_filters( 'wolf_core_default_item_overlay_color', 'black' ),
				'description'        => esc_html__( 'Select an overlay color.', 'slikk' ),
				'param_holder_class' => 'wolf_core_colored-select',
				'condition'          => array(
					$post_type . '_layout' => array( 'overlay' ),
				),
				'page_builder'       => 'vc',
			),

			array(
				'type'         => 'colorpicker',
				'label'        => esc_html__( 'Overlay Custom Text Color', 'slikk' ),
				'param_name'   => 'overlay_text_custom_color',
				'condition'    => array(
					$post_type . '_layout' => array( 'overlay' ),
					'overlay_text_color'   => array( 'custom' ),
				),
				'page_builder' => 'vc',
			),

			/* Overlay Text Color for Elementor */
			array(
				'label'        => esc_html__( 'Overlay Text Color', 'wolf-core' ),
				'type'         => 'hidden',
				'param_name'   => 'overlay_text_color',
				'default'      => 'custom',
				'page_builder' => 'elementor',
			),

			array(
				'type'         => 'colorpicker',
				'label'        => esc_html__( 'Overlay Text Color', 'wolf-core' ),
				'param_name'   => 'overlay_text_custom_color',
				'page_builder' => 'elementor',
				'selectors'    => array(
					'{{WRAPPER}} .entry-summary' => 'color: {{VALUE}}!important;',
				),
				'group'        => esc_html__( 'Style', 'wolf-core' ),
				'page_builder' => 'elementor',
			),
		)
	);
}

/**
 * Post Index
 */
function slikk_post_index_params() {
	return apply_filters(
		'slikk_post_index_params',
		array(
			'properties' => array(
				'name'          => esc_html__( 'Posts', 'slikk' ),
				'description'   => esc_html__( 'Display your posts using the theme layouts', 'slikk' ),
				'vc_base'       => 'wolf_core_post_index',
				'el_base'       => 'post-index',
				'vc_category'   => esc_html__( 'Content', 'slikk' ),
				'el_categories' => array( 'post-modules' ),
				'icon'          => 'fa fa-th',
				'weight'        => 999,
			),

			'params'     => array_merge(
				slikk_common_module_params(),
				array(
					array(
						'param_name'  => 'post_display',
						'label'       => esc_html__( 'Post Display', 'slikk' ),
						'type'        => 'select',
						'options'     => apply_filters(
							'slikk_post_display_options',
							array(
								'standard' => esc_html__( 'Standard', 'slikk' ),
								'grid'     => esc_html__( 'Grid', 'slikk' ),
							)
						),
						'default'     => 'grid',
						'admin_label' => true,
					),

					array(
						'param_name'  => 'post_metro_pattern',
						'label'       => esc_html__( 'Metro Pattern', 'slikk' ),
						'type'        => 'select',
						'options'     => slikk_get_metro_patterns(),
						'default'     => 'auto',
						'condition'   => array(
							'post_display' => array( 'metro_modern_alt', 'metro' ),
						),
						'admin_label' => true,
					),

					array(
						'param_name'   => 'post_alternate_thumbnail_position',
						'label'        => esc_html__( 'Alternate thumbnail position', 'slikk' ),
						'type'         => 'checkbox',
						'label_on'     => esc_html__( 'Yes', 'slikk' ),
						'label_off'    => esc_html__( 'No', 'slikk' ),
						'return_value' => 'no',
						'condition'    => array(
							'post_display' => array( 'lateral' ),
						),
					),

					array(
						'param_name'  => 'post_module',
						'label'       => esc_html__( 'Module', 'slikk' ),
						'type'        => 'select',
						'options'     => array(
							'grid'     => esc_html__( 'Grid', 'slikk' ),
							'carousel' => esc_html__( 'Carousel', 'slikk' ),
						),
						'default'     => 'grid',
						'admin_label' => true,
						'condition'   => array(
							'post_display' => array( 'grid', 'grid_classic', 'grid_modern' ),
						),
					),

					array(
						'param_name' => 'post_excerpt_length',
						'label'      => esc_html__( 'Post Excerpt Lenght', 'slikk' ),
						'type'       => 'select',
						'options'    => array(
							'shorten' => esc_html__( 'Shorten', 'slikk' ),
							'full'    => esc_html__( 'Full', 'slikk' ),
						),
						'default'    => 'shorten',
						'condition'  => array(
							'post_display' => array( 'masonry' ),
						),
					),

					array(
						'param_name'   => 'post_display_elements',
						'label'        => esc_html__( 'Elements', 'slikk' ),
						'type'         => 'group_checkbox',
						'options'      => array(
							'show_thumbnail'  => esc_html__( 'Thumbnail', 'slikk' ),
							'show_date'       => esc_html__( 'Date', 'slikk' ),
							'show_text'       => esc_html__( 'Text', 'slikk' ),
							'show_category'   => esc_html__( 'Category', 'slikk' ),
							'show_author'     => esc_html__( 'Author', 'slikk' ),
							'show_tags'       => esc_html__( 'Tags', 'slikk' ),
							'show_extra_meta' => esc_html__( 'Extra Meta', 'slikk' ),
						),
						'default'      => 'show_thumbnail,show_date,show_text,show_author,show_category',
						'description'  => esc_html__( 'Note that some options may be ignored depending on the post display.', 'slikk' ),
						'admin_label'  => true,
						'page_builder' => 'vc',
					),

					array(
						'param_name'   => 'post_show_thumbnail',
						'label'        => esc_html__( 'Show Thumbnail', 'slikk' ),
						'type'         => 'checkbox',
						'default'      => 'yes',
						'page_builder' => 'elementor',
					),

					array(
						'param_name'   => 'post_show_date',
						'label'        => esc_html__( 'Show Date', 'slikk' ),
						'type'         => 'checkbox',
						'default'      => 'yes',
						'page_builder' => 'elementor',
					),

					array(
						'param_name'   => 'post_show_text',
						'label'        => esc_html__( 'Show Text', 'slikk' ),
						'type'         => 'checkbox',
						'default'      => 'yes',
						'page_builder' => 'elementor',
					),

					array(
						'param_name'   => 'post_show_category',
						'label'        => esc_html__( 'Show Category', 'slikk' ),
						'type'         => 'checkbox',
						'default'      => 'yes',
						'page_builder' => 'elementor',
					),

					array(
						'param_name'   => 'post_show_author',
						'label'        => esc_html__( 'Show Author', 'slikk' ),
						'type'         => 'checkbox',
						'default'      => 'yes',
						'page_builder' => 'elementor',
					),

					array(
						'param_name'   => 'post_show_tags',
						'label'        => esc_html__( 'Show Tags', 'slikk' ),
						'type'         => 'checkbox',
						'default'      => 'yes',
						'page_builder' => 'elementor',
					),

					array(
						'param_name'  => 'post_excerpt_type',
						'label'       => esc_html__( 'Post Excerpt Type', 'slikk' ),
						'type'        => 'select',
						'options'     => array(
							'auto'   => esc_html__( 'Auto', 'slikk' ),
							'manual' => esc_html__( 'Manual', 'slikk' ),
						),
						'default'     => 'auto',
						'description' => sprintf(
							wp_kses_post( __( 'When using the manual excerpt, you must split your post using a "More Tag".', 'slikk' ) ),
							esc_url( 'https://en.support.wordpress.com/more-tag/' )
						),
						'condition'   => array(
							'post_display' => array( 'standard', 'standard_modern' ),
						),
					),

					array(
						'param_name'  => 'grid_padding',
						'label'       => esc_html__( 'Padding', 'slikk' ),
						'type'        => 'select',
						'options'     => array(
							'yes' => esc_html__( 'Yes', 'slikk' ),
							'no'  => esc_html__( 'No', 'slikk' ),
						),
						'default'     => 'yes',
						'admin_label' => true,
						'condition'   => array(
							'post_display' => array( 'grid', 'masonry', 'metro' ),
						),
					),

					array(
						'param_name'  => 'pagination',
						'label'       => esc_html__( 'Pagination', 'slikk' ),
						'type'        => 'select',
						'options'     => array(
							'none'                => esc_html__( 'None', 'slikk' ),
							'load_more'           => esc_html__( 'Load More', 'slikk' ),
							'standard_pagination' => esc_html__( 'Numeric Pagination', 'slikk' ),
							'link_to_blog'        => esc_html__( 'Link to Blog Archives', 'slikk' ),
						),
						'default'     => 'none',
						'admin_label' => true,
					),

					array(
						'type'         => 'checkbox',
						'label'        => esc_html__( 'Ignore Sticky Posts', 'slikk' ),
						'param_name'   => 'ignore_sticky_posts',
						'label_on'     => esc_html__( 'Yes', 'slikk' ),
						'label_off'    => esc_html__( 'No', 'slikk' ),
						'return_value' => 'yes',
						'description'  => esc_html__( 'It will still include the sticky posts but it will not prioritize them in the query.', 'slikk' ),
						'group'        => esc_html__( 'Query', 'slikk' ),
					),

					array(
						'type'         => 'checkbox',
						'label'        => esc_html__( 'Exclude Sticky Posts', 'slikk' ),
						'description'  => esc_html__( 'It will still exclude the sticky posts.', 'slikk' ),
						'param_name'   => 'exclude_sticky_posts',
						'label_on'     => esc_html__( 'Yes', 'slikk' ),
						'label_off'    => esc_html__( 'No', 'slikk' ),
						'return_value' => 'yes',
						'group'        => esc_html__( 'Query', 'slikk' ),
					),

					array(
						'type'        => 'text',
						'label'       => esc_html__( 'Category', 'slikk' ),
						'param_name'  => 'category',
						'description' => esc_html__( 'Include only one or several categories. Paste category slug(s) separated by a comma', 'slikk' ),
						'placeholder' => esc_html__( 'my-category, other-category', 'slikk' ),
						'group'       => esc_html__( 'Query', 'slikk' ),
					),

					array(
						'type'        => 'text',
						'label'       => esc_html__( 'Exclude Category by ID', 'slikk' ),
						'param_name'  => 'category_exclude',
						'description' => esc_html__( 'Exclude only one or several categories. Paste category ID(s) separated by a comma', 'slikk' ),
						'placeholder' => esc_html__( '456, 756', 'slikk' ),
						'group'       => esc_html__( 'Query', 'slikk' ),
					),

					array(
						'type'        => 'text',
						'label'       => esc_html__( 'Tags', 'slikk' ),
						'param_name'  => 'tag',
						'description' => esc_html__( 'Include only one or several tags. Paste tag slug(s) separated by a comma', 'slikk' ),
						'placeholder' => esc_html__( 'my-tag, other-tag', 'slikk' ),
						'group'       => esc_html__( 'Query', 'slikk' ),
					),

					array(
						'type'        => 'text',
						'label'       => esc_html__( 'Exclude Tags by ID', 'slikk' ),
						'param_name'  => 'tag_exclude',
						'description' => esc_html__( 'Exclude only one or several tags. Paste tag ID(s) separated by a comma', 'slikk' ),
						'placeholder' => esc_html__( '456, 756', 'slikk' ),
						'group'       => esc_html__( 'Query', 'slikk' ),
					),

					array(
						'type'        => 'select',
						'label'       => esc_html__( 'Order by', 'slikk' ),
						'param_name'  => 'orderby',
						'options'     => slikk_order_by_values(),
						'save_always' => true,
						'description' => sprintf( wp_kses_post( __( 'Select how to sort retrieved posts. More at %s.', 'slikk' ) ), 'WordPress codex page' ),
						'group'       => esc_html__( 'Query', 'slikk' ),
					),

					array(
						'type'        => 'select',
						'label'       => esc_html__( 'Sort order', 'slikk' ),
						'param_name'  => 'order',
						'options'     => slikk_order_way_values(),
						'save_always' => true,
						'description' => sprintf( wp_kses_post( __( 'Designates the ascending or descending order. More at %s.', 'slikk' ) ), 'WordPress codex page' ),
						'group'       => esc_html__( 'Query', 'slikk' ),
					),

					array(
						'type'        => 'text',
						'label'       => esc_html__( 'Post IDs', 'slikk' ),
						'description' => esc_html__( 'By default, your last posts will be displayed. You can choose the posts you want to display by entering a list of IDs separated by a comma.', 'slikk' ),
						'param_name'  => 'include_ids',
						'group'       => esc_html__( 'Query', 'slikk' ),
					),

					array(
						'type'        => 'text',
						'label'       => esc_html__( 'Exclude Post IDs', 'slikk' ),
						'description' => esc_html__( 'You can choose the posts you don\'t want to display by entering a list of IDs separated by a comma.', 'slikk' ),
						'param_name'  => 'exclude_ids',
						'group'       => esc_html__( 'Query', 'slikk' ),
					),

					array(
						'param_name'  => 'columns',
						'label'       => esc_html__( 'Columns', 'slikk' ),
						'type'        => 'select',
						'options'     => array(
							2 => esc_html__( 'Two', 'slikk' ),
							3 => esc_html__( 'Three', 'slikk' ),
							4 => esc_html__( 'Four', 'slikk' ),
							5 => esc_html__( 'Five', 'slikk' ),
							6 => esc_html__( 'Six', 'slikk' ),
							1 => esc_html__( 'One', 'slikk' ),
						),
						'default'     => 3,
						'admin_label' => true,
						'condition'   => array(
							'post_display' => array( 'grid', 'grid_classic', 'masonry', 'masonry_modern' ),
						),
					),

					array(
						'type'        => 'text',
						'label'       => esc_html__( 'Extra class name', 'slikk' ),
						'param_name'  => 'el_class',
						'description' => esc_html__( 'Style particular content element differently - add a class name and refer to it in custom CSS.', 'slikk' ),
						'group'       => esc_html__( 'Extra', 'slikk' ),
					),
				),
			),
		)
	);
}

/**
 * Release Index
 */
function slikk_release_index_params() {
	return apply_filters(
		'slikk_release_index_params',
		array(
			'properties' => array(
				'name'          => esc_html__( 'Releases', 'slikk' ),
				'description'   => esc_html__( 'Display your releases using the theme layouts', 'slikk' ),
				'vc_base'       => 'wolf_core_release_index',
				'el_base'       => 'release-index',
				'vc_category'   => esc_html__( 'Content', 'slikk' ),
				'el_categories' => array( 'post-modules' ),
				'icon'          => 'fa fa-th',
				'weight'        => 999,
				'scripts'       => array( 'jquery', 'imagesloaded', 'isotope', 'packery-mode', 'flex-images', 'slikk-functions', 'slikk-masonry', 'slikk-carousel', 'slikk-category-filter' ),
			),

			'params'     => array_merge(
				slikk_common_module_params(),
				array(
					array(
						'param_name'  => 'release_display',
						'label'       => esc_html__( 'Release Display', 'slikk' ),
						'type'        => 'select',
						'options'     => apply_filters(
							'slikk_release_display_options',
							array(
								'grid' => esc_html__( 'Grid', 'slikk' ),
							)
						),
						'default'     => 'grid',
						'admin_label' => true,
					),

					array(
						'param_name'  => 'release_metro_pattern',
						'label'       => esc_html__( 'Metro Pattern', 'slikk' ),
						'type'        => 'select',
						'options'     => slikk_get_metro_patterns(),
						'default'     => 'auto',
						'condition'   => array(
							'release_display' => array( 'metro' ),
						),
						'admin_label' => true,
					),

					array(
						'param_name'   => 'release_alternate_thumbnail_position',
						'label'        => esc_html__( 'Alternate thumbnail position', 'slikk' ),
						'type'         => 'checkbox',
						'label_on'     => esc_html__( 'Yes', 'slikk' ),
						'label_off'    => esc_html__( 'No', 'slikk' ),
						'return_value' => 'yes',
						'condition'    => array(
							'release_display' => array( 'lateral' ),
						),
					),

					array(
						'param_name'  => 'release_layout',
						'label'       => esc_html__( 'Layout', 'slikk' ),
						'type'        => 'select',
						'options'     => apply_filters(
							'slikk_release_layout_options',
							array(
								'standard' => esc_html__( 'Classic', 'slikk' ),
								'overlay'  => esc_html__( 'Overlay', 'slikk' ),
							)
						),
						'default'     => 'standard',
						'admin_label' => true,
						'condition'   => array(
							'release_display' => array( 'grid', 'metro', 'masonry' ),
						),
					),

					array(
						'param_name'  => 'release_module',
						'label'       => esc_html__( 'Module', 'slikk' ),
						'type'        => 'select',
						'options'     => array(
							'grid'     => esc_html__( 'Grid', 'slikk' ),
							'carousel' => esc_html__( 'Carousel', 'slikk' ),
						),
						'default'     => 'grid',
						'admin_label' => true,
						'condition'   => array(
							'release_display' => array( 'grid', 'animated_cover' ),
						),
					),

					array(
						'param_name'  => 'release_custom_thumbnail_size',
						'label'       => esc_html__( 'Custom Thumbnail Size', 'slikk' ),
						'type'        => 'text',
						'admin_label' => true,
						'placeholder' => '450x450',
					),

					array(
						'param_name'  => 'grid_padding',
						'label'       => esc_html__( 'Padding', 'slikk' ),
						'type'        => 'select',
						'options'     => array(
							'yes' => esc_html__( 'Yes', 'slikk' ),
							'no'  => esc_html__( 'No', 'slikk' ),
						),
						'default'     => 'yes',
						'admin_label' => true,
						'condition'   => array(
							'release_layout' => array( 'standard', 'overlay', 'label' ),
						),
					),
				),
				slikk_overlay_module_params( 'release' ),
				array(
					array(
						'label'        => esc_html__( 'Category Filter', 'slikk' ),
						'param_name'   => 'release_category_filter',
						'description'  => esc_html__( 'The pagination will not be disabled.', 'slikk' ),
						'type'         => 'checkbox',
						'label_on'     => esc_html__( 'Yes', 'slikk' ),
						'label_off'    => esc_html__( 'No', 'slikk' ),
						'return_value' => 'yes',
						'admin_label'  => true,
						'condition'    => array(
							'release_display' => array( 'grid', 'animated_cover' ),
						),
					),

					array(
						'label'        => esc_html__( 'Filter Text Alignement', 'slikk' ),
						'param_name'   => 'release_category_filter_text_alignment',
						'type'         => 'choose',
						'options'      => array(
							'left'   => array(
								'title' => esc_html__( 'Left', 'wolf-core' ),
								'icon'  => 'eicon-text-align-left',
							),
							'center' => array(
								'title' => esc_html__( 'Center', 'wolf-core' ),
								'icon'  => 'eicon-text-align-center',
							),
							'right'  => array(
								'title' => esc_html__( 'Right', 'wolf-core' ),
								'icon'  => 'eicon-text-align-right',
							),
						),
						'condition'    => array(
							'release_category_filter' => 'yes',
						),
						'selectors'    => array(
							'{{WRAPPER}} .category-filter-release ul' => 'text-align:{{VALUE}};',
						),
						'page_builder' => 'elementor',
					),

					array(
						'label'        => esc_html__( 'Filter Text Alignement', 'slikk' ),
						'param_name'   => 'release_category_filter_text_alignment',
						'type'         => 'select',
						'options'      => array(
							'center' => esc_html__( 'Center', 'wolf-core' ),
							'left'   => esc_html__( 'Left', 'wolf-core' ),
							'right'  => esc_html__( 'Right', 'wolf-core' ),
						),
						'condition'    => array(
							'release_category_filter' => 'yes',
						),
						'page_builder' => 'vc',
					),

					array(
						'param_name'  => 'pagination',
						'label'       => esc_html__( 'Pagination', 'slikk' ),
						'type'        => 'select',
						'options'     => array(
							'none'                => esc_html__( 'None', 'slikk' ),
							'load_more'           => esc_html__( 'Load More', 'slikk' ),
							'standard_pagination' => esc_html__( 'Numeric Pagination', 'slikk' ),
							'link_to_discography' => esc_html__( 'Link to Discography', 'slikk' ),
						),
						'condition'   => array(
							'release_category_filter' => '',
						),
						'default'     => 'none',
						'admin_label' => true,
					),

					array(
						'type'        => 'text',
						'label'       => esc_html__( 'Include Band', 'slikk' ),
						'param_name'  => 'band_include',
						'description' => esc_html__( 'Enter one or several bands. Paste band slug(s) separated by a comma', 'slikk' ),
						'placeholder' => esc_html__( 'my-band, other-band', 'slikk' ),
						'group'       => esc_html__( 'Query', 'slikk' ),
					),

					array(
						'type'        => 'text',
						'label'       => esc_html__( 'Exclude Band', 'slikk' ),
						'param_name'  => 'band_exclude',
						'description' => esc_html__( 'Enter one or several bands. Paste band slug(s) separated by a comma', 'slikk' ),
						'placeholder' => esc_html__( 'my-band, other-band', 'slikk' ),
						'group'       => esc_html__( 'Query', 'slikk' ),
					),

					array(
						'type'        => 'text',
						'label'       => esc_html__( 'Include Type', 'slikk' ),
						'param_name'  => 'label_include',
						'description' => esc_html__( 'Enter one or several release types (from release tags). Paste type slug(s) separated by a comma', 'slikk' ),
						'placeholder' => esc_html__( 'my-type, other-type', 'slikk' ),
						'group'       => esc_html__( 'Query', 'slikk' ),
					),

					array(
						'type'        => 'text',
						'label'       => esc_html__( 'Exclude Type', 'slikk' ),
						'param_name'  => 'label_exclude',
						'description' => esc_html__( 'Enter one or several release types (from release tags). Paste type slug(s) separated by a comma', 'slikk' ),
						'placeholder' => esc_html__( 'my-type, other-type', 'slikk' ),
						'group'       => esc_html__( 'Query', 'slikk' ),
					),

					array(
						'type'        => 'select',
						'label'       => esc_html__( 'Order by', 'slikk' ),
						'param_name'  => 'orderby',
						'options'     => slikk_order_by_values(),
						'save_always' => true,
						'description' => sprintf( wp_kses_post( __( 'Select how to sort retrieved posts. More at %s.', 'slikk' ) ), 'WordPress codex page' ),
						'group'       => esc_html__( 'Query', 'slikk' ),
					),

					array(
						'type'        => 'select',
						'label'       => esc_html__( 'Sort order', 'slikk' ),
						'param_name'  => 'order',
						'options'     => slikk_order_way_values(),
						'save_always' => true,
						'description' => sprintf( wp_kses_post( __( 'Designates the ascending or descending order. More at %s.', 'slikk' ) ), 'WordPress codex page' ),
						'group'       => esc_html__( 'Query', 'slikk' ),
					),

					array(
						'type'        => 'text',
						'label'       => esc_html__( 'Post IDs', 'slikk' ),
						'description' => esc_html__( 'By default, your last posts will be displayed. You can choose the posts you want to display by entering a list of IDs separated by a comma.', 'slikk' ),
						'param_name'  => 'include_ids',
						'group'       => esc_html__( 'Query', 'slikk' ),
					),

					array(
						'type'        => 'text',
						'label'       => esc_html__( 'Exclude Post IDs', 'slikk' ),
						'description' => esc_html__( 'You can choose the posts you don\'t want to display by entering a list of IDs separated by a comma.', 'slikk' ),
						'param_name'  => 'exclude_ids',
						'group'       => esc_html__( 'Query', 'slikk' ),
					),

					array(
						'param_name'  => 'columns',
						'label'       => esc_html__( 'Columns', 'slikk' ),
						'type'        => 'select',
						'options'     => array(
							'default' => esc_html__( 'Auto', 'slikk' ),
							2         => esc_html__( 'Two', 'slikk' ),
							3         => esc_html__( 'Three', 'slikk' ),
							4         => esc_html__( 'Four', 'slikk' ),
							5         => esc_html__( 'Five', 'slikk' ),
							6         => esc_html__( 'Six', 'slikk' ),
							1         => esc_html__( 'One', 'slikk' ),
						),
						'default'     => 3,
						'admin_label' => true,
						'condition'   => array(
							'release_display' => array( 'grid', 'animated_cover' ),
						),
					),
				),
			),
		)
	);
}

/**
 * Product Index
 */
function slikk_product_index_params() {
	return apply_filters(
		'slikk_product_index_params',
		array(
			'properties' => array(
				'name'          => esc_html__( 'Products', 'slikk' ),
				'description'   => esc_html__( 'Display your products using the theme layouts', 'slikk' ),
				'vc_base'       => 'wolf_core_product_index',
				'el_base'       => 'product-index',
				'vc_category'   => esc_html__( 'Content', 'slikk' ),
				'el_categories' => array( 'post-modules' ),
				'icon'          => 'fa fa-th',
				'weight'        => 999,
			),

			'params'     => array_merge(
				slikk_common_module_params(),
				array(
					array(
						'param_name'  => 'product_display',
						'label'       => esc_html__( 'Post Display', 'slikk' ),
						'type'        => 'select',
						'options'     => apply_filters(
							'slikk_product_display_options',
							array(
								'grid' => esc_html__( 'Grid', 'slikk' ),
							)
						),
						'default'     => 'grid',
						'admin_label' => true,
					),

					array(
						'param_name'  => 'product_metro_pattern',
						'label'       => esc_html__( 'Metro Pattern', 'slikk' ),
						'type'        => 'select',
						'options'     => slikk_get_metro_patterns(),
						'default'     => 'auto',
						'condition'   => array(
							'product_display' => array( 'metro' ),
						),
						'admin_label' => true,
					),

					/*
					array(
						'label'        => esc_html__( 'Product Text Alignement', 'slikk' ),
						'param_name'   => 'product_text_align',
						'type'         => 'choose',
						'options'      => array(
							'left'   => array(
								'title' => esc_html__( 'Left', 'slikk' ),
								'icon'  => 'eicon-text-align-left',
							),
							'center' => array(
								'title' => esc_html__( 'Center', 'slikk' ),
								'icon'  => 'eicon-text-align-center',
							),
							'right'  => array(
								'title' => esc_html__( 'Right', 'slikk' ),
								'icon'  => 'eicon-text-align-right',
							),
						),
						'selectors'    => array(
							'{{WRAPPER}} .entry-product' => 'margin-{{VALUE}}: 0;',
						),
						'page_builder' => 'elementor',
					),*/

				/*
				  array(
						'type'         => 'select',
						'label'        => esc_html__( 'Product Text Alignement', 'slikk' ),
						'param_name'   => 'product_text_align',
						'options'      => array(
							'center' => esc_html__( 'Center', 'slikk' ),
							'left'   => esc_html__( 'Left', 'slikk' ),
							'right'  => esc_html__( 'Right', 'slikk' ),
						),
						'page_builder' => 'vc',
					),*/

					array(
						'param_name'  => 'product_meta',
						'label'       => esc_html__( 'Type', 'slikk' ),
						'type'        => 'select',
						'options'     => array(
							'all'          => esc_html__( 'All', 'slikk' ),
							'featured'     => esc_html__( 'Featured', 'slikk' ),
							'onsale'       => esc_html__( 'On Sale', 'slikk' ),
							'best_selling' => esc_html__( 'Best Selling', 'slikk' ),
							'top_rated'    => esc_html__( 'Top Rated', 'slikk' ),
						),
						'admin_label' => true,
					),

					array(
						'param_name'  => 'product_module',
						'label'       => esc_html__( 'Module', 'slikk' ),
						'type'        => 'select',
						'options'     => array(
							'grid'     => esc_html__( 'Grid', 'slikk' ),
							'carousel' => esc_html__( 'Carousel', 'slikk' ),
						),
						'default'     => 'grid',
						'admin_label' => true,
						'condition'   => array(
							'product_display' => array( 'grid', 'grid_classic', 'grid_modern' ),
						),
					),

					array(
						'param_name'  => 'columns',
						'label'       => esc_html__( 'Columns', 'slikk' ),
						'type'        => 'select',
						'options'     => array(
							'default' => esc_html__( 'Auto', 'slikk' ),
							2         => esc_html__( 'Two', 'slikk' ),
							3         => esc_html__( 'Three', 'slikk' ),
							4         => esc_html__( 'Four', 'slikk' ),
							5         => esc_html__( 'Five', 'slikk' ),
							6         => esc_html__( 'Six', 'slikk' ),
							1         => esc_html__( 'One', 'slikk' ),
						),
						'default'     => 3,
						'admin_label' => true,
						'condition'   => array(
							'product_display' => array( 'grid' ),
						),
					),

					array(
						'type'        => 'text',
						'label'       => esc_html__( 'Category', 'slikk' ),
						'param_name'  => 'product_cat',
						'description' => esc_html__( 'Include only one or several categories. Paste category slug(s) separated by a comma', 'slikk' ),
						'placeholder' => esc_html__( 'my-category, other-category', 'slikk' ),
						'group'       => esc_html__( 'Query', 'slikk' ),
					),

					array(
						'param_name'  => 'grid_padding',
						'label'       => esc_html__( 'Padding', 'slikk' ),
						'type'        => 'select',
						'options'     => array(
							'yes' => esc_html__( 'Yes', 'slikk' ),
							'no'  => esc_html__( 'No', 'slikk' ),
						),
						'default'     => 'yes',
						'admin_label' => true,
						'condition'   => array(
							'product_display' => array( 'grid', 'masonry', 'metro' ),
						),
					),

					array(
						'param_name'  => 'pagination',
						'label'       => esc_html__( 'Pagination', 'slikk' ),
						'type'        => 'select',
						'options'     => array(
							'none'                  => esc_html__( 'None', 'slikk' ),
							'load_more'             => esc_html__( 'Load More', 'slikk' ),
							'standard_pagination'   => esc_html__( 'Numeric Pagination', 'slikk' ),
							'link_to_shop_category' => esc_html__( 'Link to Category', 'slikk' ),
							'link_to_shop'          => esc_html__( 'Link to Shop Archive', 'slikk' ),
						),
						'default'     => 'none',
						'admin_label' => true,
					),

					array(
						'param_name'  => 'product_category_link_id',
						'label'       => esc_html__( 'Category Link', 'slikk' ),
						'type'        => 'select',
						'options'     => slikk_get_product_cat_dropdown_options(),
						'condition'   => array(
							'pagination' => array( 'link_to_shop_category' ),
						),
						'admin_label' => true,
					),
				),
			),
		)
	);
}

/**
 * Artist Index
 */
function slikk_artist_index_params() {
	return apply_filters(
		'slikk_artist_index_params',
		array(
			'properties' => array(
				'name'          => esc_html__( 'Artists', 'slikk' ),
				'description'   => esc_html__( 'Display your artists using the theme layouts', 'slikk' ),
				'vc_base'       => 'wolf_core_artist_index',
				'el_base'       => 'artist-index',
				'vc_category'   => esc_html__( 'Content', 'slikk' ),
				'el_categories' => array( 'post-modules' ),
				'icon'          => 'fa fa-th',
				'weight'        => 999,
			),

			'params'     => array_merge(
				slikk_common_module_params(),
				array(

					array(
						'param_name'  => 'artist_display',
						'label'       => esc_html__( 'Artist Display', 'slikk' ),
						'type'        => 'select',
						'options'     => apply_filters(
							'slikk_artist_display_options',
							array(
								'list' => esc_html__( 'List', 'slikk' ),
							)
						),
						'admin_label' => true,
					),

					array(
						'param_name'  => 'artist_metro_pattern',
						'label'       => esc_html__( 'Metro Pattern', 'slikk' ),
						'type'        => 'select',
						'options'     => slikk_get_metro_patterns(),
						'default'     => 'auto',
						'condition'   => array(
							'artist_display' => 'metro',
						),
						'admin_label' => true,
					),

					array(
						'param_name'  => 'artist_module',
						'label'       => esc_html__( 'Module', 'slikk' ),
						'type'        => 'select',
						'options'     => array(
							'grid'     => esc_html__( 'Grid', 'slikk' ),
							'carousel' => esc_html__( 'Carousel', 'slikk' ),
						),
						'default'     => 'grid',
						'admin_label' => true,
						'condition'   => array(
							'artist_display' => array( 'grid' ),
						),
					),

					array(
						'param_name'  => 'artist_thumbnail_size',
						'label'       => esc_html__( 'Thumbnail Size', 'slikk' ),
						'type'        => 'select',
						'options'     => array(
							'standard'  => esc_html__( 'Default Thumbnail', 'slikk' ),
							'landscape' => esc_html__( 'Landscape', 'slikk' ),
							'square'    => esc_html__( 'Square', 'slikk' ),
							'portrait'  => esc_html__( 'Portrait', 'slikk' ),
							'custom'    => esc_html__( 'Custom', 'slikk' ),
						),
						'admin_label' => true,
						'condition'   => array(
							'artist_display' => array( 'grid', 'offgrid' ),
						),
					),

					array(
						'param_name'  => 'artist_custom_thumbnail_size',
						'label'       => esc_html__( 'Custom Thumbnail Size', 'slikk' ),
						'type'        => 'text',
						'admin_label' => true,
						'placeholder' => '415x230',
						'condition'   => array(
							'artist_thumbnail_size' => 'custom',
						),
					),

					array(
						'param_name'  => 'artist_layout',
						'label'       => esc_html__( 'Layout', 'slikk' ),
						'type'        => 'select',
						'options'     => array(
							'standard' => esc_html__( 'Classic', 'slikk' ),
							'overlay'  => esc_html__( 'Overlay', 'slikk' ),
						),
						'admin_label' => true,
						'condition'   => array(
							'artist_display' => array( 'grid', 'masonry', 'offgrid', 'metro' ),
						),
					),

					array(
						'param_name'  => 'grid_padding',
						'label'       => esc_html__( 'Padding', 'slikk' ),
						'type'        => 'select',
						'options'     => array(
							'yes' => esc_html__( 'Yes', 'slikk' ),
							'no'  => esc_html__( 'No', 'slikk' ),
						),
						'default'     => 'yes',
						'admin_label' => true,
					),

					array(
						'label'      => esc_html__( 'Caption Text Alignement', 'slikk' ),
						'param_name' => 'caption_text_alignment',
						'type'       => 'select',
						'options'    => array(
							esc_html__( 'Center', 'slikk' ) => 'center',
							esc_html__( 'Left', 'slikk' ) => 'left',
							esc_html__( 'Right', 'slikk' ) => 'right',
						),
						'condition'  => array(
							'element'            => 'artist_display',
							'value_not_equal_to' => array( 'list_minimal' ),
						),
					),

					array(
						'label'      => esc_html__( 'Caption Vertical Alignement', 'slikk' ),
						'param_name' => 'caption_v_align',
						'type'       => 'select',
						'options'    => array(
							esc_html__( 'Middle', 'slikk' ) => 'middle',
							esc_html__( 'Bottom', 'slikk' ) => 'bottom',
							esc_html__( 'Top', 'slikk' ) => 'top',
						),
						'condition'  => array(
							'element'            => 'artist_display',
							'value_not_equal_to' => array( 'list_minimal' ),
						),
					),

					array(
						'type'               => 'select',
						'label'              => esc_html__( 'Overlay Color', 'slikk' ),
						'param_name'         => 'overlay_color',
						'options'            => array_merge(
							array( 'auto' => esc_html__( 'Auto', 'slikk' ) ),
							slikk_shared_gradient_colors(),
							slikk_shared_colors(),
							array( 'custom' => esc_html__( 'Custom color', 'slikk' ) )
						),
						'default'            => apply_filters( 'wolf_core_default_item_overlay_color', 'black' ),
						'description'        => esc_html__( 'Select an overlay color.', 'slikk' ),
						'param_holder_class' => 'wolf_core_colored-select',
						'condition'          => array(
							'artist_layout' => array( 'overlay' ),
						),
					),
					array(
						'type'       => 'colorpicker',
						'label'      => esc_html__( 'Overlay Custom Color', 'slikk' ),
						'param_name' => 'overlay_custom_color',
						'condition'  => array(
							'artist_layout' => array( 'overlay' ),
							'overlay_color' => array( 'custom' ),
						),
					),
					array(
						'type'        => 'text',
						'label'       => esc_html__( 'Overlay Opacity in Percent', 'slikk' ),
						'param_name'  => 'overlay_opacity',
						'description' => '',
						'options'     => 40,
						'default'     => apply_filters( 'wolf_core_default_item_overlay_opacity', 40 ),
						'condition'   => array(
							'artist_layout' => array( 'overlay' ),
						),
					),
					array(
						'type'               => 'select',
						'label'              => esc_html__( 'Overlay Text Color', 'slikk' ),
						'param_name'         => 'overlay_text_color',
						'options'            => array_merge(
							slikk_shared_colors(),
							slikk_shared_gradient_colors(),
							array( 'custom' => esc_html__( 'Custom', 'slikk' ) )
						),
						'default'            => apply_filters( 'wolf_core_default_item_overlay_text_color', 'white' ),
						'description'        => esc_html__( 'Select an overlay color.', 'slikk' ),
						'param_holder_class' => 'wolf_core_colored-select',
						'condition'          => array(
							'artist_layout' => array( 'overlay' ),
						),
					),

					array(
						'type'       => 'colorpicker',
						'label'      => esc_html__( 'Overlay Custom Text Color', 'slikk' ),
						'param_name' => 'overlay_text_custom_color',
						'default'    => '#000000',
						'condition'  => array(
							'artist_layout'      => array( 'overlay' ),
							'overlay_text_color' => array( 'custom' ),
						),
					),

					array(
						'label'        => esc_html__( 'Category Filter', 'slikk' ),
						'param_name'   => 'artist_category_filter',
						'type'         => 'checkbox',
						'label_on'     => esc_html__( 'Yes', 'slikk' ),
						'label_off'    => esc_html__( 'No', 'slikk' ),
						'return_value' => 'no',
						'admin_label'  => true,
						'description'  => esc_html__( 'The pagination will be disabled.', 'slikk' ),
					),

					array(
						'label'        => esc_html__( 'Filter Text Alignement', 'slikk' ),
						'param_name'   => 'artist_category_filter_text_alignment',
						'type'         => 'choose',
						'options'      => array(
							'left'   => array(
								'title' => esc_html__( 'Left', 'wolf-core' ),
								'icon'  => 'eicon-text-align-left',
							),
							'center' => array(
								'title' => esc_html__( 'Center', 'wolf-core' ),
								'icon'  => 'eicon-text-align-center',
							),
							'right'  => array(
								'title' => esc_html__( 'Right', 'wolf-core' ),
								'icon'  => 'eicon-text-align-right',
							),
						),
						'selectors'    => array(
							'{{WRAPPER}} .category-filter-artist ul' => 'text-align:{{VALUE}};',
						),
						'condition'    => array(
							'artist_category_filter' => 'yes',
						),
						'page_builder' => 'elementor',
					),

					array(
						'label'        => esc_html__( 'Filter Text Alignement', 'slikk' ),
						'param_name'   => 'artist_category_filter_text_alignment',
						'type'         => 'select',
						'options'      => array(
							'center' => esc_html__( 'Center', 'wolf-core' ),
							'left'   => esc_html__( 'Left', 'wolf-core' ),
							'right'  => esc_html__( 'Right', 'wolf-core' ),
						),
						'condition'    => array(
							'artist_category_filter' => 'yes',
						),
						'page_builder' => 'vc',
					),

					array(
						'param_name'  => 'pagination',
						'label'       => esc_html__( 'Pagination', 'slikk' ),
						'type'        => 'select',
						'options'     => array(
							'none'                => esc_html__( 'None', 'slikk' ),
							'load_more'           => esc_html__( 'Load More', 'slikk' ),
							'standard_pagination' => esc_html__( 'Numeric Pagination', 'slikk' ),
							'link_to_artists'     => esc_html__( 'Link to Archives', 'slikk' ),
						),
						'condition'   => array(
							'artist_category_filter' => '',
						),
						'admin_label' => true,
					),

					array(
						'type'        => 'text',
						'label'       => esc_html__( 'Include Category', 'slikk' ),
						'param_name'  => 'artist_genre_include',
						'description' => esc_html__( 'Enter one or several categories. Paste category slug(s) separated by a comma', 'slikk' ),
						'placeholder' => esc_html__( 'my-category, other-category', 'slikk' ),
						'group'       => esc_html__( 'Query', 'slikk' ),
					),

					array(
						'type'        => 'text',
						'label'       => esc_html__( 'Exclude Category', 'slikk' ),
						'param_name'  => 'artist_genre_exclude',
						'description' => esc_html__( 'Enter one or several categories. Paste category slug(s) separated by a comma', 'slikk' ),
						'placeholder' => esc_html__( 'my-category, other-category', 'slikk' ),
						'group'       => esc_html__( 'Query', 'slikk' ),
					),

					array(
						'type'        => 'select',
						'label'       => esc_html__( 'Order by', 'slikk' ),
						'param_name'  => 'orderby',
						'options'     => slikk_order_by_values(),
						'save_always' => true,
						'description' => sprintf( wp_kses_post( __( 'Select how to sort retrieved posts. More at %s.', 'slikk' ) ), 'WordPress codex page' ),
						'group'       => esc_html__( 'Query', 'slikk' ),
					),

					array(
						'type'        => 'select',
						'label'       => esc_html__( 'Sort order', 'slikk' ),
						'param_name'  => 'order',
						'options'     => slikk_order_way_values(),
						'save_always' => true,
						'description' => sprintf( wp_kses_post( __( 'Designates the ascending or descending order. More at %s.', 'slikk' ) ), 'WordPress codex page' ),
						'group'       => esc_html__( 'Query', 'slikk' ),
					),

					array(
						'type'        => 'text',
						'label'       => esc_html__( 'Post IDs', 'slikk' ),
						'description' => esc_html__( 'By default, your last posts will be displayed. You can choose the posts you want to display by entering a list of IDs separated by a comma.', 'slikk' ),
						'param_name'  => 'include_ids',
						'group'       => esc_html__( 'Query', 'slikk' ),
					),

					array(
						'type'        => 'text',
						'label'       => esc_html__( 'Exclude Post IDs', 'slikk' ),
						'description' => esc_html__( 'You can choose the posts you don\'t want to display by entering a list of IDs separated by a comma.', 'slikk' ),
						'param_name'  => 'exclude_ids',
						'group'       => esc_html__( 'Query', 'slikk' ),
					),

					array(
						'param_name'  => 'columns',
						'label'       => esc_html__( 'Columns', 'slikk' ),
						'type'        => 'select',
						'options'     => array(
							'default' => esc_html__( 'Auto', 'slikk' ),
							2         => esc_html__( 'Two', 'slikk' ),
							3         => esc_html__( 'Three', 'slikk' ),
							4         => esc_html__( 'Four', 'slikk' ),
							5         => esc_html__( 'Five', 'slikk' ),
							6         => esc_html__( 'Six', 'slikk' ),
							1         => esc_html__( 'One', 'slikk' ),
						),
						'default'     => 3,
						'admin_label' => true,
						'condition'   => array(
							'artist_display' => array( 'grid', 'masonry' ),
						),
					),
				),
			),
		)
	);
}

/**
 * Photo Album Index
 */
function slikk_album_index_params() {
	return apply_filters(
		'slikk_album_index_params',
		array(
			'properties' => array(
				'name'          => esc_html__( 'Photo Albums', 'slikk' ),
				'description'   => esc_html__( 'Display your albums using the theme layouts', 'slikk' ),
				'vc_base'       => 'wolf_core_album_index',
				'el_base'       => 'album-index',
				'vc_category'   => esc_html__( 'Content', 'slikk' ),
				'el_categories' => array( 'post-modules' ),
				'icon'          => 'fa fa-th',
				'weight'        => 999,
			),

			'params'     => array_merge(
				slikk_common_module_params(),
				array(),
			),
		)
	);
}

/**
 * Video Index
 */
function slikk_video_index_params() {
	return apply_filters(
		'slikk_video_index_params',
		array(
			'properties' => array(
				'name'          => esc_html__( 'Videos', 'slikk' ),
				'description'   => esc_html__( 'Display your videos using the theme layouts', 'slikk' ),
				'vc_base'       => 'wolf_core_video_index',
				'el_base'       => 'video-index',
				'vc_category'   => esc_html__( 'Content', 'slikk' ),
				'el_categories' => array( 'post-modules' ),
				'icon'          => 'fa fa-th',
				'weight'        => 999,
			),

			'params'     => array_merge(
				slikk_common_module_params(),
				array(
					array(
						'label'        => esc_html__( 'Show video on hover', 'slikk' ),
						'description'  => esc_html__( 'It is recommended to set upload a video sample mp4 file in your video post options below the text editor.', 'slikk' ),
						'param_name'   => 'video_preview',
						'type'         => 'checkbox',
						'label_on'     => esc_html__( 'Yes', 'slikk' ),
						'label_off'    => esc_html__( 'No', 'slikk' ),
						'return_value' => 'yes',
						'admin_label'  => true,
					),

					array(
						'param_name'  => 'video_module',
						'label'       => esc_html__( 'Module', 'slikk' ),
						'type'        => 'select',
						'options'     => array(
							'grid'     => esc_html__( 'Grid', 'slikk' ),
							'carousel' => esc_html__( 'Carousel', 'slikk' ),
						),
						'default'     => 'grid',
						'admin_label' => true,
					),

					array(
						'param_name'  => 'video_custom_thumbnail_size',
						'label'       => esc_html__( 'Custom Thumbnail Size', 'slikk' ),
						'type'        => 'text',
						'admin_label' => true,
						'placeholder' => '415x230',
					),

					array(
						'param_name'  => 'grid_padding',
						'label'       => esc_html__( 'Padding', 'slikk' ),
						'type'        => 'select',
						'options'     => array(
							'yes' => esc_html__( 'Yes', 'slikk' ),
							'no'  => esc_html__( 'No', 'slikk' ),
						),
						'default'     => 'yes',
						'admin_label' => true,
					),

					array(
						'param_name'  => 'video_onclick',
						'label'       => esc_html__( 'On Click', 'slikk' ),
						'type'        => 'select',
						'options'     => array(
							'lightbox' => esc_html__( 'Open Video in Lightbox', 'slikk' ),
							'default'  => esc_html__( 'Go to the Video Page', 'slikk' ),
						),
						'default'     => 'lightbox',
						'admin_label' => true,
					),

					array(
						'label'        => esc_html__( 'Category Filter', 'slikk' ),
						'param_name'   => 'video_category_filter',
						'type'         => 'checkbox',
						'label_on'     => esc_html__( 'Yes', 'slikk' ),
						'label_off'    => esc_html__( 'No', 'slikk' ),
						'return_value' => 'yes',
						'admin_label'  => true,
						'description'  => esc_html__( 'The pagination will be disabled.', 'slikk' ),
					),

					array(
						'label'        => esc_html__( 'Filter Text Alignement', 'slikk' ),
						'param_name'   => 'video_category_filter_text_alignment',
						'type'         => 'choose',
						'options'      => array(
							'left'   => array(
								'title' => esc_html__( 'Left', 'wolf-core' ),
								'icon'  => 'eicon-text-align-left',
							),
							'center' => array(
								'title' => esc_html__( 'Center', 'wolf-core' ),
								'icon'  => 'eicon-text-align-center',
							),
							'right'  => array(
								'title' => esc_html__( 'Right', 'wolf-core' ),
								'icon'  => 'eicon-text-align-right',
							),
						),
						'selectors'    => array(
							'{{WRAPPER}} .category-filter-video ul' => 'text-align:{{VALUE}};',
						),
						'condition'    => array(
							'video_category_filter' => 'yes',
						),
						'page_builder' => 'elementor',
					),

					array(
						'label'        => esc_html__( 'Filter Text Alignement', 'slikk' ),
						'param_name'   => 'video_category_filter_text_alignment',
						'type'         => 'select',
						'options'      => array(
							'center' => esc_html__( 'Center', 'wolf-core' ),
							'left'   => esc_html__( 'Left', 'wolf-core' ),
							'right'  => esc_html__( 'Right', 'wolf-core' ),
						),
						'condition'    => array(
							'video_category_filter' => 'yes',
						),
						'page_builder' => 'vc',
					),

					array(
						'param_name'  => 'pagination',
						'label'       => esc_html__( 'Pagination', 'slikk' ),
						'type'        => 'select',
						'options'     => array(
							'none'                => esc_html__( 'None', 'slikk' ),
							'load_more'           => esc_html__( 'Load More', 'slikk' ),
							'standard_pagination' => esc_html__( 'Numeric Pagination', 'slikk' ),
							'link_to_videos'      => esc_html__( 'Link to Video Archives', 'slikk' ),
						),
						'condition'   => array(
							'video_category_filter' => '',
						),
						'default'     => 'none',
						'admin_label' => true,
					),

					array(
						'param_name'  => 'video_category_link_id',
						'label'       => esc_html__( 'Category', 'slikk' ),
						'type'        => 'select',
						'options'     => slikk_get_video_cat_dropdown_options(),
						'condition'   => array(
							'pagination' => 'link_to_video_category',
						),
						'admin_label' => true,
					),

					array(
						'type'        => 'text',
						'label'       => esc_html__( 'Include Category', 'slikk' ),
						'param_name'  => 'video_type_include',
						'description' => esc_html__( 'Enter one or several categories. Paste category slug(s) separated by a comma', 'slikk' ),
						'placeholder' => esc_html__( 'my-category, other-category', 'slikk' ),
						'group'       => esc_html__( 'Query', 'slikk' ),
					),

					array(
						'type'        => 'text',
						'label'       => esc_html__( 'Exclude Category', 'slikk' ),
						'param_name'  => 'video_type_exclude',
						'description' => esc_html__( 'Enter one or several categories. Paste category slug(s) separated by a comma', 'slikk' ),
						'placeholder' => esc_html__( 'my-category, other-category', 'slikk' ),
						'group'       => esc_html__( 'Query', 'slikk' ),
					),

					array(
						'type'        => 'text',
						'label'       => esc_html__( 'Include Tag', 'slikk' ),
						'param_name'  => 'video_tag_include',
						'description' => esc_html__( 'Enter one or several tags. Paste category slug(s) separated by a comma', 'slikk' ),
						'placeholder' => esc_html__( 'my-tag, other-tag', 'slikk' ),
						'group'       => esc_html__( 'Query', 'slikk' ),
					),

					array(
						'type'        => 'text',
						'label'       => esc_html__( 'Exclude Tag', 'slikk' ),
						'param_name'  => 'video_tag_exclude',
						'description' => esc_html__( 'Enter one or several tags. Paste category slug(s) separated by a comma', 'slikk' ),
						'placeholder' => esc_html__( 'my-tag, other-tag', 'slikk' ),
						'group'       => esc_html__( 'Query', 'slikk' ),
					),

					array(
						'type'        => 'select',
						'label'       => esc_html__( 'Order by', 'slikk' ),
						'param_name'  => 'orderby',
						'options'     => slikk_order_by_values(),
						'save_always' => true,
						'description' => sprintf( wp_kses_post( __( 'Select how to sort retrieved posts. More at %s.', 'slikk' ) ), 'WordPress codex page' ),
						'group'       => esc_html__( 'Query', 'slikk' ),
					),

					array(
						'type'        => 'select',
						'label'       => esc_html__( 'Sort order', 'slikk' ),
						'param_name'  => 'order',
						'options'     => slikk_order_way_values(),
						'save_always' => true,
						'description' => sprintf( wp_kses_post( __( 'Designates the ascending or descending order. More at %s.', 'slikk' ) ), 'WordPress codex page' ),
						'group'       => esc_html__( 'Query', 'slikk' ),
					),

					array(
						'type'        => 'text',
						'label'       => esc_html__( 'Post IDs', 'slikk' ),
						'description' => esc_html__( 'By default, your last posts will be displayed. You can choose the posts you want to display by entering a list of IDs separated by a comma.', 'slikk' ),
						'param_name'  => 'include_ids',
						'group'       => esc_html__( 'Query', 'slikk' ),
					),

					array(
						'type'        => 'text',
						'label'       => esc_html__( 'Exclude Post IDs', 'slikk' ),
						'description' => esc_html__( 'You can choose the posts you don\'t want to display by entering a list of IDs separated by a comma.', 'slikk' ),
						'param_name'  => 'exclude_ids',
						'group'       => esc_html__( 'Query', 'slikk' ),
					),

					array(
						'param_name'  => 'columns',
						'label'       => esc_html__( 'Columns', 'slikk' ),
						'type'        => 'select',
						'options'     => array(
							'default' => esc_html__( 'Auto', 'slikk' ),
							2         => esc_html__( 'Two', 'slikk' ),
							3         => esc_html__( 'Three', 'slikk' ),
							4         => esc_html__( 'Four', 'slikk' ),
							5         => esc_html__( 'Five', 'slikk' ),
							6         => esc_html__( 'Six', 'slikk' ),
							1         => esc_html__( 'One', 'slikk' ),
						),
						'default'     => 3,
						'admin_label' => true,
					),
				),
			),
		)
	);
}

/**
 * Event Index
 */
function slikk_event_index_params() {
	return apply_filters(
		'slikk_event_index_params',
		array(
			'properties' => array(
				'name'          => esc_html__( 'Events', 'slikk' ),
				'description'   => esc_html__( 'Display your events using the theme layouts', 'slikk' ),
				'vc_base'       => 'wolf_core_event_index',
				'el_base'       => 'event-index',
				'vc_category'   => esc_html__( 'Content', 'slikk' ),
				'el_categories' => array( 'post-modules' ),
				'icon'          => 'fa fa-th',
				'weight'        => 999,
				'scripts'       => array( 'flickity', 'slikk-carousels' ),
			),

			'params'     => array_merge(
				slikk_common_module_params(),
				array(
					array(
						'param_name'  => 'event_display',
						'label'       => esc_html__( 'Event Display', 'slikk' ),
						'type'        => 'select',
						'options'     => apply_filters(
							'slikk_event_display_options',
							array(
								'list' => esc_html__( 'List', 'slikk' ),
							)
						),
						'default'     => 'list',
						'admin_label' => true,
					),

					array(
						'param_name'  => 'event_layout',
						'label'       => esc_html__( 'Event Layout', 'slikk' ),
						'type'        => 'hidden',
						'default'     => 'overlay',
					),

					array(
						'param_name'  => 'event_module',
						'label'       => esc_html__( 'Module', 'slikk' ),
						'type'        => 'select',
						'options'     => array(
							'grid'     => esc_html__( 'Grid', 'slikk' ),
							'carousel' => esc_html__( 'Carousel', 'slikk' ),
						),
						'default'     => 'grid',
						'admin_label' => true,
						'condition'   => array(
							'event_display' => array( 'grid' ),
						),
					),

					array(
						'param_name'  => 'event_thumbnail_size',
						'label'       => esc_html__( 'Thumbnail Size', 'slikk' ),
						'type'        => 'select',
						'options'     => array(
							'standard'  => esc_html__( 'Default Thumbnail', 'slikk' ),
							'landscape' => esc_html__( 'Landscape', 'slikk' ),
							'square'    => esc_html__( 'Square', 'slikk' ),
							'portrait'  => esc_html__( 'Portrait', 'slikk' ),
							'custom'    => esc_html__( 'Custom', 'slikk' ),
						),
						'default'     => 'standard',
						'admin_label' => true,
						'condition'   => array(
							'event_display' => array( 'grid' ),
						),
					),

					array(
						'param_name'  => 'event_custom_thumbnail_size',
						'label'       => esc_html__( 'Custom Thumbnail Size', 'slikk' ),
						'type'        => 'text',
						'admin_label' => true,
						'placeholder' => '415x230',
						'condition'   => array(
							'event_thumbnail_size' => 'custom',
						),
					),
				),
				slikk_overlay_module_params( 'event' ),
				array(
					array(
						'param_name'  => 'grid_padding',
						'label'       => esc_html__( 'Padding', 'slikk' ),
						'type'        => 'select',
						'options'     => array(
							'yes' => esc_html__( 'Yes', 'slikk' ),
							'no'  => esc_html__( 'No', 'slikk' ),
						),
						'default'     => 'yes',
						'admin_label' => true,
						'condition'   => array(
							'event_display' => array( 'grid' ),
						),
					),

					array(
						'param_name'  => 'columns',
						'label'       => esc_html__( 'Columns', 'slikk' ),
						'type'        => 'select',
						'options'     => array(
							'default' => esc_html__( 'Auto', 'slikk' ),
							2         => esc_html__( 'Two', 'slikk' ),
							3         => esc_html__( 'Three', 'slikk' ),
							4         => esc_html__( 'Four', 'slikk' ),
							5         => esc_html__( 'Five', 'slikk' ),
							6         => esc_html__( 'Six', 'slikk' ),
							1         => esc_html__( 'One', 'slikk' ),
						),
						'default'     => 3,
						'admin_label' => true,
						'condition'   => array(
							'event_display' => array( 'grid' ),
						),
					),

					array(
						'param_name'  => 'event_location',
						'label'       => esc_html__( 'Location', 'slikk' ),
						'type'        => 'select',
						'options'     => array(
							'location' => esc_html__( 'Location', 'slikk' ),
							'venue'    => esc_html__( 'Venue', 'slikk' ),
						),
						'default'     => 'location',
						'admin_label' => true,
					),

					array(
						'param_name'  => 'pagination',
						'label'       => esc_html__( 'Pagination', 'slikk' ),
						'type'        => 'select',
						'options'     => array(
							'none'           => esc_html__( 'None', 'slikk' ),
							'link_to_events' => esc_html__( 'Link to Event Archives', 'slikk' ),
						),
						'default'     => 'link_to_events',
						'admin_label' => true,
					),

					array(
						'type'       => 'select',
						'label'      => esc_html__( 'Timeline', 'slikk' ),
						'param_name' => 'timeline',
						'options'    => array(
							'future' => esc_html__( 'Future', 'slikk' ),
							'past'   => esc_html__( 'Past', 'slikk' ),
						),
						'default'    => 'future',
						'group'      => esc_html__( 'Query', 'slikk' ),
					),

					array(
						'type'        => 'text',
						'label'       => esc_html__( 'Include Artist', 'slikk' ),
						'param_name'  => 'artist_include',
						'description' => esc_html__( 'Enter one or several bands. Paste category slug(s) separated by a comma', 'slikk' ),
						'placeholder' => esc_html__( 'my-category, other-category', 'slikk' ),
						'group'       => esc_html__( 'Query', 'slikk' ),
					),

					array(
						'type'        => 'text',
						'label'       => esc_html__( 'Exclude Artist', 'slikk' ),
						'param_name'  => 'artist_exclude',
						'description' => esc_html__( 'Enter one or several bands. Paste category slug(s) separated by a comma', 'slikk' ),
						'placeholder' => esc_html__( 'my-category, other-category', 'slikk' ),
						'group'       => esc_html__( 'Query', 'slikk' ),
					),
				)
			),
		)
	);
}

/**
 * Work Index
 */
function slikk_work_index_params() {
	return apply_filters(
		'slikk_work_index_params',
		array(
			'properties' => array(
				'name'          => esc_html__( 'Works', 'slikk' ),
				'description'   => esc_html__( 'Display your works using the theme layouts', 'slikk' ),
				'vc_base'       => 'wolf_core_work_index',
				'el_base'       => 'work-index',
				'vc_category'   => esc_html__( 'Content', 'slikk' ),
				'el_categories' => array( 'post-modules' ),
				'icon'          => 'fa fa-th',
				'weight'        => 999,
			),

			'params'     => array_merge(
				slikk_common_module_params(),
				array(),
			),
		)
	);
}

/**
 * Page Index
 */
function slikk_page_index_params() {
	return apply_filters(
		'slikk_page_index_params',
		array(
			'properties' => array(
				'name'          => esc_html__( 'Pages', 'slikk' ),
				'description'   => esc_html__( 'Display your pages using the theme layouts', 'slikk' ),
				'vc_base'       => 'wolf_core_page_index',
				'el_base'       => 'page-index',
				'vc_category'   => esc_html__( 'Content', 'slikk' ),
				'el_categories' => array( 'post-modules' ),
				'icon'          => 'fa fa-th',
				'weight'        => 999,
			),

			'params'     => array_merge(
				slikk_common_module_params(),
				array()
			),
		)
	);
}
