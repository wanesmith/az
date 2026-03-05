<?php
/**
 * WPBakery Page Builder post modules
 *
 * @package WordPress
 * @subpackage Slikk
 * @version 1.4.2
 */

if ( ! defined( 'ABSPATH' ) || ! class_exists( 'Wolf_Visual_Composer' ) || ! defined( 'WPB_VC_VERSION' ) ) {
	return;
}

$order_by_values = array(
	'',
	esc_html__( 'Date', 'slikk' ) => 'date',
	esc_html__( 'ID', 'slikk' ) => 'ID',
	esc_html__( 'Author', 'slikk' ) => 'author',
	esc_html__( 'Title', 'slikk' ) => 'title',
	esc_html__( 'Modified', 'slikk' ) => 'modified',
	esc_html__( 'Random', 'slikk' ) => 'rand',
	esc_html__( 'Comment count', 'slikk' ) => 'comment_count',
	esc_html__( 'Menu order', 'slikk' ) => 'menu_order',
);

$order_way_values = array(
	'',
	esc_html__( 'Descending', 'slikk' ) => 'DESC',
	esc_html__( 'Ascending', 'slikk' ) => 'ASC',
);

$shared_gradient_colors = ( function_exists( 'wvc_get_shared_gradient_colors' ) ) ? wvc_get_shared_gradient_colors() : array();
$shared_colors = ( function_exists( 'wvc_get_shared_colors' ) ) ? wvc_get_shared_colors() : array();

/**
 * Post Loop Module
 */
