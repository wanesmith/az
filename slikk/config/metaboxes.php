<?php
/**
 * Slikk metaboxes
 *
 * @package WordPress
 * @subpackage Slikk
 * @version 1.4.2
 */

defined( 'ABSPATH' ) || exit;

/**
 * Register metaboxes
 *
 * Pass a metabox array to generate metabox with the  Wolf Metaboxes plugin
 */
function slikk_register_metabox() {

	$body_metaboxes = array(
		'site_settings' => array(
			'title' => esc_html__( 'General', 'slikk' ),
			'page' => apply_filters( 'slikk_site_settings_post_types', array( 'post', 'page', 'plugin', 'video', 'product', 'gallery', 'theme', 'work', 'show', 'release', 'wpm_playlist', 'event', 'artist' ) ),

			'metafields' => array(

				array(
					'label'	=> '',
					'id'	=> '_post_subheading',
					'type'	=> 'text',
				),

				array(
					'label'	=> esc_html__( 'Accent Color', 'slikk' ),
					'id'	=> '_post_accent_color',
					'type'	=> 'colorpicker',
				),

				array(
					'label'	=> esc_html__( 'Content Background Color', 'slikk' ),
					'id'	=> '_post_content_inner_bg_color',
					'type'	=> 'colorpicker',
					'desc' => esc_html__( 'If you use the page builder and set your row background setting to "no background", you may want to change the overall content background color.', 'slikk' ),
				),

				array(
					'label' => esc_html__( 'Loading Animation Type', 'slikk' ),
					'id' => '_post_loading_animation_type',
					'type' => 'select',
					'choices' => array(
						'' => '&mdash; ' . esc_html__( 'Default', 'slikk' ) . ' &mdash;',
						 'none' => esc_html__( 'None', 'slikk' ),
						'overlay'          => esc_html__( 'Simple Overlay', 'slikk' ),
						'logo'             => esc_html__( 'Overlay with Logo', 'slikk' ),
						'spinner-loader1'  => esc_html__( 'Rotating plane', 'slikk' ),
						'spinner-loader2'  => esc_html__( 'Double Pulse', 'slikk' ),
						'spinner-loader3'  => esc_html__( 'Wave', 'slikk' ),
						'spinner-loader4'  => esc_html__( 'Wandering cubes', 'slikk' ),
						'spinner-loader5'  => esc_html__( 'Pulse', 'slikk' ),
						'spinner-loader6'  => esc_html__( 'Chasing dots', 'slikk' ),
						'spinner-loader7'  => esc_html__( 'Three bounce', 'slikk' ),
						'spinner-loader8'  => esc_html__( 'Circle', 'slikk' ),
						'spinner-loader9'  => esc_html__( 'Cube grid', 'slikk' ),
						'spinner-loader10' => esc_html__( 'Classic Loader', 'slikk' ),
						'spinner-loader11' => esc_html__( 'Folding cube', 'slikk' ),
						'spinner-loader12' => esc_html__( 'Ball Pulse', 'slikk' ),
						'spinner-loader13' => esc_html__( 'Ball Grid Pulse', 'slikk' ),
						'spinner-loader15' => esc_html__( 'Ball Clip Rotate Pulse', 'slikk' ),
						'spinner-loader16' => esc_html__( 'Ball Clip Rotate Pulse Multiple', 'slikk' ),
						'spinner-loader17' => esc_html__( 'Ball Pulse Rise', 'slikk' ),
						'spinner-loader19' => esc_html__( 'Ball Zigzag', 'slikk' ),
						'spinner-loader20' => esc_html__( 'Ball Zigzag Deflect', 'slikk' ),
						'spinner-loader21' => esc_html__( 'Ball Triangle Path', 'slikk' ),
						'spinner-loader22' => esc_html__( 'Ball Scale', 'slikk' ),
						'spinner-loader23' => esc_html__( 'Ball Line Scale', 'slikk' ),
						'spinner-loader24' => esc_html__( 'Ball Line Scale Party', 'slikk' ),
						'spinner-loader25' => esc_html__( 'Ball Scale Multiple', 'slikk' ),
						'spinner-loader26' => esc_html__( 'Ball Pulse Sync', 'slikk' ),
						'spinner-loader27' => esc_html__( 'Ball Beat', 'slikk' ),
						'spinner-loader28' => esc_html__( 'Ball Scale Ripple Multiple', 'slikk' ),
						'spinner-loader29' => esc_html__( 'Ball Spin Fade Loader', 'slikk' ),
						'spinner-loader30' => esc_html__( 'Line Spin Fade Loader', 'slikk' ),
						'spinner-loader31' => esc_html__( 'Pacman', 'slikk' ),
						'spinner-loader32' => esc_html__( 'Ball Grid Beat ', 'slikk' ),
					),
				),
			),
		),
	);

	$content_blocks = array(
			'' => '&mdash; ' . esc_html__( 'None', 'slikk' ) . ' &mdash;',
	);

	if ( class_exists( 'Wolf_Visual_Composer' ) && class_exists( 'Wolf_Vc_Content_Block' ) && defined( 'WPB_VC_VERSION' ) ) {
		// Content block option
		$content_block_posts = get_posts( 'post_type="wvc_content_block"&numberposts=-1' );

		$content_blocks = array(
			'' => '&mdash; ' . esc_html__( 'Default', 'slikk' ) . ' &mdash;',
			'none' => esc_html__( 'None', 'slikk' ),
		);
		if ( $content_block_posts ) {
			foreach ( $content_block_posts as $content_block_options ) {
				$content_blocks[ $content_block_options->ID ] = $content_block_options->post_title;
			}
		} else {
			$content_blocks[0] = esc_html__( 'No Content Block Yet', 'slikk' );
		}

		$body_metaboxes['site_settings']['metafields'][] = array(
			'label'	=> esc_html__( 'Post-header Block', 'slikk' ),
			'id'	=> '_post_after_header_block',
			'type'	=> 'select',
			'choices' => $content_blocks,
		);

		$body_metaboxes['site_settings']['metafields'][] = array(
			'label'	=> esc_html__( 'Pre-footer Block', 'slikk' ),
			'id'	=> '_post_before_footer_block',
			'type'	=> 'select',
			'choices' => $content_blocks,
		);

	}

	$header_metaboxes = array(
		'header_settings' => array(
			'title' => esc_html__( 'Header', 'slikk' ),
			'page' => apply_filters( 'slikk_header_settings_post_types', array( 'post', 'page', 'plugin', 'video', 'gallery', 'theme', 'work', 'show', 'release', 'wpm_playlist', 'event', 'artist' ) ),

			'metafields' => array(

				array(
					'label'	=> esc_html__( 'Header Layout', 'slikk' ),
					'id'	=> '_post_hero_layout',
					'type'	=> 'select',
					'choices' => array(
						'' => '&mdash; ' . esc_html__( 'Default', 'slikk' ) . ' &mdash;',
						'standard' => esc_html__( 'Standard', 'slikk' ),
						'big' => esc_html__( 'Big', 'slikk' ),
						'small' => esc_html__( 'Small', 'slikk' ),
						'fullheight' => esc_html__( 'Full Height', 'slikk' ),
						'none' => esc_html__( 'No Header', 'slikk' ),
					),
				),

				array(
					'label'	=> esc_html__( 'Title Font Family', 'slikk' ),
					'id'	=> '_post_hero_title_font_family',
					'type'	=> 'font_family',
				),

				array(
					'label'	=> esc_html__( 'Font Transform', 'slikk' ),
					'id'	=> '_post_hero_title_font_transform',
					'type'	=> 'select',
					'choices' => array(
						'' => '&mdash; ' . esc_html__( 'Default', 'slikk' ) . ' &mdash;',
						'uppercase' => esc_html__( 'Uppercase', 'slikk' ),
						'none' => esc_html__( 'None', 'slikk' ),
					),
				),

				array(
					'label'	=> esc_html__( 'Big Text', 'slikk' ),
					'id'	=> '_post_hero_title_bigtext',
					'type'	=> 'checkbox',
					'desc' => esc_html__( 'Enable "Big Text" for the title?', 'slikk' ),
				),

				array(
					'label'	=> esc_html__( 'Font Tone', 'slikk' ),
					'id'	=> '_post_hero_font_tone',
					'type'	=> 'select',
					'choices' => array(
						'' => '&mdash; ' . esc_html__( 'Default', 'slikk' ) . ' &mdash;',
						'light' => esc_html__( 'Light', 'slikk' ),
						'dark' => esc_html__( 'Dark', 'slikk' ),
					),
				),

				array(
					'label'	=> esc_html__( 'Background Type', 'slikk' ),
					'id'	=> '_post_hero_background_type',
					'type'	=> 'select',
					'choices' => array(
						'featured-image' => esc_html__( 'Featured Image', 'slikk' ),
						'image' => esc_html__( 'Image', 'slikk' ),
						'video' => esc_html__( 'Video', 'slikk' ),
						'slideshow' => esc_html__( 'Slideshow', 'slikk' ),
					),
				),

				array(
					'label'	=> esc_html__( 'Slideshow Images', 'slikk' ),
					'id'	=> '_post_hero_slideshow_ids',
					'type'	=> 'multiple_images',
					'dependency' => array( 'element' => '_post_hero_background_type', 'value' => array( 'slideshow' ) ),
				),

				array(
					'label'	=> esc_html__( 'Background', 'slikk' ),
					'id'	=> '_post_hero_background',
					'type'	=> 'background',
					'dependency' => array( 'element' => '_post_hero_background_type', 'value' => array( 'image' ) ),
				),

				array(
					'label'	=> esc_html__( 'Background Effect', 'slikk' ),
					'id'	=> '_post_hero_background_effect',
					'type'	=> 'select',
					'choices' => array(
						'' => '&mdash; ' . esc_html__( 'Default', 'slikk' ) . ' &mdash;',
						'zoomin' => esc_html__( 'Zoom', 'slikk' ),
						'parallax' => esc_html__( 'Parallax', 'slikk' ),
						'none' => esc_html__( 'None', 'slikk' ),
					),
					'dependency' => array( 'element' => '_post_hero_background_type', 'value' => array( 'image' ) ),
				),

				array(
					'label'	=> esc_html__( 'Video URL', 'slikk' ),
					'id'	=> '_post_hero_background_video_url',
					'type'	=> 'video',
					'dependency' => array( 'element' => '_post_hero_background_type', 'value' => array( 'video' ) ),
					'desc' => esc_html__( 'A mp4 or YouTube URL. The featured image will be used as image fallback when the video cannot be displayed.', 'slikk' ),
				),

				array(
					'label'	=> esc_html__( 'Overlay', 'slikk' ),
					'id'	=> '_post_hero_overlay',
					'type'	=> 'select',
					'choices' => array(
						'' => '&mdash; ' . esc_html__( 'Default', 'slikk' ) . ' &mdash;',
						'custom' => esc_html__( 'Custom', 'slikk' ),
						'none' => esc_html__( 'None', 'slikk' ),
					),
				),

				array(
					'label'	=> esc_html__( 'Overlay Color', 'slikk' ),
					'id'	=> '_post_hero_overlay_color',
					'type'	=> 'colorpicker',
					//'value' 	=> '#000000',
					'dependency' => array( 'element' => '_post_hero_overlay', 'value' => array( 'custom' ) ),
				),

				array(
					'label'	=> esc_html__( 'Overlay Opacity (in percent)', 'slikk' ),
					'id'	=> '_post_hero_overlay_opacity',
					'desc'	=> esc_html__( 'Adapt the header overlay opacity if needed', 'slikk' ),
					'type'	=> 'int',
					'placeholder'	=> 40,
					'dependency' => array( 'element' => '_post_hero_overlay', 'value' => array( 'custom' ) ),
				),

			),
		),
	);

	$menu_metaboxes = array(
			'menu_settings' => array(
				'title' => esc_html__( 'Menu', 'slikk' ),
				'page' => apply_filters( 'slikk_menu_settings_post_types', array( 'post', 'page', 'plugin', 'video', 'product', 'gallery', 'theme', 'work', 'show', 'release', 'wpm_playlist', 'event', 'artist' ) ),

			'metafields' => array(
				array(
					'label'	=> esc_html__( 'Menu Layout', 'slikk' ),
					'id'	=> '_post_menu_layout',
					'type'	=> 'select',
					'choices' => array(
						'' => '&mdash; ' . esc_html__( 'Default', 'slikk' ) . ' &mdash;',
						'top-right' => esc_html__( 'Top Right', 'slikk' ),
						'top-justify' => esc_html__( 'Top Justify', 'slikk' ),
						'top-justify-left' => esc_html__( 'Top Justify Left', 'slikk' ),
						'centered-logo' => esc_html__( 'Centered', 'slikk' ),
						'top-left' => esc_html__( 'Top Left', 'slikk' ),
						'offcanvas' => esc_html__( 'Off Canvas', 'slikk' ),
						'overlay' => esc_html__( 'Overlay', 'slikk' ),
						'lateral' => esc_html__( 'Lateral', 'slikk' ),
						'none' => esc_html__( 'No Menu', 'slikk' ),
					),
				),

				array(
					'label'	=> esc_html__( 'Menu Width', 'slikk' ),
					'id'	=> '_post_menu_width',
					'type'	=> 'select',
					'choices' => array(
						'' => '&mdash; ' . esc_html__( 'Default', 'slikk' ) . ' &mdash;',
						'wide' => esc_html__( 'Wide', 'slikk' ),
						'boxed' => esc_html__( 'Boxed', 'slikk' ),
					),
				),

				array(
					'label'	=> esc_html__( 'Menu Style', 'slikk' ),
					'id'	=> '_post_menu_style',
					'type'	=> 'select',
					'choices' => array(
						'' => '&mdash; ' . esc_html__( 'Default', 'slikk' ) . ' &mdash;',
						'solid' => esc_html__( 'Solid', 'slikk' ),
						'semi-transparent-white' => esc_html__( 'Semi-transparent White', 'slikk' ),
						'semi-transparent-black' => esc_html__( 'Semi-transparent Black', 'slikk' ),
						'transparent' => esc_html__( 'Transparent', 'slikk' ),
						//'none' => esc_html__( 'No Menu', 'slikk' ),
					),
				),

				/*array(
					'label'	=> esc_html__( 'Menu Skin', 'slikk' ),
					'id'	=> '_post_menu_skin',
					'type'	=> 'select',
					'choices' => array(
						'' => '&mdash; ' . esc_html__( 'Default', 'slikk' ) . ' &mdash;',
						'light' => esc_html__( 'Light', 'slikk' ),
						'dark' => esc_html__( 'Dark', 'slikk' ),
						//'none' => esc_html__( 'No Menu', 'slikk' ),
					),
				),*/

				'menu_sticky_type' => array(
					'id' =>'_post_menu_sticky_type',
					'label' => esc_html__( 'Sticky Menu', 'slikk' ),
					'type' => 'select',
					'choices' => array(
						'' => '&mdash; ' . esc_html__( 'Default', 'slikk' ) . ' &mdash;',
						'none' => esc_html__( 'Disabled', 'slikk' ),
						'soft' => esc_html__( 'Sticky on scroll up', 'slikk' ),
						'hard' => esc_html__( 'Always sticky', 'slikk' ),
					),
				),

				array(
					'label'	=> esc_html__( 'Sticky Menu Skin', 'slikk' ),
					'id'	=> '_post_menu_skin',
					'type'	=> 'select',
					'choices' => array(
						'' => '&mdash; ' . esc_html__( 'Default', 'slikk' ) . ' &mdash;',
						'light' => esc_html__( 'Light', 'slikk' ),
						'dark' => esc_html__( 'Dark', 'slikk' ),
						//'none' => esc_html__( 'No Menu', 'slikk' ),
					),
				),

				array(
					'id' => '_post_menu_cta_content_type',
					'label' => esc_html__( 'Additional Content', 'slikk' ),
					'type' => 'select',
					'default' => 'icons',
					'choices' => array_merge(
						array(
							'' => '&mdash; ' . esc_html__( 'Default', 'slikk' ) . ' &mdash;',
						),
						apply_filters( 'slikk_menu_cta_content_type_options', array(
							'search_icon' => esc_html__( 'Search Icon', 'slikk' ),
							'secondary-menu' => esc_html__( 'Secondary Menu', 'slikk' ),
						) ),
						array( 'none' => esc_html__( 'None', 'slikk' ) )
					),
				),

				array(
					'id' => '_post_show_nav_player',
					'label' => esc_html__( 'Show Navigation Player', 'slikk' ),
					'type' => 'select',
					'choices' => array(
						'' => '&mdash; ' . esc_html__( 'Default', 'slikk' ) . ' &mdash;',
						'yes' => esc_html__( 'Yes', 'slikk' ),
						'no' => esc_html__( 'No', 'slikk' ),
					),
				),

				array(
					'id' => '_post_side_panel_position',
					'label' => esc_html__( 'Side Panel', 'slikk' ),
					'type' => 'select',
					'choices' => array(
						'' => '&mdash; ' . esc_html__( 'Default', 'slikk' ) . ' &mdash;',
						'none' => esc_html__( 'None', 'slikk' ),
						'right' => esc_html__( 'At Right', 'slikk' ),
						'left' => esc_html__( 'At Left', 'slikk' ),
					),
					'desc' => esc_html__( 'Note that it will be disable with a vertical menu layout (overlay, offcanvas etc...).', 'slikk' ),
				),

				array(
					'id' => '_post_logo_visibility',
					'label' => esc_html__( 'Logo Visibility', 'slikk' ),
					'type' => 'select',
					'choices' => array(
						'' => '&mdash; ' . esc_html__( 'Default', 'slikk' ) . ' &mdash;',
						'always' => esc_html__( 'Always', 'slikk' ),
						'sticky_menu' => esc_html__( 'When menu is sticky only', 'slikk' ),
						'hidden' => esc_html__( 'Hidden', 'slikk' ),
					),
				),

				array(
					'id' => '_post_menu_items_visibility',
					'label' => esc_html__( 'Menu Items Visibility', 'slikk' ),
					'type' => 'select',
					'choices' => array(
						'' => '&mdash; ' . esc_html__( 'Default', 'slikk' ) . ' &mdash;',
						'show' => esc_html__( 'Visible', 'slikk' ),
						'hidden' => esc_html__( 'Hidden', 'slikk' ),
					),
					'desc' => esc_html__( 'If, for some reason, you need to hide the menu items but leave the logo, additional content and side panel.', 'slikk' ),
				),

				'menu_breakpoint' => array(
					'id' =>'_post_menu_breakpoint',
					'label' => esc_html__( 'Mobile Menu Breakpoint', 'slikk' ),
					'type' => 'text',
					'desc' => esc_html__( 'Use this field if you want to overwrite the mobile menu breakpoint.', 'slikk' ),
				),
			),
		)
	);

	$footer_metaboxes = array(
		'footer_settings' => array(
				'title' => esc_html__( 'Footer', 'slikk' ),
				'page' => apply_filters( 'slikk_menu_settings_post_types', array( 'post', 'page', 'plugin', 'video', 'product', 'gallery', 'theme', 'work', 'show', 'release', 'wpm_playlist', 'event' ) ),

			'metafields' => array(
				array(
					'label'	=> esc_html__( 'Page Footer', 'slikk' ),
					'id'	=> '_post_footer_type',
					'type'	=> 'select',
					'choices' => array(
						'' => '&mdash; ' . esc_html__( 'Default', 'slikk' ) . ' &mdash;',
						'hidden' => esc_html__( 'No Footer', 'slikk' ),
					),
				),

				array(
					'label'	=> esc_html__( 'Hide Bottom Bar', 'slikk' ),
					'id'	=> '_post_bottom_bar_hidden',
					'type'	=> 'select',
					'choices' => array(
						'' => esc_html__( 'No', 'slikk' ),
						'yes' => esc_html__( 'Yes', 'slikk' ),
					),
				),
			),
		)
	);

	/************** Post options ******************/

	$product_options = array();
	$product_options[] = esc_html__( 'WooCommerce not installed', 'slikk' );

	if ( class_exists( 'WooCommerce' ) ) {
		$product_posts = get_posts( 'post_type="product"&numberposts=-1' );

		$product_options = array();
		if ( $product_posts ) {

			$product_options[] = esc_html__( 'Not linked', 'slikk' );

			foreach ( $product_posts as $product ) {
				$product_options[ $product->ID ] = $product->post_title;
			}
		} else {
			$product_options[ esc_html__( 'No product yet', 'slikk' ) ] = 0;
		}
	}

	$post_metaboxes = array(
		'post_settings' => array(
			'title' => esc_html__( 'Post', 'slikk' ),
			'page' => array( 'post' ),
			'metafields' => array(
				array(
					'label'	=> esc_html__( 'Post Layout', 'slikk' ),
					'id'	=> '_post_layout',
					'type'	=> 'select',
					'choices' => array(
						'' => '&mdash; ' . esc_html__( 'Default', 'slikk' ) . ' &mdash;',
						'sidebar-right' => esc_html__( 'Sidebar Right', 'slikk' ),
						'sidebar-left' => esc_html__( 'Sidebar Left', 'slikk' ),
						'no-sidebar' => esc_html__( 'No Sidebar', 'slikk' ),
						'fullwidth' => esc_html__( 'Full width', 'slikk' ),
					),
				),

				array(
					'label'	=> esc_html__( 'Feature a Product', 'slikk' ),
					'id'	=> '_post_wc_product_id',
					'type'	=> 'select',
					'choices' => $product_options,
					'desc'	=> esc_html__( 'A "Shop Now" buton will be displayed in the metro layout.', 'slikk' ),
				),

				array(
					'label'	=> esc_html__( 'Featured', 'slikk' ),
					'id'	=> '_post_featured',
					'type'	=> 'checkbox',
					'desc'	=> esc_html__( 'Will be displayed bigger in the "metro" layout (auto pattern).', 'slikk' ),
				),
			),
		),
	);

	/************** Product options ******************/
	$product_metaboxes = array(

		'product_options' => array(
			'title' => esc_html__( 'Product', 'slikk' ),
			'page' => array( 'product' ),
			'metafields' => array(

				array(
					'label'	=> esc_html__( 'Coming Soon', 'slikk' ),
					'id'	=> '_post_product_newsletter',
					'type'	=> 'checkbox',
					'desc'	=> esc_html__( 'It will display a newsletter form instead of the "add to cart button".', 'slikk' ),
				),

				array(
					'label'	=> esc_html__( 'Newsletter Tagline', 'slikk' ),
					'id'	=> '_post_product_newsletter_tagline',
					'type'	=> 'text',
					'desc'	=> esc_html__( 'An optional text to display above the newsletter subscription form.', 'slikk' ),
				),

				array(
					'label'	=> esc_html__( 'Label', 'slikk' ),
					'id'	=> '_post_product_label',
					'type'	=> 'text',
					'placeholder' => esc_html__( '-30%', 'slikk' ),
				),

				array(
					'label'	=> esc_html__( 'Layout', 'slikk' ),
					'id'	=> '_post_product_single_layout',
					'type'	=> 'select',
					'choices' => array(
						'' => '&mdash; ' . esc_html__( 'Default', 'slikk' ) . ' &mdash;',
						'standard' => esc_html__( 'Standard', 'slikk' ),
						'sidebar-right' => esc_html__( 'Sidebar Right', 'slikk' ),
						'sidebar-left' => esc_html__( 'Sidebar Left', 'slikk' ),
						'fullwidth' => esc_html__( 'Full Width', 'slikk' ),
					),
				),

				array(
					'label'	=> esc_html__( 'Size Chart Image', 'slikk' ),
					'id'	=> '_post_wc_product_size_chart_img',
					'type'	=> 'image',
					'desc' => esc_html__( 'You can set a size chart image in the product category options. You can overwrite the category size chart for this product by uploading another image here.', 'slikk' ),
				),

				array(
					'label'	=> esc_html__( 'Hide Size Chart Image', 'slikk' ),
					'id'	=> '_post_wc_product_hide_size_chart_img',
					'type'	=> 'checkbox',
				),

				array(
					'label'	=> esc_html__( 'Menu Font Tone', 'slikk' ),
					'id'	=> '_post_hero_font_tone',
					'type'	=> 'select',
					'choices' => array(
						'' => '&mdash; ' . esc_html__( 'Default', 'slikk' ) . ' &mdash;',
						'light' => esc_html__( 'Light', 'slikk' ),
						'dark' => esc_html__( 'Dark', 'slikk' ),
					),
					'desc' => esc_html__( 'By default the menu style is set to "solid" on single product page. If you change the menu style, you may need to adujst the menu color tone here.', 'slikk' ),
				),

				'menu_sticky_type' => array(
					'id' =>'_post_product_sticky',
					'label' => esc_html__( 'Stacked Images', 'slikk' ),
					'type' => 'select',
					'choices' => array(
						'' => '&mdash; ' . esc_html__( 'Default', 'slikk' ) . ' &mdash;',
						'yes' => esc_html__( 'Yes', 'slikk' ),
						'no' => esc_html__( 'No', 'slikk' ),
					),
				),

				array(
					'label'	=> esc_html__( 'Disable Image Zoom', 'slikk' ),
					'id'	=> '_post_product_disable_easyzoom',
					'type'	=> 'checkbox',
					'desc' => esc_html__( 'Disable image zoom on this product if it\'s enabled in the customizer.', 'slikk' ),
				),
			),
		),
	);

	/************** Product options ******************/

	$product_options = array();
	$product_options[] = esc_html__( 'WooCommerce not installed', 'slikk' );

	if ( class_exists( 'WooCommerce' ) ) {
		$product_posts = get_posts( 'post_type="product"&numberposts=-1' );

		$product_options = array();
		if ( $product_posts ) {

			$product_options[] = esc_html__( 'Not linked', 'slikk' );

			foreach ( $product_posts as $product ) {
				$product_options[ $product->ID ] = $product->post_title;
			}
		} else {
			$product_options[ esc_html__( 'No product yet', 'slikk' ) ] = 0;
		}
	}

	/************** Portfolio options ******************/
	$work_metaboxes = array(

		'work_options' => array(
			'title' => esc_html__( 'Work', 'slikk' ),
			'page' => array( 'work' ),
			'metafields' => array(

				array(
					'label'	=> esc_html__( 'Client', 'slikk' ),
					'id'	=> '_work_client',
					'type'	=> 'text',
				),

				array(
					'label'	=> esc_html__( 'Link', 'slikk' ),
					'id'		=> '_work_link',
					'type'	=> 'text',
				),

				array(
					'label'	=> esc_html__( 'Width', 'slikk' ),
					'id'	=> '_post_width',
					'type'	=> 'select',
					'choices' => array(
						'standard' => esc_html__( 'Standard', 'slikk' ),
						'wide' => esc_html__( 'Wide', 'slikk' ),
						'fullwidth' => esc_html__( 'Full Width', 'slikk' ),
					),
				),

				array(
					'label'	=> esc_html__( 'Layout', 'slikk' ),
					'id'	=> '_post_layout',
					'type'	=> 'select',
					'choices' => array(
						'centered' => esc_html__( 'Centered', 'slikk' ),
						'sidebar-right' => esc_html__( 'Excerpt & Info at Right', 'slikk' ),
						'sidebar-left' => esc_html__( 'Excerpt & Info at Left', 'slikk' ),
					),
				),

				array(
					'label'	=> esc_html__( 'Excerpt & Info Position', 'slikk' ),
					'id'	=> '_post_work_info_position',
					'type'	=> 'select',
					'choices' => array(
						'after' => esc_html__( 'After Content', 'slikk' ),
						'before' => esc_html__( 'Before Content', 'slikk' ),
						'none' => esc_html__( 'Hidden', 'slikk' ),
					),
				),

				// array(
				// 	'label'	=> esc_html__( 'Featured', 'slikk' ),
				// 	'id'	=> '_post_featured',
				// 	'type'	=> 'checkbox',
				// 	'desc'	=> esc_html__( 'The featured image will be display bigger in the "metro" layout.', 'slikk' ),
				// ),
			),
		),
	);


	/************** One pager options ******************/
	$one_page_metaboxes = array(
		'one_page_settings' => array(
			'title' => esc_html__( 'One-Page', 'slikk' ),
			'page' => array( 'post', 'page', 'work', 'product' ),
			'metafields' => array(
				array(
					'label'	=> esc_html__( 'One-Page Navigation', 'slikk' ),
					'id'	=> '_post_one_page_menu',
					'type'	=> 'select',
					'choices' => array(
						'' => esc_html__( 'No', 'slikk' ),
						'replace_main_nav' => esc_html__( 'Yes', 'slikk' ),
					),
					'desc'	=> slikk_kses( __( 'Activate to replace the main menu by a one-page scroll navigation. <strong>NB: Every row must have a unique name set in the row settings "Advanced" tab.</strong>', 'slikk' ) ),
				),
				array(
					'label'	=> esc_html__( 'One-Page Bullet Navigation', 'slikk' ),
					'id'	=> '_post_scroller',
					'type'	=> 'checkbox',
					'desc'	=> slikk_kses( __( 'Activate to create a section scroller navigation. <strong>NB: Every row must have a unique name set in the row settings "Advanced" tab.</strong>', 'slikk' ) ),
				),
				array(
					'label'	=> sprintf( esc_html__( 'Enable %s animations', 'slikk' ), 'fullPage' ),
					'id'	=> '_post_fullpage',
					'type'	=> 'select',
					'choices' => array(
						'' => esc_html__( 'No', 'slikk' ),
						'yes' => esc_html__( 'Yes', 'slikk' ),
					),
					'desc' => esc_html__( 'Activate to enable advanced scroll animations between sections. Some of your row setting may be disabled to suit the global page design.', 'slikk' ),
				),

				array(
					'label'	=> sprintf( esc_html__( '%s animation transition', 'slikk' ), 'fullPage' ),
					'id'	=> '_post_fullpage_transition',
					'type'	=> 'select',
					'choices' => array(
						'mix' => esc_html__( 'Special', 'slikk' ),
						'parallax' => esc_html__( 'Parallax', 'slikk' ),
						'fade' => esc_html__( 'Fade', 'slikk' ),
						'zoom' => esc_html__( 'Zoom', 'slikk' ),
						'curtain' => esc_html__( 'Curtain', 'slikk' ),
						'slide' => esc_html__( 'Slide', 'slikk' ),
					),
					'dependency' => array( 'element' => '_post_fullpage', 'value' => array( 'yes' ) ),
				),

				array(
					'label'	=> sprintf( esc_html__( '%s animation duration', 'slikk' ), 'fullPage' ),
					'id'	=> '_post_fullpage_animtime',
					'type'	=> 'text',
					'placeholder' => 1000,
					'dependency' => array( 'element' => '_post_fullpage', 'value' => array( 'yes' ) ),
				),
			),
		),
	);

	$all_metaboxes = array_merge(
		apply_filters( 'slikk_body_metaboxes', $body_metaboxes ),
		apply_filters( 'slikk_post_metaboxes', $post_metaboxes ),
		apply_filters( 'slikk_product_metaboxes', $product_metaboxes ),
		apply_filters( 'slikk_work_metaboxes',  $work_metaboxes ),
		apply_filters( 'slikk_header_metaboxes', $header_metaboxes ),
		apply_filters( 'slikk_menu_metaboxes', $menu_metaboxes ),
		apply_filters( 'slikk_footer_metaboxes', $footer_metaboxes )
	);

	if ( class_exists( 'Wolf_Visual_Composer' ) && defined( 'WPB_VC_VERSION' ) ) {
		$all_metaboxes = $all_metaboxes + apply_filters( 'slikk_one_page_metaboxes', $one_page_metaboxes );
	}

	if ( class_exists( 'Wolf_Metaboxes' ) ) {
		new Wolf_Metaboxes( apply_filters( 'slikk_metaboxes', $all_metaboxes ) );
	}
}
slikk_register_metabox();
