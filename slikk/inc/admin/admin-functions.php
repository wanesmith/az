<?php
/**
 * Slikk admin functions
 *
 * @package WordPress
 * @subpackage Slikk
 * @version 1.4.2
 */

defined( 'ABSPATH' ) || exit;

/**
 * Server requirement admin notice
 */
function slikk_server_requirements_notice() {

	global $pagenow;

	$requirements_ok = true;

	foreach ( slikk_get_minimum_required_server_vars() as $constant => $required_value ) {

		switch ( $constant ) {
			case 'REQUIRED_PHP_VERSION':
				if ( ! version_compare( phpversion(), $required_value, '>=' ) ) {
					$requirements_ok = false;
				}

				break;

			case 'REQUIRED_WP_VERSION':
				if ( ! version_compare( get_bloginfo( 'version' ), $required_value, '>=' ) ) {
					$requirements_ok = false;
				}

				break;

			case 'REQUIRED_WP_MEMORY_LIMIT':
				if ( wp_convert_hr_to_bytes( WP_MEMORY_LIMIT ) < wp_convert_hr_to_bytes( $required_value ) ) {
					$requirements_ok = false;
				}

				break;

			case 'REQUIRED_SERVER_MEMORY_LIMIT':
				if ( wp_convert_hr_to_bytes( ini_get( 'memory_limit' ) ) < wp_convert_hr_to_bytes( $required_value ) ) {
					$requirements_ok = false;
				}

				break;
			case 'REQUIRED_MAX_INPUT_VARS':
				if ( ini_get( 'max_input_vars' ) < $required_value ) {
					$requirements_ok = false;
				}

				break;
		}
	}

	if ( ! $requirements_ok && 'index.php' === $pagenow ) {
		$message = sprintf(
			/* translators: 1: theme name, 2: admin system status URl */
			slikk_kses( __( 'It is recommended that your server settings match the recommended minimum requirements to run %1$s smoothly. Please review your <a href="%2$s">system status</a>.', 'slikk' ) ),
			slikk_get_theme_name(),
			esc_url( admin_url( 'themes.php?page=' . slikk_get_theme_slug() . '-about#system-status' ) )
		);
		slikk_admin_notice( $message, 'info', slikk_get_theme_slug() . '_server_requirements', esc_html__( 'Dismiss this notice', 'slikk' ) );
	}
}
add_action( 'admin_init', 'slikk_server_requirements_notice' );

/**
 * Enables the Excerpt meta box in Work & Release edit screen.
 *
 * For old version of Wolf Portfolio & Wolf Discography
 */
function slikk_add_excerpt_support_for_post_types() {
	add_post_type_support( 'work', 'excerpt' );
	add_post_type_support( 'release', 'excerpt' );
}
add_action( 'init', 'slikk_add_excerpt_support_for_post_types' );

/**
 * Add helper admin notice on work post
 */