vc_map(
	array(
		'name' => esc_html__( 'Posts', 'slikk' ),
		'description' => esc_html__( 'Display your posts using the theme layouts', 'slikk' ),
		'base' => 'wvc_post_index',
		'category' => esc_html__( 'Content' , 'slikk' ),
		'icon' => 'fa fa-th',
		'weight' => 999,
		'params' =>
		//array_merge(
			array(

				array(
					'type' => 'wvc_textfield',
					'heading' => esc_html__( 'Index ID', 'slikk' ),
					'value' => 'index-' . rand( 0,99999 ),
					'param_name' => 'el_id',
					'description' => esc_html__( 'A unique identifier for the post module (required).', 'slikk' ),
				),

				array(
					'param_name' => 'post_display',
					'heading' => esc_html__( 'Post Display', 'slikk' ),
					'type' => 'dropdown',
					'value' => array_flip( apply_filters( 'slikk_post_display_options', array(
						'standard' => esc_html__( 'Standard', 'slikk' ),
					) ) ),
					'std' => 'grid',
					'admin_label' => true,
				),

				array(
					'param_name' => 'post_metro_pattern',
					'heading' => esc_html__( 'Metro Pattern', 'slikk' ),
					'type' => 'dropdown',
					'value' => slikk_get_metro_patterns(),
					'std' => 'auto',
					'dependency' => array( 'element' => 'post_display', 'value' => array( 'metro_modern_alt', 'metro' ) ),
					'admin_label' => true,
				),

				array(
					'param_name' => 'post_alternate_thumbnail_position',
					'heading' => esc_html__( 'Alternate thumbnail position', 'slikk' ),
					'type' => 'checkbox',
					'dependency' => array(
						'element' => 'post_display',
						'value' => array( 'lateral' )
					),
				),

				array(
					'param_name' => 'post_module',
					'heading' => esc_html__( 'Module', 'slikk' ),
					'type' => 'dropdown',
					'value' => array(
						esc_html__( 'Grid', 'slikk' ) => 'grid',
						esc_html__( 'Carousel', 'slikk' ) => 'carousel',
					),
					'admin_label' => true,
					'dependency' => array(
						'element' => 'post_display',
						'value' => array( 'grid_classic', 'grid_modern' )
					),
				),

				array(
					'param_name' => 'post_excerpt_length',
					'heading' => esc_html__( 'Post Excerpt Lenght', 'slikk' ),
					'type' => 'dropdown',
					'value' => array(
						esc_html__( 'Shorten', 'slikk' ) => 'shorten',
						esc_html__( 'Full', 'slikk' ) => 'full',
					),
					'dependency' => array(
						'element' => 'post_display',
						'value' => array( 'masonry' ),
					),
				),

				array(
					'param_name' => 'post_display_elements',
					'heading' => esc_html__( 'Elements', 'slikk' ),
					'type' => 'checkbox',
					'value' => array(
						esc_html__( 'Thumbnail', 'slikk' ) => 'show_thumbnail',
						esc_html__( 'Date', 'slikk' ) => 'show_date',
						esc_html__( 'Text', 'slikk' ) => 'show_text',
						esc_html__( 'Category', 'slikk' ) => 'show_category',
						esc_html__( 'Author', 'slikk' ) => 'show_author',
						esc_html__( 'Tags', 'slikk' ) => 'show_tags',
						esc_html__( 'Extra Meta', 'slikk' ) => 'show_extra_meta',
					),
					'std' => 'show_thumbnail,show_date,show_text,show_author,show_category',
					// 'dependency' => array(
					// 	'element' => 'post_display',
					// 	'value' => array( 'masonry', 'grid_classic', 'grid_modern', 'mosaic', 'metro', 'standard' ),
					// ),
					'description' => esc_html__( 'Note that some options may be ignored depending on the post display.', 'slikk' ),
					'admin_label' => true,
				),

				array(
					'param_name' => 'post_excerpt_type',
					'heading' => esc_html__( 'Post Excerpt Type', 'slikk' ),
					'type' => 'dropdown',
					'value' => array(
						esc_html__( 'Auto', 'slikk' ) => 'auto',
						esc_html__( 'Manual', 'slikk' ) => 'manual',
					),
					'description' => sprintf(
						wp_kses_post( __( 'When using the manual excerpt, you must split your post using a "<a href="%s">More Tag</a>".', 'slikk' ) ),
						esc_url( 'https://en.support.wordpress.com/more-tag/' )
					),
					'dependency' => array(
						'element' => 'post_display',
						'value' => array( 'standard', 'standard_modern' ),
					),
				),

				array(
					'param_name' => 'grid_padding',
					'heading' => esc_html__( 'Padding', 'slikk' ),
					'type' => 'dropdown',
					'value' => array(
						esc_html__( 'Yes', 'slikk' ) => 'yes',
						esc_html__( 'No', 'slikk' ) => 'no',
					),
					'admin_label' => true,
					'dependency' => array(
						'element' => 'post_display',
						'value_not_equal_to' => array( 'standard', 'standard_modern', 'masonry_modern', 'offgrid' ),
						// value_not_equal_to
					),
				),

				// array(
				// 	'heading' => esc_html__( 'Category Filter', 'slikk' ),
				// 	'param_name' => 'post_category_filter',
				// 	'type' => 'checkbox',
				// 	'admin_label' => true,
				// ),

				array(
					'param_name' => 'pagination',
					'heading' => esc_html__( 'Pagination', 'slikk' ),
					'type' => 'dropdown',
					'value' => array(
						esc_html__( 'None', 'slikk' ) => 'none',
						esc_html__( 'Load More', 'slikk' ) => 'load_more',
						esc_html__( 'Numeric Pagination', 'slikk' ) => 'standard_pagination',
						esc_html__( 'Link to Blog Archives', 'slikk' ) => 'link_to_blog',
					),
					'admin_label' => true,
					//'dependency' => array( 'element' => 'post_module', 'value' => array( 'grid' ) ),
				),

				array(
					'heading' => esc_html__( 'Animation', 'slikk' ),
					'param_name' => 'item_animation',
					'type' => 'dropdown',
					'value' => array_flip( slikk_get_animations() ),
					'admin_label' => true,
				),

				array(
					'heading' => esc_html__( 'Posts Per Page', 'slikk' ),
					'param_name' => 'posts_per_page',
					'type' => 'wvc_textfield',
					'value' => get_option( 'posts_per_page' ),
					'admin_label' => true,
				),

				array(
					'heading' => esc_html__( 'Additional CSS inline style', 'slikk' ),
					'param_name' => 'inline_style',
					'type' => 'wvc_textfield',
					//'admin_label' => true,
				),

				array(
					'type' => 'wvc_textfield',
					'heading' => esc_html__( 'Offset', 'slikk' ),
					'param_name' => 'offset',
					'description' => esc_html__( 'The amount of posts that should be skipped in the beginning of the query. If an offset is set, sticky posts will be ignored.', 'slikk' ),
					'group' => esc_html__( 'Query', 'slikk' ),
					'admin_label' => true,
				),

				array(
					'type' => 'checkbox',
					'heading' => esc_html__( 'Ignore Sticky Posts', 'slikk' ),
					'param_name' => 'ignore_sticky_posts',
					'description' => esc_html__( 'It will still include the sticky posts but it will not prioritize them in the query.', 'slikk' ),
					'group' => esc_html__( 'Query', 'slikk' ),
				),

				array(
					'type' => 'checkbox',
					'heading' => esc_html__( 'Exclude Sticky Posts', 'slikk' ),
					'description' => esc_html__( 'It will still exclude the sticky posts.', 'slikk' ),
					'param_name' => 'exclude_sticky_posts',
					'group' => esc_html__( 'Query', 'slikk' ),
				),

				array(
					'type' => 'wvc_textfield',
					'heading' => esc_html__( 'Category', 'slikk' ),
					'param_name' => 'category',
					'description' => esc_html__( 'Include only one or several categories. Paste category slug(s) separated by a comma', 'slikk' ),
					'placeholder' => esc_html__( 'my-category, other-category', 'slikk' ),
					'group' => esc_html__( 'Query', 'slikk' ),
				),

				array(
					'type' => 'wvc_textfield',
					'heading' => esc_html__( 'Exclude Category by ID', 'slikk' ),
					'param_name' => 'category_exclude',
					'description' => esc_html__( 'Exclude only one or several categories. Paste category ID(s) separated by a comma', 'slikk' ),
					'placeholder' => esc_html__( '456, 756', 'slikk' ),
					'group' => esc_html__( 'Query', 'slikk' ),
				),

				array(
					'type' => 'wvc_textfield',
					'heading' => esc_html__( 'Tags', 'slikk' ),
					'param_name' => 'tag',
					'description' => esc_html__( 'Include only one or several tags. Paste tag slug(s) separated by a comma', 'slikk' ),
					'placeholder' => esc_html__( 'my-tag, other-tag', 'slikk' ),
					'group' => esc_html__( 'Query', 'slikk' ),
				),

				array(
					'type' => 'wvc_textfield',
					'heading' => esc_html__( 'Exclude Tags by ID', 'slikk' ),
					'param_name' => 'tag_exclude',
					'description' => esc_html__( 'Exclude only one or several tags. Paste tag ID(s) separated by a comma', 'slikk' ),
					'placeholder' => esc_html__( '456, 756', 'slikk' ),
					'group' => esc_html__( 'Query', 'slikk' ),
				),

				array(
					'type' => 'dropdown',
					'heading' => esc_html__( 'Order by', 'slikk' ),
					'param_name' => 'orderby',
					'value' => $order_by_values,
					'save_always' => true,
					'description' => sprintf( wp_kses_post( __( 'Select how to sort retrieved posts. More at %s.', 'slikk' ) ), '<a href="http://codex.wordpress.org/Class_Reference/WP_Query#Order_.26_Orderby_Parameters" target="_blank">WordPress codex page</a>' ),
					'group' => esc_html__( 'Query', 'slikk' ),
				),

				array(
					'type' => 'dropdown',
					'heading' => esc_html__( 'Sort order', 'slikk' ),
					'param_name' => 'order',
					'value' => $order_way_values,
					'save_always' => true,
					'description' => sprintf( wp_kses_post( __( 'Designates the ascending or descending order. More at %s.', 'slikk' ) ), '<a href="http://codex.wordpress.org/Class_Reference/WP_Query#Order_.26_Orderby_Parameters" target="_blank">WordPress codex page</a>' ),
					'group' => esc_html__( 'Query', 'slikk' ),
				),

				array(
					'type' => 'wvc_textfield',
					'heading' => esc_html__( 'Post IDs', 'slikk' ),
					'description' => esc_html__( 'By default, your last posts will be displayed. You can choose the posts you want to display by entering a list of IDs separated by a comma.', 'slikk' ),
					'param_name' => 'include_ids',
					'group' => esc_html__( 'Query', 'slikk' ),
				),

				array(
					'type' => 'wvc_textfield',
					'heading' => esc_html__( 'Exclude Post IDs', 'slikk' ),
					'description' => esc_html__( 'You can choose the posts you don\'t want to display by entering a list of IDs separated by a comma.', 'slikk' ),
					'param_name' => 'exclude_ids',
					'group' => esc_html__( 'Query', 'slikk' ),
				),

				array(
					'param_name' => 'columns',
					'heading' => esc_html__( 'Columns', 'slikk' ),
					'type' => 'dropdown',
					'value' => array(
						esc_html__( 'Auto', 'slikk' ) => 'default',
						esc_html__( 'Two', 'slikk' ) => 2,
						esc_html__( 'Three', 'slikk' ) => 3,
						esc_html__( 'Four', 'slikk' ) => 4,
						esc_html__( 'Six', 'slikk' ) => 6,
						esc_html__( 'One', 'slikk' ) => 1,
					),
					'std' => 'default',
					'admin_label' => true,
					'description' => esc_html__( 'By default, columns are set automatically depending on the container\'s width. Set a column count here to overwrite the default behavior.', 'slikk' ),
					'dependency' => array(
						'element' => 'post_display',
						'value_not_equal_to' => array( 'standard', 'standard_modern', 'lateral', 'list' ),
					),
					'group' => esc_html__( 'Extra', 'slikk' ),
				),

				array(
					'type' => 'wvc_textfield',
					'heading' => esc_html__( 'Extra class name', 'slikk' ),
					'param_name' => 'el_class',
					'description' => esc_html__( 'Style particular content element differently - add a class name and refer to it in custom CSS.', 'slikk' ),
					'group' => esc_html__( 'Extra', 'slikk' ),
				),
			),
			//),

			// 	array(
			// 		'heading' => esc_html__( 'Additional CSS inline style', 'slikk' ),
			// 		'param_name' => 'inline_style',
			// 		'type' => 'wvc_textfield',
			// 		//'admin_label' => true,
			// 	),
			// ),
		//)
	)
);
class WPBakeryShortCode_Wvc_Post_Index extends WPBakeryShortCode {}

