<?php
/**
 * Slikk recommended plugins
 *
 * @package WordPress
 * @subpackage Slikk
 * @since Slikk 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

//delete_user_meta( get_current_user_id(), 'tgmpa_dismissed_notice_tgmpa' );

/* Require TGM Plugin Activation class */
include_once( get_template_directory() . '/inc/admin/lib/class-tgm-plugin-activation.php' );

function wolf_theme_register_required_plugins() {

	$plugins = array(

		array(
			'name'    => esc_html__( 'WPBakery Page Builder', 'slikk' ),
			'slug'   => 'js_composer',
			'source' => 'js_composer.zip',
			'required' => true,
		),

		array(
			'name'    => esc_html__( 'Slider Revolution', 'slikk' ),
			'slug'   => 'revslider',
			'source'   => 'revslider.zip',
			'version' => '6.2',
		),

		array(
			'name'    => esc_html__( 'WPBakery Page Builder Extension', 'slikk' ),
			'slug'   => 'wolf-visual-composer',
			'source'   => 'https://github.com/wolfthemes/wolf-visual-composer/archive/master.zip',
			'external_url' => 'https://github.com/wolfthemes/wolf-visual-composer/archive/master.zip',
			'required' => true,
		),

		array(
			'name'    => esc_html__( 'WPBakery Page Builder Content Blocks', 'slikk' ),
			'slug'   => 'wolf-vc-content-block',
			'source'   => 'https://github.com/wolfthemes/wolf-vc-content-block/archive/master.zip',
			'external_url' => 'https://github.com/wolfthemes/wolf-vc-content-block/archive/master.zip',
		),

		array(
			'name'    => esc_html__( 'Portfolio', 'slikk' ),
			'slug'   => 'wolf-portfolio',
			'source'   => 'https://github.com/wolfthemes/wolf-portfolio/archive/master.zip',
			'external_url' => 'https://github.com/wolfthemes/wolf-portfolio/archive/master.zip',
		),

		array(
			'name'    => esc_html__( 'Share Icons', 'slikk' ),
			'slug'   => 'wolf-share',
			'source'   => 'https://github.com/wolfthemes/wolf-share/archive/master.zip',
			'external_url' => 'https://github.com/wolfthemes/wolf-share/archive/master.zip',
		),

		array(
			'name'    => esc_html__( 'Custom Post Meta', 'slikk' ),
			'slug'   => 'wolf-custom-post-meta',
			'source'   => 'https://github.com/wolfthemes/wolf-custom-post-meta/archive/master.zip',
			'external_url' => 'https://github.com/wolfthemes/wolf-custom-post-meta/archive/master.zip',
		),

		array(
			'name'    => esc_html__( 'Twitter Feed', 'slikk' ),
			'slug'   => 'wolf-twitter',
			'source'   => 'https://github.com/wolfthemes/wolf-twitter/archive/master.zip',
			'external_url' => 'https://github.com/wolfthemes/wolf-twitter/archive/master.zip',
		),

		array(
			'name' 	=> esc_html__( 'Instagram Feed (Smash Balloon)', 'slikk' ),
			'slug' => 'instagram-feed',
		),

		array(
			'name'    => esc_html__( 'Video Thumbnail Generator', 'slikk' ),
			'slug'   => 'wolf-video-thumbnail-generator',
			'source'   => 'https://github.com/wolfthemes/wolf-video-thumbnail-generator/archive/master.zip',
			'external_url' => 'https://github.com/wolfthemes/wolf-video-thumbnail-generator/archive/master.zip',
		),

		array(
			'name'    => esc_html__( 'Metaboxes', 'slikk' ),
			'slug'   => 'wolf-metaboxes',
			'source'   => 'https://github.com/wolfthemes/wolf-metaboxes/archive/master.zip',
			'external_url' => 'https://github.com/wolfthemes/wolf-metaboxes/archive/master.zip',
		),

		array(
			'name' 	=> esc_html__( 'WooCommerce', 'slikk' ),
			'slug' => 'woocommerce',
		),

		array(
			'name'    => esc_html__( 'WooCommerce Wishlist', 'slikk' ),
			'slug'   => 'wolf-woocommerce-wishlist',
			'source'   => 'https://github.com/wolfthemes/wolf-woocommerce-wishlist/archive/master.zip',
			'external_url' => 'https://github.com/wolfthemes/wolf-woocommerce-wishlist/archive/master.zip',
		),

		array(
			'name'    => esc_html__( 'WooCommerce Quickview', 'slikk' ),
			'slug'   => 'wolf-woocommerce-quickview',
			'source'   => 'https://github.com/wolfthemes/wolf-woocommerce-quickview/archive/master.zip',
			'external_url' => 'https://github.com/wolfthemes/wolf-woocommerce-quickview/archive/master.zip',
		),

		array(
			'name' 	=> esc_html__( 'WooCommerce Variation Swatches', 'slikk' ),
			'slug' => 'variation-swatches-for-woocommerce',
		),

		array(
			'name' 	=> esc_html__( 'Contact Form 7', 'slikk' ),
			'slug' => 'contact-form-7',
		),

		array(
			'name' => esc_html__( 'Envato Market Items Updater', 'slikk' ),
			'slug' => 'envato-market',
			'source' => 'https://envato.github.io/wp-envato-market/dist/envato-market.zip',
			'external_url' => 'https://envato.github.io/wp-envato-market/dist/envato-market.zip',
		),

		array(
			'name' => esc_html__( 'One Click Demo Import', 'slikk' ),
			'slug' => 'one-click-demo-import',
		),
	);

	// Change this to your theme text domain, used for internationalising strings
	$theme_text_domain = 'slikk';

	/*
	 * Array of configuration settings. Amend each line as needed.
	 *
	 * TGMPA will start providing localized text strings soon. If you already have translations of our standard
	 * strings available, please help us make TGMPA even better by giving us access to these translations or by
	 * sending in a pull-request with .po file(s) with the translations.
	 *
	 * Only uncomment the strings in the config array if you want to customize the strings.
	 */
	$config = array(
		'id' => 'tgmpa',
		'default_path' => get_template_directory() . '/config/plugins/',
		'menu'         => 'tgmpa-install-plugins',
		'parent_slug'  => 'themes.php',
		'capability'   => 'edit_theme_options',
		'has_notices'  => true,
		'dismissable'  => true,
		'dismiss_msg'  => '',
		'is_automatic' => false,
		'message'      => '',
	);
	tgmpa( $plugins, $config );
}
add_action( 'tgmpa_register', 'wolf_theme_register_required_plugins' );