function slikk_help_admin_notice() {

	if ( slikk_is_elementor_editor() ) {
		return false;
	}

	global $pagenow;

	$post_type = '';

	if ( isset( $_GET['post_type'] ) ) { // phpcs:ignore WordPress.Security.NonceVerification.Recommended
		$post_type = esc_attr( wp_unslash( $_GET['post_type'] ) ); // phpcs:ignore

	} elseif ( isset( $_GET['post'] ) ) { // phpcs:ignore WordPress.Security.NonceVerification.Recommended
		$post_type = get_post_type( absint( $_GET['post'] ) ); // phpcs:ignore
	}

	/* Offer to import demo content */
	$theme_slug = slikk_get_theme_slug();

	if ( isset( $_GET[ $theme_slug . '-dismiss-demo-data-import' ] ) && 'yes' === esc_attr( $_GET[ $theme_slug . '-dismiss-demo-data-import' ] ) ) { // phpcs:ignore WordPress.Security.NonceVerification.Recommended
		update_option( $theme_slug . '_dismiss_demo_data_import', true );
	}

	$import_demo_flag            = get_option( $theme_slug . '_demo_data_imported' );
	$dissmissed_import_demo_flag = get_option( $theme_slug . '_dismiss_demo_data_import' );
	$is_ocdi_page                = ( isset( $_GET['page'] ) && 'pt-one-click-demo-import' === $_GET['page'] );

	if ( ! $import_demo_flag && ! $dissmissed_import_demo_flag && ! $is_ocdi_page && class_exists( 'OCDI_Plugin' ) && 'index.php' === $pagenow ) {

		$cookie_id = $theme_slug . '_wolf_install_demo_data';

		$message  = '<h3>';
		$message .= esc_html__( 'Hey there, would you like to import the demo content to help you to get started?', 'slikk' );
		$message .= '</h3>';

		$message .= '<h4>';
		$message .= esc_html__( 'In this case, please ignore the plugin page setups below.', 'slikk' );
		$message .= '</h4>';

		$message .= '<p>';
		$message .= sprintf(
			slikk_kses( __( 'If you dismiss this notification, you can still access the demo import page via the "Appearance > <a href="%s">Import Demo Data</a>" panel.', 'slikk' ) ),
			esc_url( admin_url( 'themes.php?page=pt-one-click-demo-import' ) )
		);
		$message .= '</p><br>';

		$message .= sprintf(
			/* translators: %s: demo import URL */
			slikk_kses( __( '<a href="%s" class="button button-primary button-hero">Install demo data</a><br>', 'slikk' ) ),
			esc_url( admin_url( 'themes.php?page=pt-one-click-demo-import' ) )
		);

		$message .= '<br><p>';

		$message .= sprintf(
			/* translators: %s: dismiss demo import notification URL */
			slikk_kses( __( '<a href="%s">No thanks</a><br>', 'slikk' ) ),
			esc_url( admin_url( 'index.php?' . $theme_slug . '-dismiss-demo-data-import=yes' ) )
		);
		$message .= '</p>';

		slikk_admin_notice( $message, 'info' );
	}

	/*----------------------------*/

	if ( $import_demo_flag && class_exists( 'WooCommerce' ) && 'index.php' === $pagenow ) {

		$cookie_id = $theme_slug . '_wolf_woocommerce_pages_set';

		$message = esc_html__( 'The demo data was successfully imported. ', 'slikk' );

		$message .= sprintf(
			/* translators: %s: install demo import notification URL */
			slikk_kses( __( '<a href="%1$s" class="button button-primary button-hero">Install demo data</a><br>', 'slikk' ) ),
			esc_url( admin_url( 'admin.php?page=wc-settings&tab=products&section=display' ) )
		);
	}

	/*----------------------------*/

	/* Info Work */
	if ( 'work' === $post_type && ( 'post.php' === $pagenow || 'post-new.php' === $pagenow ) ) {
		$message   = esc_html__( 'Please use the main text editor to showcase your media content and the "excerpt" box to insert an explanatory text in the page.', 'slikk' );
		$cookie_id = $theme_slug . '_wolf_work_help';

		slikk_admin_notice( $message, 'info', $cookie_id, esc_html__( 'Dismiss this notice', 'slikk' ) );
	}

	/* Release */
	if ( 'release' === $post_type && ( 'post.php' === $pagenow || 'post-new.php' === $pagenow ) ) {
		$message   = esc_html__( 'You can use the main text editor to showcase your media content usign the page builder, with a playlist for example. In this case it is recommended to set your row "Content Width" to "Full Width" and the background settings to "No Background".', 'slikk' );
		$cookie_id = $theme_slug . '_wolf_release_help';

		slikk_admin_notice( $message, 'info', $cookie_id, esc_html__( 'Dismiss this notice', 'slikk' ) );
	}

	/* Artist */
	if ( 'artist' === $post_type && ( 'post.php' === $pagenow || 'post-new.php' === $pagenow ) ) {
		$message   = esc_html__( 'You can use the main text editor for the "Biography" tab and the "Excerpt" box for an additional text below the artist\'s name. If you use the page builder for the bio, it is recommended to set your row "Content Width" to "Full Width". If you want to use the page builder to build your page entirely, you must choose the "Custom" layout option in the options below the text editor.', 'slikk' );
		$cookie_id = $theme_slug . '_wolf_release_help';

		slikk_admin_notice( $message, 'info', $cookie_id, esc_html__( 'Dismiss this notice', 'slikk' ) );
	}

	/* Set exceprt content recommendation */
	if ( ( 'mp-event' === $post_type || 'mp-colum' === $post_type ) && ( 'post.php' === $pagenow || 'post-new.php' === $pagenow ) ) {

		$message   = esc_html__( 'If your post content is designed with the page builder, it is recommended to set your row "Content Width" to "Full Width" and the background settings to "No Background".', 'slikk' );
		$cookie_id = $theme_slug . '_wolf_mp_timetable_help';

		slikk_admin_notice( $message, 'info', $cookie_id, esc_html__( 'Dismiss this notice', 'slikk' ) );
	}

	/* Set exceprt content recommendation */
	if ( 'post' === $post_type && ( 'post.php' === $pagenow || 'post-new.php' === $pagenow ) ) {

		if ( slikk_has_vc_content() ) {
			$message   = esc_html__( 'If your post content is designed with the page builder, it is recommended to enter a post text sample in the "excerpt" box.', 'slikk' );
			$message  .= ' ' . esc_html__( 'In this case it is recommended to set your row "Content Width" to "Full Width" and the background settings to "No Background".', 'slikk' );
			$cookie_id = $theme_slug . '_wolf_post_help';

			slikk_admin_notice( $message, 'info', $cookie_id, esc_html__( 'Dismiss this notice', 'slikk' ) );
		}
	}

	/* Gutenberg */
	if ( ! get_option( 'wpb_js_gutenberg_disable' ) && defined( 'WPB_VC_VERSION' ) && 'index.php' === $pagenow && ! defined( 'DOING_AJAX' ) ) {
		$message = sprintf(
			/* translators: 1: page builder name, 2: Gutenberg, 3: page builder settings admin page URL, 4: page builder settings admin page title */
			slikk_kses( __( 'It seems that both <strong>%1$s</strong> and <strong>%2$s</strong> are enabled. You can disable %2$s in the <a href="%3$s">%4$s</a>.<br>', 'slikk' ) ),
			'WPBakery Page Builder',
			'Gutenberg',
			esc_url( admin_url( 'admin.php?page=vc-general' ) ),
			'WPBakery Page Builder General Settings'
		);
		$cookie_id = $theme_slug . '_wolf_gutenberg_not_disabled';

		slikk_admin_notice( $message, 'warning', $cookie_id, esc_html__( 'Dismiss this notice', 'slikk' ) );
	}
}
add_action( 'admin_init', 'slikk_help_admin_notice' );