if ( class_exists( 'Wolf_Portfolio' ) ) {

/**
 * Work Loop Module
 */
vc_map(
	array(
		'name' => esc_html__( 'Works', 'slikk' ),
		'description' => esc_html__( 'Display your works using the theme layouts', 'slikk' ),
		'base' => 'wvc_work_index',
		'category' => esc_html__( 'Content' , 'slikk' ),
		'icon' => 'fa fa-th',
		'weight' => 999,
		'params' =>
		//array_merge(
			array(

				array(
					'type' => 'wvc_textfield',
					'heading' => esc_html__( 'Index ID', 'slikk' ),
					'value' => 'index-' . rand( 0,99999 ),
					'param_name' => 'el_id',
					'description' => esc_html__( 'A unique identifier for the post module (required).', 'slikk' ),
				),

				array(
					'param_name' => 'work_display',
					'heading' => esc_html__( 'Work Display', 'slikk' ),
					'type' => 'dropdown',
					'value' => array_flip( apply_filters( 'slikk_work_display_options', array(
						'grid' => esc_html__( 'Grid', 'slikk' ),
					) ) ),
					'admin_label' => true,
				),

				array(
					'param_name' => 'work_module',
					'heading' => esc_html__( 'Module', 'slikk' ),
					'type' => 'dropdown',
					'value' => array(
						esc_html__( 'Grid', 'slikk' ) => 'grid',
						esc_html__( 'Carousel', 'slikk' ) => 'carousel',
					),
					'admin_label' => true,
					'dependency' => array(
						'element' => 'work_display',
						'value' => array( 'grid' )
					),
				),

				array(
					'param_name' => 'work_thumbnail_size',
					'heading' => esc_html__( 'Thumbnail Size', 'slikk' ),
					'type' => 'dropdown',
					'value' => array(
						esc_html__( 'Default Thumbnail', 'slikk' ) => 'standard',
						esc_html__( 'Landscape', 'slikk' ) => 'landscape',
						esc_html__( 'Square', 'slikk' ) => 'square',
						esc_html__( 'Portrait', 'slikk' ) => 'portrait',
					),
					'admin_label' => true,
					'dependency' => array(
						'element' => 'work_display',
						'value' => array( 'grid' ),
						// value_not_equal_to
					),
				),

				array(
					'param_name' => 'work_layout',
					'heading' => esc_html__( 'Layout', 'slikk' ),
					'type' => 'dropdown',
					'value' => array(
						esc_html__( 'Classic', 'slikk' ) => 'standard',
						esc_html__( 'Overlay', 'slikk' ) => 'overlay',
						//esc_html__( 'Flip Box', 'slikk' ) => 'flip-box',
					),
					'admin_label' => true,
					'dependency' => array(
						'element' => 'work_display',
						'value_not_equal_to' => array( 'list_minimal', 'text-background' )
					),
				),

				array(
					'param_name' => 'grid_padding',
					'heading' => esc_html__( 'Padding', 'slikk' ),
					'type' => 'dropdown',
					'value' => array(
						esc_html__( 'Yes', 'slikk' ) => 'yes',
						esc_html__( 'No', 'slikk' ) => 'no',
					),
					'admin_label' => true,
					'dependency' => array( 'element' => 'work_layout', 'value' => array( 'overlay', 'flip-box' ) ),
				),

				array(
					'heading' => esc_html__( 'Caption Text Alignement', 'slikk' ),
					'param_name' => 'caption_text_alignment',
					'type' => 'dropdown',
					'value' => array(
						esc_html__( 'Center', 'slikk' ) => 'center',
						esc_html__( 'Left', 'slikk' ) => 'left',
						esc_html__( 'Right', 'slikk' ) => 'right',
					),
					'dependency' => array(
						'element' => 'work_display',
						'value_not_equal_to' => array( 'list_minimal', 'text-background' )
					),
				),

				array(
					'heading' => esc_html__( 'Caption Vertical Alignement', 'slikk' ),
					'param_name' => 'caption_v_align',
					'type' => 'dropdown',
					'value' => array(
						esc_html__( 'Middle', 'slikk' ) => 'middle',
						esc_html__( 'Bottom', 'slikk' ) => 'bottom',
						esc_html__( 'Top', 'slikk' ) => 'top',
					),
					'dependency' => array(
						'element' => 'work_display',
						'value_not_equal_to' => array( 'list_minimal', 'text-background' )
					),
				),

				array(
					'type' => 'dropdown',
					'heading' => esc_html__( 'Overlay Color', 'slikk' ),
					'param_name' => 'overlay_color',
					'value' => array_merge(
							array( esc_html__( 'Auto', 'slikk' ) => 'auto', ),
							$shared_gradient_colors,
							$shared_colors,
							array( esc_html__( 'Custom color', 'slikk' ) => 'custom', )
					),
					'std' => apply_filters( 'wvc_default_item_overlay_color', 'black' ),
					'description' => esc_html__( 'Select an overlay color.', 'slikk' ),
					'param_holder_class' => 'wvc_colored-dropdown',
					'dependency' => array( 'element' => 'work_layout', 'value' => array( 'overlay', 'flip-box' ) ),
				),

				// Overlay color
				array(
					'type' => 'colorpicker',
					'heading' => esc_html__( 'Overlay Custom Color', 'slikk' ),
					'param_name' => 'overlay_custom_color',
					//'value' => '#000000',
					'dependency' => array( 'element' => 'overlay_color', 'value' => array( 'custom' ), ),
				),

				// Overlay opacity
				array(
					'type' => 'wvc_textfield',
					'heading' => esc_html__( 'Overlay Opacity in Percent', 'slikk' ),
					'param_name' => 'overlay_opacity',
					'description' => '',
					'value' => 40,
					'std' => apply_filters( 'wvc_default_item_overlay_opacity', 40 ),
					'dependency' => array( 'element' => 'work_layout', 'value' => array( 'overlay', 'flip-box' ), ),
				),

				array(
					'type' => 'dropdown',
					'heading' => esc_html__( 'Overlay Text Color', 'slikk' ),
					'param_name' => 'overlay_text_color',
					'value' => array_merge(
						$shared_colors,
						$shared_gradient_colors,
						array( esc_html__( 'Custom color', 'slikk' ) => 'custom', )
					),
					'std' => apply_filters( 'wvc_default_item_overlay_text_color', 'white' ),
					'description' => esc_html__( 'Select an overlay color.', 'slikk' ),
					'param_holder_class' => 'wvc_colored-dropdown',
					'dependency' => array( 'element' => 'work_layout', 'value' => array( 'overlay', 'flip-box' ) ),
				),

				// Overlay color
				array(
					'type' => 'colorpicker',
					'heading' => esc_html__( 'Overlay Custom Text Color', 'slikk' ),
					'param_name' => 'overlay_text_custom_color',
					//'value' => '#000000',
					'dependency' => array( 'element' => 'overlay_text_color', 'value' => array( 'custom' ), ),
				),

				array(
					'heading' => esc_html__( 'Category Filter', 'slikk' ),
					'param_name' => 'work_category_filter',
					'type' => 'checkbox',
					'description' => esc_html__( 'The pagination will be disabled.', 'slikk' ),
					'admin_label' => true,
					'dependency' => array(
						'element' => 'work_display',
						'value_not_equal_to' => array( 'list_minimal', 'text-background' )
					),
				),

				array(
					'heading' => esc_html__( 'Filter Text Alignement', 'slikk' ),
					'param_name' => 'work_category_filter_text_alignment',
					'type' => 'dropdown',
					'value' => array(
						esc_html__( 'Center', 'slikk' ) => 'center',
						esc_html__( 'Left', 'slikk' ) => 'left',
						esc_html__( 'Right', 'slikk' ) => 'right',
					),
					'dependency' => array(
						'element' => 'work_category_filter',
						'value' => array( 'true' ),
					),
				),

				array(
					'heading' => esc_html__( 'Animation', 'slikk' ),
					'param_name' => 'item_animation',
					'type' => 'dropdown',
					'value' => array_flip( slikk_get_animations() ),
					'admin_label' => true,
				),

				array(
					'heading' => esc_html__( 'Number of Posts', 'slikk' ),
					'param_name' => 'posts_per_page',
					'type' => 'wvc_textfield',
					//'placeholder' => get_option( 'posts_per_page' ),
					'description' => esc_html__( 'Leave empty to display all post at once.', 'slikk' ),
					//'std' => '-1',
					'admin_label' => true,
				),

				array(
					'param_name' => 'pagination',
					'heading' => esc_html__( 'Pagination', 'slikk' ),
					'type' => 'dropdown',
					'value' => array(
						esc_html__( 'None', 'slikk' ) => 'none',
						esc_html__( 'Load More', 'slikk' ) => 'load_more',
						esc_html__( 'Link to Portfolio', 'slikk' ) => 'link_to_portfolio',
					),
					'admin_label' => true,
					'dependency' => array( 'element' => 'work_module', 'value' => array( 'grid' ) ),
				),

				array(
					'heading' => esc_html__( 'Additional CSS inline style', 'slikk' ),
					'param_name' => 'inline_style',
					'type' => 'wvc_textfield',
					//'admin_label' => true,
				),

				array(
					'type' => 'wvc_textfield',
					'heading' => esc_html__( 'Include Category', 'slikk' ),
					'param_name' => 'work_type_include',
					'description' => esc_html__( 'Enter one or several categories. Paste category slug(s) separated by a comma', 'slikk' ),
					'placeholder' => esc_html__( 'my-category, other-category', 'slikk' ),
					'group' => esc_html__( 'Query', 'slikk' ),
				),

				array(
					'type' => 'wvc_textfield',
					'heading' => esc_html__( 'Exclude Category', 'slikk' ),
					'param_name' => 'work_type_exclude',
					'description' => esc_html__( 'Enter one or several categories. Paste category slug(s) separated by a comma', 'slikk' ),
					'placeholder' => esc_html__( 'my-category, other-category', 'slikk' ),
					'group' => esc_html__( 'Query', 'slikk' ),
				),

				array(
					'type' => 'wvc_textfield',
					'heading' => esc_html__( 'Offset', 'slikk' ),
					'description' => esc_html__( '.', 'slikk' ),
					'param_name' => 'offset',
					'description' => esc_html__( 'The amount of posts that should be skipped in the beginning of the query.', 'slikk' ),
					'group' => esc_html__( 'Query', 'slikk' ),
				),

				array(
					'type' => 'dropdown',
					'heading' => esc_html__( 'Order by', 'slikk' ),
					'param_name' => 'orderby',
					'value' => $order_by_values,
					'save_always' => true,
					'description' => sprintf( wp_kses_post( __( 'Select how to sort retrieved posts. More at %s.', 'slikk' ) ), '<a href="http://codex.wordpress.org/Class_Reference/WP_Query#Order_.26_Orderby_Parameters" target="_blank">WordPress codex page</a>' ),
					'group' => esc_html__( 'Query', 'slikk' ),
				),

				array(
					'type' => 'dropdown',
					'heading' => esc_html__( 'Sort order', 'slikk' ),
					'param_name' => 'order',
					'value' => $order_way_values,
					'save_always' => true,
					'description' => sprintf( wp_kses_post( __( 'Designates the ascending or descending order. More at %s.', 'slikk' ) ), '<a href="http://codex.wordpress.org/Class_Reference/WP_Query#Order_.26_Orderby_Parameters" target="_blank">WordPress codex page</a>' ),
					'group' => esc_html__( 'Query', 'slikk' ),
				),

				array(
					'type' => 'wvc_textfield',
					'heading' => esc_html__( 'Post IDs', 'slikk' ),
					'description' => esc_html__( 'By default, your last posts will be displayed. You can choose the posts you want to display by entering a list of IDs separated by a comma.', 'slikk' ),
					'param_name' => 'include_ids',
					'group' => esc_html__( 'Query', 'slikk' ),
				),

				array(
					'type' => 'wvc_textfield',
					'heading' => esc_html__( 'Exclude Post IDs', 'slikk' ),
					'description' => esc_html__( 'You can choose the posts you don\'t want to display by entering a list of IDs separated by a comma.', 'slikk' ),
					'param_name' => 'exclude_ids',
					'group' => esc_html__( 'Query', 'slikk' ),
				),

				array(
					'param_name' => 'columns',
					'heading' => esc_html__( 'Columns', 'slikk' ),
					'type' => 'dropdown',
					'value' => array(
						esc_html__( 'Auto', 'slikk' ) => 'default',
						esc_html__( 'Two', 'slikk' ) => 2,
						esc_html__( 'Three', 'slikk' ) => 3,
						esc_html__( 'Four', 'slikk' ) => 4,
						esc_html__( 'Six', 'slikk' ) => 6,
						esc_html__( 'One', 'slikk' ) => 1,
					),
					'std' => 'default',
					'admin_label' => true,
					'description' => esc_html__( 'By default, columns are set automatically depending on the container\'s width. Set a column count here to overwrite the default behavior.', 'slikk' ),
					'dependency' => array(
						'element' => 'post_display',
						'value_not_equal_to' => array( 'standard', 'standard_modern' ),
					),
					'group' => esc_html__( 'Extra', 'slikk' ),
				),

				array(
					'type' => 'wvc_textfield',
					'heading' => esc_html__( 'Extra class name', 'slikk' ),
					'param_name' => 'el_class',
					'description' => esc_html__( 'Style particular content element differently - add a class name and refer to it in custom CSS.', 'slikk' ),
					'group' => esc_html__( 'Extra', 'slikk' ),
				),
			),
			//),

			// 	array(
			// 		'heading' => esc_html__( 'Additional CSS inline style', 'slikk' ),
			// 		'param_name' => 'inline_style',
			// 		'type' => 'wvc_textfield',
			// 		//'admin_label' => true,
			// 	),
			// ),
		//)
	)
);

class WPBakeryShortCode_Wvc_Work_Index extends WPBakeryShortCode {}
} // end Portfolio plugin check

