<?php
/**
 * Slikk Frontend Scripts
 *
 * @package WordPress
 * @subpackage Slikk
 * @version 1.4.2
 */

defined( 'ABSPATH' ) || exit;

/**
 * Remove plugin scripts
 * Allow an easier customization
 */
function slikk_dequeue_plugin_scripts() {
	wp_dequeue_script( 'wolf-portfolio' );
	wp_dequeue_script( 'wolf-videos' );
	wp_dequeue_script( 'wolf-albums' );
	wp_dequeue_script( 'wolf-discography' );
}
add_action( 'wp_enqueue_scripts', 'slikk_dequeue_plugin_scripts' );

if ( ! function_exists( 'slikk_enqueue_scripts' ) ) {
	/**
	 * Register theme scripts for the theme
	 */
	function slikk_enqueue_scripts() {

		$suffix  = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? '' : '.min';
		$version = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? time() : slikk_get_theme_version();
		if ( defined( 'AUTOPTIMIZE_PLUGIN_DIR' ) ) {
			$suffix = '';
		}

		$lightbox = apply_filters( 'slikk_lightbox', slikk_get_theme_mod( 'lightbox', 'fancybox' ) );
		wp_enqueue_script( 'wp-mediaelement' );

		wp_enqueue_script( 'jquery-migrate' );

		/**
		 * Enqueuing main scripts
		 */
		wp_register_script( 'jarallax', get_template_directory_uri() . '/assets/js/lib/jarallax.min.js', array( 'jquery' ), '1.8.0', false );
		wp_enqueue_script( 'js-cookie', get_template_directory_uri() . '/assets/js/lib/js.cookie.min.js', array( 'jquery' ), '2.1.4', true );
		wp_enqueue_script( 'flexslider', get_template_directory_uri() . '/assets/js/lib/jquery.flexslider.min.js', array( 'jquery' ), '2.6.3', true );
		wp_enqueue_script( 'flickity', get_template_directory_uri() . '/assets/js/lib/flickity.pkgd.min.js', array( 'jquery' ), '2.0.5', true );

		if ( 'fancybox' === $lightbox ) {
			wp_enqueue_script( 'fancybox', get_template_directory_uri() . '/assets/js/lib/jquery.fancybox.min.js', array( 'jquery' ), '3.5.7', true );

		} elseif ( 'swipebox' === $lightbox ) {
			wp_enqueue_script( 'swipebox', get_template_directory_uri() . '/assets/js/lib/jquery.swipebox.min.js', array( 'jquery' ), '1.4.4', true );
		}
		wp_enqueue_script( 'lazyloadxt', get_template_directory_uri() . '/assets/js/lib/jquery.lazyloadxt.min.js', array( 'jquery' ), '1.1.0', true );
		wp_enqueue_script( 'sticky-kit', get_template_directory_uri() . '/assets/js/lib/sticky-kit.min.js', array( 'jquery' ), '1.1.3', true );
		wp_register_script( 'vimeo-player', get_template_directory_uri() . '/assets/js/lib/player.min.js', array(), '2.6.1', true );

		if ( slikk_is_edge() ) {
			wp_enqueue_script( 'object-fit-images', get_template_directory_uri() . '/assets/lib/ofi.min.js', array(), '3.2.3', true );
		}
		wp_register_script( 'aos', get_template_directory_uri() . '/assets/js/lib/aos.js', array( 'jquery' ), '2.3.0', true );
		wp_register_script( 'slikk-carousels', get_template_directory_uri() . '/assets/js/carousels' . $suffix . '.js', array( 'jquery' ), $version, true );
		wp_register_script( 'slikk-youtube-video-background', get_template_directory_uri() . '/assets/js/YT-background' . $suffix . '.js', array( 'jquery' ), $version, true );

		wp_register_script( 'slikk-vimeo', get_template_directory_uri() . '/assets/js/vimeo' . $suffix . '.js', array( 'jquery' ), $version, true );
		wp_enqueue_script( 'wolftheme', get_template_directory_uri() . '/assets/js/functions' . $suffix . '.js', array( 'jquery' ), $version, true );
		wp_enqueue_script( 'tooltipsy', get_template_directory_uri() . '/assets/js/lib/tooltipsy.min.js', array( 'jquery' ), '1.0.0', true );

		/*
		* Register conditional scripts
		*/
		wp_register_script( 'infinitescroll', get_template_directory_uri() . '/assets/js/lib/jquery.infinitescroll.min.js', array( 'jquery' ), '2.0.0', true );

		wp_register_script( 'slikk-loadposts', get_template_directory_uri() . '/assets/js/loadposts' . $suffix . '.js', array( 'jquery' ), $version, true );
		wp_register_script( 'imagesloaded', get_template_directory_uri() . '/assets/js/lib/imagesloaded.pkgd.min.js', array( 'jquery' ), '4.1.4', true );

		wp_register_script( 'isotope', get_template_directory_uri() . '/assets/js/lib/isotope.pkgd.min.js', array( 'jquery' ), '3.0.5', true );

		wp_register_script( 'packery-mode', get_template_directory_uri() . '/assets/js/lib/packery-mode.pkgd.min.js', array( 'jquery', 'isotope' ), '2.0.1', true );
		wp_register_script( 'flex-images', get_template_directory_uri() . '/assets/lib/jquery.flex-images.min.js', array( 'jquery' ), '1.0.4', true );

		wp_register_script( 'slikk-masonry', get_template_directory_uri() . '/assets/js/masonry' . $suffix . '.js', array( 'jquery' ), $version, true );
		wp_register_script( 'slikk-category-filter', get_template_directory_uri() . '/assets/js/category-filter' . $suffix . '.js', array( 'jquery' ), $version, true );

		wp_register_script( 'slikk-ajax-nav', get_template_directory_uri() . '/assets/js/ajax' . $suffix . '.js', array( 'jquery' ), $version, true );
		wp_register_script( 'slikk-one-page', get_template_directory_uri() . '/assets/js/one-page' . $suffix . '.js', array( 'jquery' ), $version, true );

		/**
		 * Enqueuing scripts
		 */
		wp_enqueue_script( 'flexslider' );
		wp_enqueue_script( 'jarallax' );
		if ( slikk_is_wolf_extension_activated() ) {
			wp_enqueue_script( 'bigtext' );
			wp_enqueue_script( 'wvc-bigtext' );
		}

		if ( is_search() || is_singular( 'proof_gallery' ) ) {
			wp_enqueue_script( 'imagesloaded' );
			wp_enqueue_script( 'isotope' );
			wp_enqueue_script( 'slikk-masonry' );
		}

		if ( is_singular( 'work' ) ) {
		}

		if ( is_singular( 'artist' ) ) {
			wp_enqueue_script( 'jquery-ui-tabs', true );
		}

		wp_enqueue_script( 'flickity' );
		wp_enqueue_script( 'slikk-carousels' );

		if ( slikk_do_onepage_menu() ) {
			wp_enqueue_script( 'slikk-one-page' );
		}

		/**
		 * If AJAX navigation is enabled, we enqueued everything we may need from start
		 */
		if ( slikk_do_ajax_nav() ) {
			wp_enqueue_script( 'wp-mediaelement' );
			wp_enqueue_script( 'jarallax' );
			wp_enqueue_script( 'imagesloaded' );
			wp_enqueue_script( 'isotope' );
			wp_enqueue_script( 'packery-mode' );
			wp_enqueue_script( 'infinitescroll' );
			wp_enqueue_script( 'sticky-kit' );
			wp_enqueue_script( 'slikk-masonry' );
			wp_enqueue_script( 'slikk-infinitescroll' );
			wp_enqueue_script( 'slikk-loadposts' );
			wp_enqueue_script( 'slikk-category-filter' );
			wp_enqueue_script( 'slikk-carousels' );
			if ( class_exists( 'WooCommerce' ) ) {

				wp_enqueue_script( 'wc-single-product' );
				wp_enqueue_script( 'wc-add-to-cart-variation' );
				wp_enqueue_script( 'wc-jquery-ui-touchpunch', WC()->plugin_url() . '/assets/js/jquery-ui-touch-punch/jquery-ui-touch-punch' . $suffix . '.js', array( 'jquery-ui-slider' ), WC_VERSION, true );
				wp_enqueue_script( 'wc-price-slider', WC()->plugin_url() . '/assets/js/frontend/price-slider' . $suffix . '.js', array( 'jquery-ui-slider', 'wc-jquery-ui-touchpunch' ), WC_VERSION, true );
			}

			wp_enqueue_script( 'slikk-ajax-nav' );
			wp_enqueue_script( 'slikk-one-page' );
		}
		wp_localize_script(
			'wolftheme',
			'SlikkParams',
			apply_filters(
				'slikk_js_params',
				array(
					'defaultPageLoadingAnimation'    => apply_filters( 'slikk_default_page_loading_animation', true ),
					'defaultPageTransitionAnimation' => apply_filters( 'slikk_default_page_transition_animation', true ),
					'siteUrl'                        => esc_url( site_url( '/' ) ),
					'homeUrl'                        => esc_url( home_url( '/' ) ),
					'ajaxUrl'                        => esc_url( admin_url( 'admin-ajax.php' ) ),
					'isUserLoggedIn'                 => is_user_logged_in(),
					'isMobile'                       => wp_is_mobile(),
					'isPostTypeArchive'              => slikk_is_post_type_archive(),
					'isPage'                         => is_page(),
					'themeSlug'                      => slikk_get_theme_slug(),
					'accentColor'                    => slikk_get_inherit_mod( 'accent_color', '#007acc' ),
					'breakPoint'                     => apply_filters( 'slikk_menu_breakpoint', slikk_get_inherit_mod( 'menu_breakpoint', 1100 ) ),
					'menuLayout'                     => slikk_get_inherit_mod( 'menu_layout' ),
					'menuSkin'                       => slikk_get_inherit_mod( 'menu_skin' ),
					'menuOffset'                     => apply_filters( 'slikk_menu_offset', slikk_get_inherit_mod( 'menu_offset', 0 ) ),
					'menuHoverStyle'                 => slikk_get_inherit_mod( 'menu_hover_style', 'opacity' ),
					'subMenuWidth'                   => apply_filters( 'slikk_submenu_width', 230 ),
					'stickyMenuType'                 => slikk_get_inherit_mod( 'menu_sticky_type', 'soft' ),
					'stickyMenuScrollPoint'          => apply_filters( 'slikk_sticky_menu_scrollpoint', 0 ), // ??
					'stickyMenuHeight'               => apply_filters( 'slikk_sticky_menu_height', 60 ),
					'desktopMenuHeight'              => apply_filters( 'slikk_desktop_menu_height', 80 ),

					'mobileScreenBreakpoint'         => apply_filters( 'slikk_mobile_screen_breakpoint', 499 ),
					'tabletScreenBreakpoint'         => apply_filters( 'slikk_tablet_screen_breakpoint', 768 ),
					'notebookScreenBreakpoint'       => apply_filters( 'slikk_notebook_screen_breakpoint', 1024 ),
					'desktopScreenBreakpoint'        => apply_filters( 'slikk_desktop_screen_breakpoint', 1224 ),
					'desktopBigScreenBreakpoint'     => apply_filters( 'slikk_desktop_big_screen_breakpoint', 1690 ),

					'isWolfCore'                     => class_exists( 'Wolf_Core' ),
					'pageBuilder'                    => slikk_get_plugin_in_use(),

					'lightbox'                       => apply_filters( 'slikk_lightbox', slikk_get_inherit_mod( 'lightbox', 'fancybox' ) ),
					'WOWAnimationOffset'             => apply_filters( 'slikk_wow_animation_offset', 0 ),
					'fullPageAnimation'              => slikk_do_fullpage(),
					'forceAnimationMobile'           => apply_filters( 'slikk_force_animation_mobile', false ),
					'parallaxNoIos'                  => apply_filters( 'slikk_parallax_no_ios', true ),
					'parallaxNoAndroid'              => apply_filters( 'slikk_parallax_no_android', true ),
					'parallaxNoSmallScreen'          => apply_filters( 'slikk_parallax_no_small_screen', true ),
					'portfolioSidebarOffsetTop'      => ( 'soft' === slikk_get_inherit_mod( 'menu_sticky_type', 'soft' ) || 'hard' === slikk_get_inherit_mod( 'menu_sticky_type', 'soft' ) ) ? apply_filters( 'slikk_sticky_menu_height', 60 ) : 0,
					'isWooCommerce'                  => function_exists( 'WC' ),
					'WooCommerceCartUrl'             => ( function_exists( 'wc_get_cart_url' ) ) ? wc_get_cart_url() : '',
					'WooCommerceCheckoutUrl'         => ( function_exists( 'wc_get_checkout_url' ) ) ? wc_get_checkout_url() : '',
					'WooCommerceAccountUrl'          => ( function_exists( 'WC' ) ) ? get_permalink( get_option( 'woocommerce_myaccount_page_id' ) ) : '',
					'isWooCommerceVariationSwatches' => defined( 'TAWC_VS_PLUGIN_FILE' ),
					'relatedProductCount'            => apply_filters( 'slikk_related_products_count', 4 ),
					'doWoocommerceLightbox'          => ( 'no' === get_option( 'woocommerce_enable_lightbox' ) ),
					'doVideoLightbox'                => ( 'yes' === slikk_get_inherit_mod( 'videos_lightbox' ) ),
					'doLiveSearch'                   => apply_filters( 'slikk_live_search', true ),
					'doLoadMorePaginationHashChange' => apply_filters( 'slikk_loadmore_pagination_hashchange', true ),
					'smoothScrollSpeed'              => apply_filters( 'slikk_smooth_scroll_speed', 1000 ),
					'smoothScrollEase'               => apply_filters( 'slikk_smooth_scroll_ease', 'swing' ),
					'infiniteScrollEmptyLoad'        => get_template_directory_uri() . '/assets/img/blank.gif',
					'infiniteScrollGif'              => apply_filters( 'slikk_infinite_scroll_loading_gif_url', get_template_directory_uri() . '/assets/img/loading.gif' ),
					'isCustomizer'                   => slikk_is_customizer(),
					'isAjaxNav'                      => slikk_do_ajax_nav(),
					'ajaxNavigateToggleClass'        => apply_filters(
						'slikk_ajax_navigate_toggle_class',
						array(
							'mobile-menu-toggle',
							'side-panel-toggle',
							'search-form-toggle',
							'overlay-menu-toggle',
							'offcanvas-menu-toggle',
							'lateral-menu-toggle',
						)
					),
					'pageLoadingAnimationType'       => slikk_get_inherit_mod( 'loading_animation_type', 'none' ),
					'hasLoadingOverlay'              => apply_filters( 'slikk_display_overlay', 'none' !== slikk_get_inherit_mod( 'loading_animation_type', 'none' ) ),
					'pageLoadedDelay'                => apply_filters( 'slikk_page_loaded_delay', 1000 ),
					'pageTransitionDelayBefore'      => apply_filters( 'slikk_page_transition_delay_before', 0 ),
					'pageTransitionDelayAfter'       => apply_filters( 'slikk_page_transition_delay_after', 0 ),
					'mediaelementLegacyCssUri'       => includes_url( 'js/mediaelement/mediaelementplayer-legacy.min.css' ),
					'fancyboxMediaelementCssUri'     => get_template_directory_uri() . '/assets/css/fancybox-mediaelement' . esc_attr( $suffix ) . '.css',
					'fancyboxSettings'               => apply_filters(
						'slikk_fancybox_settings',
						array(
							'loop'             => true,
							'transitionEffect' => 'slide',
							'wheel'            => false,
							'hideScrollbar'    => false,
							'buttons'          => array(
								'slideShow',
								'fullScreen',
								'thumbs',
								'close',
							),
						)
					),
					'entrySliderAnimation'           => apply_filters( 'slikk_entry_slider_animation', 'fade' ),
					'is404'                          => is_404(),
					'isUserLoggedIn'                 => is_user_logged_in(),
					'allowedMimeTypes'               => array_keys( get_allowed_mime_types() ),
					'logoMarkup'                     => slikk_logo( false ),
					'language'                       => get_locale(),
					'l10n'                           => array(
						'chooseImage'               => esc_html__( 'Choose an image', 'slikk' ),
						'useImage'                  => esc_html__( 'Use image', 'slikk' ),
						'replyTitle'                => esc_html__( 'Post a comment', 'slikk' ),
						'editPost'                  => esc_html__( 'Edit Post', 'slikk' ),
						'infiniteScrollMsg'         => esc_html__( 'Loading', 'slikk' ) . '<span class="load-more-hellip">.</span><span class="load-more-hellip">.</span><span class="load-more-hellip">.</span>',
						'infiniteScrollEndMsg'      => esc_html__( 'No more post to load', 'slikk' ),
						'loadMoreMsg'               => apply_filters( 'slikk_load_more_posts_text', esc_html__( 'Load More', 'slikk' ) ),
						'infiniteScrollDisabledMsg' => esc_html__( 'The infinitescroll is disabled in live preview mode', 'slikk' ),
						'addToCart'                 => esc_html__( 'Add to cart', 'slikk' ),
						'viewCart'                  => esc_html__( 'View cart', 'slikk' ),
						'addedToCart'               => esc_html__( 'Added to cart', 'slikk' ),
						'playText'                  => esc_html__( 'Play', 'slikk' ),
						'pauseText'                 => esc_html__( 'Pause', 'slikk' ),
					),
				)
			)
		);
		if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
			wp_enqueue_script( 'comment-reply' );
		}
	}
	add_action( 'wp_enqueue_scripts', 'slikk_enqueue_scripts' );
} // end function check

/**
 * Force WWPBPBE to enqueue all scripts for AJAX
 *
 * Wolf WPBakery Page Builder Extension enqueue scripts conditionally. We need all scripts from start for AJAX navigation.
 * We set the wvc_force_enqueue_scripts filter to true right here if AJAX nav is enabled
 */
function slikk_wvc_force_enqueue_scripts() {

	if ( slikk_do_ajax_nav() ) {
		return true;
	}
}
add_filter( 'wvc_force_enqueue_scripts', 'slikk_wvc_force_enqueue_scripts' );

/**
 * Remove CSS and/or JS for Select2 used by WooCommerce.
 *
 * @link https://gist.github.com/Willem-Siebe/c6d798ccba249d5bf080.
 */
function slikk_dequeue_stylesandscripts_select2() {
	if ( class_exists( 'WooCommerce' ) && wp_is_mobile() ) {
		wp_dequeue_style( 'selectWoo' );
		wp_deregister_style( 'selectWoo' );

		wp_dequeue_script( 'selectWoo' );
		wp_deregister_script( 'selectWoo' );
	}
}
add_action( 'wp_enqueue_scripts', 'slikk_dequeue_stylesandscripts_select2', 100 );