/**
 * Custom admin notice
 *
 * @param string $message the message string.
 * @param string $type error|warning|info|success.
 * @param string $cookie_id if set a cookie will be use to hide the notice permanently.
 * @param string $dismiss_text dismiss message text.
 */
function slikk_admin_notice( $message = null, $type = null, $cookie_id = null, $dismiss_text = null ) {

	if ( ! $message || defined( 'DOING_AJAX' ) ) {
		return;
	}

	$is_dismissible = ( 'error' === $message ) ? '' : 'is-dismissible';

	if ( $cookie_id ) {

		if ( ! $dismiss_text ) {
			$dismiss_text = esc_html__( 'Hide permanently', 'slikk' );
		}

		if ( $cookie_id ) {
			if ( ! isset( $_COOKIE[ $cookie_id ] ) ) {
				$href = esc_url( admin_url( 'themes.php?page=' . slikk_get_theme_slug() . '-about&amp;dismiss=' . $cookie_id ) );
				echo "<div class='notice notice-$type $is_dismissible'><p>$message</p><p><a href='$href' id='$cookie_id' class='button slikk-dismiss-admin-notice'>$dismiss_text</a></p></div>"; // WCS XSS ok.
			}
		}
	} else {
		echo "<div class='notice notice-$type $is_dismissible'><p>$message</p></div>"; // phpcs:ignore
	}
	return false;
}
add_action( 'admin_notices', 'slikk_admin_notice' );

/**
 * Remove post formats on work posts
 */
function slikk_remove_work_post_formats() {

	if ( apply_filters( 'slikk_disable_work_post_formats', true ) ) {

		$post_type = '';

		if ( isset( $_GET['post_type'] ) ) { // phpcs:ignore WordPress.Security.NonceVerification.Recommended
			$post_type = esc_attr( $_GET['post_type'] ); // phpcs:ignore

		} elseif ( isset( $_GET['post'] ) ) { // phpcs:ignore WordPress.Security.NonceVerification.Recommended
			$post_type = get_post_type( absint( $_GET['post'] ) ); // phpcs:ignore WordPress.Security.NonceVerification.Recommended
		}

		if ( 'work' === $post_type ) {
			remove_theme_support( 'post-formats' );
		}
	}
}
add_action( 'load-post.php', 'slikk_remove_work_post_formats' );
add_action( 'load-post-new.php', 'slikk_remove_work_post_formats' );