if ( class_exists( 'WooCommerce' ) ) {

/**
 * Product Loop Module
 */
vc_map(
	array(
		'name' => esc_html__( 'Products', 'slikk' ),
		'description' => esc_html__( 'Display your pages using the theme layouts', 'slikk' ),
		'base' => 'wvc_product_index',
		'category' => esc_html__( 'Content' , 'slikk' ),
		'icon' => 'fa fa-th',
		'weight' => 999,
		'params' =>
		//array_merge(
			array(

				array(
					'type' => 'hidden',
					'heading' => esc_html__( 'ID', 'slikk' ),
					'value' => 'items-' . rand( 0,99999 ),
					'param_name' => 'el_id',
				),

				array(
					'param_name' => 'product_display',
					'heading' => esc_html__( 'Product Display', 'slikk' ),
					'type' => 'dropdown',
					'value' => array_flip( apply_filters( 'slikk_product_display_options', array(
						'grid_classic' => esc_html__( 'Classic', 'slikk' ),
					) ) ),
					'std' => 'grid_classic',
					'admin_label' => true,
				),

				array(
					'param_name' => 'product_metro_pattern',
					'heading' => esc_html__( 'Metro Pattern', 'slikk' ),
					'type' => 'dropdown',
					'value' => slikk_get_metro_patterns(),
					'std' => 'pattern-1',
					'dependency' => array( 'element' => 'product_display', 'value' => array( 'metro_overlay_quickview' ) ),
					'admin_label' => true,
				),

				array(
					'param_name' => 'product_text_align',
					'heading' => esc_html__( 'Product Text Alignement', 'slikk' ),
					'type' => 'dropdown',
					'value' => array(
						'' => '',
						esc_html__( 'Center', 'slikk' ) => 'center',
						esc_html__( 'Left', 'slikk' ) => 'left',
						esc_html__( 'Right', 'slikk' ) => 'right',
					),
					//'std' => '',
					'admin_label' => true,
					'dependency' => array( 'element' => 'product_display', 'value' => array( 'grid_classic' ) ),
				),

				array(
					'param_name' => 'product_meta',
					'heading' => esc_html__( 'Type', 'slikk' ),
					'type' => 'dropdown',
					'value' => array(
						esc_html__( 'All', 'slikk' ) => 'all',
						esc_html__( 'Featured', 'slikk' ) => 'featured',
						esc_html__( 'On Sale', 'slikk' ) => 'onsale',
						esc_html__( 'Best Selling', 'slikk' ) => 'best_selling',
						esc_html__( 'Top Rated', 'slikk' ) => 'top_rated',
					),
					'admin_label' => true,
				),

				array(
					'type' => 'wvc_textfield',
					'heading' => esc_html__( 'Category', 'slikk' ),
					'param_name' => 'product_cat',
					'description' => esc_html__( 'Include only one or several categories. Paste category slug(s) separated by a comma', 'slikk' ),
					'placeholder' => esc_html__( 'my-category, other-category', 'slikk' ),
					'admin_label' => true,
				),

				array(
					'param_name' => 'product_module',
					'heading' => esc_html__( 'Module', 'slikk' ),
					'type' => 'dropdown',
					'value' => array(
						esc_html__( 'Grid', 'slikk' ) => 'grid',
						esc_html__( 'Carousel', 'slikk' ) => 'carousel',
					),
					'admin_label' => true,
					//'dependency' => array( 'element' => 'work_layout', 'value' => array( 'overlay', 'flip-box' ) ),
				),

				array(
					'param_name' => 'grid_padding',
					'heading' => esc_html__( 'Padding', 'slikk' ),
					'type' => 'dropdown',
					'value' => array(
						esc_html__( 'Yes', 'slikk' ) => 'yes',
						esc_html__( 'No', 'slikk' ) => 'no',
					),
					'admin_label' => true,
				),

				array(
					'heading' => esc_html__( 'Animation', 'slikk' ),
					'param_name' => 'item_animation',
					'type' => 'dropdown',
					'value' => array_flip( slikk_get_animations() ),
					'admin_label' => true,
				),

				array(
					'heading' => esc_html__( 'Posts Per Page', 'slikk' ),
					'param_name' => 'posts_per_page',
					'type' => 'wvc_textfield',
					'placeholder' => get_option( 'posts_per_page' ),
					'description' => esc_html__( 'Leave empty to display all post at once.', 'slikk' ),
					'std' => get_option( 'posts_per_page' ),
					'admin_label' => true,
				),

				array(
					'param_name' => 'pagination',
					'heading' => esc_html__( 'Pagination', 'slikk' ),
					'type' => 'dropdown',
					'value' => array(
						esc_html__( 'None', 'slikk' ) => 'none',
						esc_html__( 'Load More', 'slikk' ) => 'load_more',
						esc_html__( 'Numeric Pagination', 'slikk' ) => 'standard_pagination',
						esc_html__( 'Link to Category', 'slikk' ) => 'link_to_shop_category',
						esc_html__( 'Link to Shop Archive', 'slikk' ) => 'link_to_shop',
					),
					'admin_label' => true,
					'dependency' => array( 'element' => 'product_module', 'value' => array( 'grid' ) ),
				),

				array(
					'param_name' => 'product_category_link_id',
					'heading' => esc_html__( 'Category', 'slikk' ),
					'type' => 'dropdown',
					'value' => slikk_get_product_cat_dropdown_options(),
					'dependency' => array( 'element' => 'pagination', 'value' => array( 'link_to_shop_category' ) ),
					'admin_label' => true,
				),

				array(
					'heading' => esc_html__( 'Additional CSS inline style', 'slikk' ),
					'param_name' => 'inline_style',
					'type' => 'wvc_textfield',
					//'admin_label' => true,
				),

				array(
					'type' => 'wvc_textfield',
					'heading' => esc_html__( 'Offset', 'slikk' ),
					'param_name' => 'offset',
					'description' => esc_html__( 'The amount of posts that should be skipped in the beginning of the query. If an offset is set, sticky posts will be ignored.', 'slikk' ),
					'group' => esc_html__( 'Query', 'slikk' ),
					'admin_label' => true,
				),

				array(
					'type' => 'dropdown',
					'heading' => esc_html__( 'Order by', 'slikk' ),
					'param_name' => 'orderby',
					'value' => $order_by_values,
					'save_always' => true,
					'description' => sprintf( wp_kses_post( __( 'Select how to sort retrieved products. More at %s.', 'slikk' ) ), '<a href="http://codex.wordpress.org/Class_Reference/WP_Query#Order_.26_Orderby_Parameters" target="_blank">WordPress codex page</a>' ),
					'group' => esc_html__( 'Query', 'slikk' ),
				),

				array(
					'type' => 'dropdown',
					'heading' => esc_html__( 'Sort order', 'slikk' ),
					'param_name' => 'order',
					'value' => $order_way_values,
					'save_always' => true,
					'description' => sprintf( wp_kses_post( __( 'Designates the ascending or descending order. More at %s.', 'slikk' ) ), '<a href="http://codex.wordpress.org/Class_Reference/WP_Query#Order_.26_Orderby_Parameters" target="_blank">WordPress codex page</a>' ),
					'group' => esc_html__( 'Query', 'slikk' ),
				),

				array(
					'type' => 'wvc_textfield',
					'heading' => esc_html__( 'Post IDs', 'slikk' ),
					'description' => esc_html__( 'By default, your last posts will be displayed. You can choose the posts you want to display by entering a list of IDs separated by a comma.', 'slikk' ),
					'param_name' => 'include_ids',
					'group' => esc_html__( 'Query', 'slikk' ),
				),

				array(
					'type' => 'wvc_textfield',
					'heading' => esc_html__( 'Exclude Post IDs', 'slikk' ),
					'description' => esc_html__( 'You can choose the posts you don\'t want to display by entering a list of IDs separated by a comma.', 'slikk' ),
					'param_name' => 'exclude_ids',
					'group' => esc_html__( 'Query', 'slikk' ),
				),

				array(
					'param_name' => 'columns',
					'heading' => esc_html__( 'Columns', 'slikk' ),
					'type' => 'dropdown',
					'value' => array(
						esc_html__( 'Auto', 'slikk' ) => 'default',
						esc_html__( 'Two', 'slikk' ) => 2,
						esc_html__( 'Three', 'slikk' ) => 3,
						esc_html__( 'Four', 'slikk' ) => 4,
						esc_html__( 'Six', 'slikk' ) => 6,
						esc_html__( 'One', 'slikk' ) => 1,
					),
					'std' => 'default',
					'admin_label' => true,
					'description' => esc_html__( 'By default, columns are set automatically depending on the container\'s width. Set a column count here to overwrite the default behavior.', 'slikk' ),
					'dependency' => array(
						'element' => 'product_display',
						'value_not_equal_to' => array( 'metro_overlay_quickview' ),
					),
					'group' => esc_html__( 'Extra', 'slikk' ),
				),

				array(
					'type' => 'wvc_textfield',
					'heading' => esc_html__( 'Extra class name', 'slikk' ),
					'param_name' => 'el_class',
					'description' => esc_html__( 'Style particular content element differently - add a class name and refer to it in custom CSS.', 'slikk' ),
					'group' => esc_html__( 'Extra', 'slikk' ),
				),
			),
			//),

			// 	array(
			// 		'heading' => esc_html__( 'Additional CSS inline style', 'slikk' ),
			// 		'param_name' => 'inline_style',
			// 		'type' => 'wvc_textfield',
			// 		//'admin_label' => true,
			// 	),
			// ),
		//)
	)
);

class WPBakeryShortCode_Wvc_Product_Index extends WPBakeryShortCode {}

} // end WC check


// $parent_pages = array( esc_html__( 'No', 'slikk' ) => '' );
// $all_pages = get_pages();

// foreach ( $all_pages as $page ) {

// 	if ( 0 < count( get_posts( array( 'post_parent' => $page->ID, 'post_type' => 'page' ) ) ) ) {
// 		$parent_pages[ $page->post_title ] = $page->ID;
// 	}
// }

// /**
//  * Page Loop Module
//  */
// vc_map(
// 	array(
// 		'name' => esc_html__( 'Pages', 'slikk' ),
// 		'description' => esc_html__( 'Display your pages using the theme layouts', 'slikk' ),
// 		'base' => 'wvc_page_index',
// 		'category' => esc_html__( 'Content' , 'slikk' ),
// 		'icon' => 'fa fa-th',
// 		'weight' => 0,
// 		'params' =>
// 			array(

// 				array(
// 					'type' => 'hidden',
// 					'heading' => esc_html__( 'ID', 'slikk' ),
// 					'value' => 'items-' . rand( 0,99999 ),
// 					'param_name' => 'el_id',
// 				),

// 				array(
// 					'param_name' => 'page_display',
// 					'heading' => esc_html__( 'Page Display', 'slikk' ),
// 					'type' => 'dropdown',
// 					'value' => array_flip( apply_filters( 'slikk_page_display_options', array(
// 						'grid' => esc_html__( 'Image Grid', 'slikk' ),
// 					) ) ),
// 					'admin_label' => true,
// 				),