/**
 * Remove unwanted plugin submenu
 */
function slikk_remove_wolf_plugin_submenu() {
	remove_submenu_page( 'edit.php?post_type=work', 'wolf-portfolio-shortcode' );
	remove_submenu_page( 'edit.php?post_type=gallery', 'wolf-albums-shortcode' );
	remove_submenu_page( 'edit.php?post_type=video', 'wolf-videos-shortcode' );
	remove_submenu_page( 'edit.php?post_type=release', 'wolf-discography-shortcode' );
	remove_submenu_page( 'edit.php?post_type=wpm_playlist', 'wolf-playlist-manager-settings' );
	remove_submenu_page( 'themes.php', 'wolf-custom-post-meta-settings' );

	if ( defined( 'VC_PAGE_MAIN_SLUG' ) ) {
		remove_submenu_page( VC_PAGE_MAIN_SLUG, 'wvc-socials' );
		remove_submenu_page( VC_PAGE_MAIN_SLUG, 'wvc-fonts' );
		remove_submenu_page( VC_PAGE_MAIN_SLUG, 'edit.php?post_type=vc_grid_item' );
	}
}
add_action( 'admin_menu', 'slikk_remove_wolf_plugin_submenu', 999 );

/**
 * Sync theme font option with WWPBPBE plugin
 *
 * @param  array $options array of options.
 * @return array $options
 */
function slikk_sync_theme_font_options_with_wvc( $options ) {
	if ( isset( $options['google_fonts'] ) ) {

		if ( function_exists( 'wvc_update_option' ) ) {

			wvc_update_option( 'fonts', 'google_fonts', $options['google_fonts'] );

		}

		if ( function_exists( 'wolf_core_update_option' ) ) {

			wolf_core_update_option( 'fonts', 'google_fonts', $options['google_fonts'] );
		}
	}

	return $options;
}
add_action( 'slikk_after_' . slikk_get_theme_slug() . '_font_settings_options_save', 'slikk_sync_theme_font_options_with_wvc', 10, 1 );

/**
 * Sync WWPBPBE plugin fonts option with theme fonts
 *
 * @param  array $options array of options.
 * @return array $options
 */
function slikk_sync_wvc_font_options_with_theme( $options ) {

	if ( isset( $options['google_fonts'] ) ) {
		$fonts = $options['google_fonts'];
		slikk_update_option( 'font', 'google_fonts', $fonts );
	}

	return $options;
}
add_action( 'wvc_after_options_save', 'slikk_sync_wvc_font_options_with_theme', 10, 1 );
add_action( 'wolf_core_after_options_save', 'slikk_sync_wvc_font_options_with_theme', 10, 1 );

/**
 * Sync theme social mods with WWPBPBE plugin options
 *
 * Save social profiles URL from customizer to plugin settings
 */
function slikk_sync_theme_social_mods_with_page_builder() {

	if ( function_exists( 'wolf_core_get_socials' ) ) {

		$wolf_core_socials = wolf_core_get_socials();

		foreach ( $wolf_core_socials as $service ) {
			$mod = get_theme_mod( $service );

			if ( $mod ) {
				wolf_core_update_option( 'socials', $service, $mod );
			}
		}
	}

	if ( function_exists( 'wvc_get_socials' ) ) {

		$wvc_socials = wvc_get_socials();

		foreach ( $wvc_socials as $service ) {
			$mod = get_theme_mod( $service );

			if ( $mod ) {
				wvc_update_option( 'socials', $service, $mod );
			}
		}
	}
}
add_action( 'customize_save_after', 'slikk_sync_theme_social_mods_with_page_builder' );

/**
 * Sync WWPBPBE social options with theme mods
 *
 * Hook plugin option save to sync social networks theme mods
 *
 * @param  array $options array of options.
 * @return array $options
 */
function slikk_sync_wvc_social_options_with_theme( $options ) {
	if ( function_exists( 'wvc_get_socials' ) ) {
		$wvc_socials = wvc_get_socials();

		foreach ( $wvc_socials as $service ) {
			if ( isset( $options[ $service ] ) ) {
				set_theme_mod( $service, esc_attr( $options[ $service ] ) );
			}
		}
	}

	if ( function_exists( 'wolf_core_get_socials' ) ) {
		$wolf_core_socials = wolf_core_get_socials();

		foreach ( $wolf_core_socials as $service ) {
			if ( isset( $options[ $service ] ) ) {
				set_theme_mod( $service, esc_attr( $options[ $service ] ) );
			}
		}
	}

	return $options;
}
add_action( 'wvc_after_options_save', 'slikk_sync_wvc_social_options_with_theme' );