// 				// array(
// 				// 	'param_name' => 'grid_padding',
// 				// 	'heading' => esc_html__( 'Padding', 'slikk' ),
// 				// 	'type' => 'dropdown',
// 				// 	'value' => array(
// 				// 		esc_html__( 'Yes', 'slikk' ) => 'yes',
// 				// 		esc_html__( 'No', 'slikk' ) => 'no',
// 				// 	),
// 				// 	'admin_label' => true,
// 				// ),

// 				array(
// 					'heading' => esc_html__( 'Animation', 'slikk' ),
// 					'param_name' => 'item_animation',
// 					'type' => 'dropdown',
// 					'value' => array_flip( slikk_get_animations() ),
// 					'admin_label' => true,
// 				),

// 				array(
// 					'heading' => esc_html__( 'Number of Page to display', 'slikk' ),
// 					'param_name' => 'posts_per_page',
// 					'type' => 'wvc_textfield',
// 					'placeholder' => get_option( 'posts_per_page' ),
// 					'description' => esc_html__( 'Leave empty to display all post at once.', 'slikk' ),
// 					'std' => get_option( 'posts_per_page' ),
// 					'admin_label' => true,
// 				),

// 				array(
// 					'heading' => esc_html__( 'Additional CSS inline style', 'slikk' ),
// 					'param_name' => 'inline_style',
// 					'type' => 'wvc_textfield',
// 					//'admin_label' => true,
// 				),

// 				array(
// 					'param_name' => 'page_by_parent',
// 					'heading' => esc_html__( 'Pages By Parent', 'slikk' ),
// 					'type' => 'dropdown',
// 					'value' => $parent_pages,
// 					'group' => esc_html__( 'Query', 'slikk' ),
// 				),

// 				array(
// 					'type' => 'wvc_textfield',
// 					'heading' => esc_html__( 'Post IDs', 'slikk' ),
// 					'description' => esc_html__( 'By default, your last posts will be displayed. You can choose the posts you want to display by entering a list of IDs separated by a comma.', 'slikk' ),
// 					'param_name' => 'include_ids',
// 					'group' => esc_html__( 'Query', 'slikk' ),
// 				),

// 				array(
// 					'type' => 'wvc_textfield',
// 					'heading' => esc_html__( 'Exclude Post IDs', 'slikk' ),
// 					'description' => esc_html__( 'You can choose the posts you don\'t want to display by entering a list of IDs separated by a comma.', 'slikk' ),
// 					'param_name' => 'exclude_ids',
// 					'group' => esc_html__( 'Query', 'slikk' ),
// 				),

// 				array(
// 					'type' => 'dropdown',
// 					'heading' => esc_html__( 'Order by', 'slikk' ),
// 					'param_name' => 'orderby',
// 					'value' => $order_by_values,
// 					'save_always' => true,
// 					'description' => sprintf( wp_kses_post( __( 'Select how to sort retrieved pages. More at %s.', 'slikk' ) ), '<a href="http://codex.wordpress.org/Class_Reference/WP_Query#Order_.26_Orderby_Parameters" target="_blank">WordPress codex page</a>' ),
// 					'group' => esc_html__( 'Query', 'slikk' ),
// 				),