/**
 * Add CTA menu content type options
 *
 * @param array $options array of options.
 * @return array $options
 */
function slikk_add_cta_menu_content_types( $options ) {

	if ( slikk_is_wolf_extension_activated() ) {
		$options['socials'] = esc_html__( 'Socials', 'slikk' );
	}

	if ( slikk_is_wc_activated() ) {
		$options['shop_icons'] = esc_html__( 'Shop Icons', 'slikk' );
	}

	if ( function_exists( 'icl_object_id' ) ) {
		$options['wpml'] = esc_html__( 'Language Switcher', 'slikk' );
	}

	return $options;
}
add_filter( 'slikk_menu_cta_content_type_options', 'slikk_add_cta_menu_content_types' );

/**
 * Filter theme menu layout mod
 *
 * If WPM is not installed and the menu with language switcher is set, return another menu layout instead
 *
 * @param  string $mod theme mod.
 * @return string $mod
 */
function slikk_filter_menu_cta_content_type( $mod ) {

	if ( 'socials' === $mod && ! slikk_is_wolf_extension_activated() ) {
		$mod = 'icons';
	}

	if ( 'wpml' === $mod && ! slikk_is_wolf_extension_activated() ) {
		$mod = 'icons';
	}

	return $mod;
}
add_filter( 'theme_mod_cta_content', 'slikk_filter_menu_layout_theme_mods' );

/**
 * Check if current post content has VC content in it
 *
 * @return bool
 */
function slikk_has_vc_content() {

	if ( isset( $_GET['post'] ) ) { // phpcs:ignore WordPress.Security.NonceVerification.Recommended
		$post = get_post( absint( $_GET['post'] ) ); // phpcs:ignore

		if ( is_object( $post ) && preg_match( '/vc_row/', $post->post_content, $match ) ) {
			return true;
		}
	}
}

/**
 * Get the rev slider list
 *
 * @see http://themeforest.net/forums/thread/add-rev-slider-to-theme-please-authors-reply/97711
 * @return array $result
 */
function slikk_get_revsliders() {

	if ( class_exists( 'RevSlider' ) ) {
		$theslider     = new RevSlider();
		$sliders_array = $theslider->getArrSliders(); // phpcs:ignore
		$alias_array   = array();
		$title_array   = array();
		foreach ( $sliders_array as $slider ) {
			$alias_array[] = $slider->getAlias();
			$title_array[] = $slider->getTitle();
		}

		if ( $alias_array && $title_array ) {
			$result = array_combine( $alias_array, $title_array );
		} else {
			$result = array( '' => esc_html__( 'No slider yet', 'slikk' ) );
		}

		return $result;
	}
}

/*
---------------------------------------------------------------

	Tiny MCE custom class

-----------------------------------------------------------------
*/

/**
 * Callback function to insert 'styleselect' into the $buttons array
 *
 * @param array $buttons the MCE buttons array.
 * @return array
 */
function slikk_mce_styleselect_button( $buttons ) {
	array_unshift( $buttons, 'styleselect' );
	return $buttons;
}
add_filter( 'mce_buttons_2', 'slikk_mce_styleselect_button' );

/**
 * Callback function to filter the MCE settings
 *
 * @param  array $init_array inital font fromat array.
 * @return array
 */
function slikk_mce_before_init_insert_formats( $init_array ) {

	$style_formats = array(
		array(
			'title'   => esc_html__( 'Accent Color', 'slikk' ),
			'inline'  => 'span',
			'classes' => 'accent',
			'wrapper' => false,
		),

		array(
			'title'   => esc_html__( 'Caption', 'slikk' ),
			'inline'  => 'span',
			'classes' => 'caption',
			'wrapper' => false,
		),
	);

	$style_formats = apply_filters( 'slikk_tiny_mce_style_formats', $style_formats );
	$init_array['style_formats'] = wp_json_encode( $style_formats );

	return $init_array;
}
add_filter( 'tiny_mce_before_init', 'slikk_mce_before_init_insert_formats' );