// 				array(
// 					'type' => 'dropdown',
// 					'heading' => esc_html__( 'Sort order', 'slikk' ),
// 					'param_name' => 'order',
// 					'value' => $order_way_values,
// 					'save_always' => true,
// 					'description' => sprintf( wp_kses_post( __( 'Designates the ascending or descending order. More at %s.', 'slikk' ) ), '<a href="http://codex.wordpress.org/Class_Reference/WP_Query#Order_.26_Orderby_Parameters" target="_blank">WordPress codex page</a>' ),
// 					'group' => esc_html__( 'Query', 'slikk' ),
// 				),

// 				array(
// 					'param_name' => 'columns',
// 					'heading' => esc_html__( 'Columns', 'slikk' ),
// 					'type' => 'dropdown',
// 					'value' => array(
// 						esc_html__( 'Auto', 'slikk' ) => 'default',
// 						esc_html__( 'Two', 'slikk' ) => 2,
// 						esc_html__( 'Three', 'slikk' ) => 3,
// 						esc_html__( 'Four', 'slikk' ) => 4,
// 						esc_html__( 'Six', 'slikk' ) => 6,
// 						esc_html__( 'One', 'slikk' ) => 1,
// 					),
// 					'std' => 'default',
// 					'admin_label' => true,
// 					'description' => esc_html__( 'By default, columns are set automatically depending on the container\'s width. Set a column count here to overwrite the default behavior.', 'slikk' ),
// 					'dependency' => array(
// 						'element' => 'post_display',
// 						'value_not_equal_to' => array( 'standard', 'standard_modern' ),
// 					),
// 					'group' => esc_html__( 'Extra', 'slikk' ),
// 				),
// 			),
// 	)
// );

// class WPBakeryShortCode_Wvc_Page_Index extends WPBakeryShortCode {}