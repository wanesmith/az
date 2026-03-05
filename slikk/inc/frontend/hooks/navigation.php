<?php
/**
 * Slikk Navigation hook functions
 *
 * @package WordPress
 * @subpackage Slikk
 * @version 1.4.2
 */

defined( 'ABSPATH' ) || exit;

/**
 * Output the main menu in the header
 */
function slikk_output_main_navigation() {

	if ( 'none' === slikk_get_inherit_mod( 'menu_layout', 'top-right' ) ) {
		return;
	}

	$desktop_menu_layout = slikk_get_inherit_mod( 'menu_layout', 'top-right' );
	$mobile_menu_layout  = apply_filters( 'slikk_mobile_menu_template', 'content-mobile' ); // WPCS XSS ok.
	?>
	<div id="desktop-navigation" class="clearfix">
		<?php
			/**
			 * Desktop Navigation
			 */
			get_template_part( slikk_get_template_dirname() . '/components/navigation/content', $desktop_menu_layout );

			/**
			 * Search form
			 */
			slikk_nav_search_form();
		?>
	</div><!-- #desktop-navigation -->

	<div id="mobile-navigation">
		<?php
			/**
			 * Mobile Navigation
			 */
			get_template_part( slikk_get_template_dirname() . '/components/navigation/' . $mobile_menu_layout );

			/**
			 * Search form
			 */
			slikk_nav_search_form( 'mobile' );
		?>
	</div><!-- #mobile-navigation -->
	<?php
}
add_action( 'slikk_main_navigation', 'slikk_output_main_navigation' );

/**
 * Output hamburger
 */
function slikk_output_sidepanel_hamburger() {
	?>
	<div class="hamburger-container hamburger-container-side-panel">
		<?php
			/**
			 * Menu hamburger icon
			 */
			slikk_hamburger_icon( 'toggle-side-panel' );
		?>
	</div><!-- .hamburger-container -->
	<?php
}
add_action( 'slikk_sidepanel_hamburger', 'slikk_output_sidepanel_hamburger' );

/**
 * Secondary navigation hook
 *
 * Display cart icons, social icons or secondary menu depending on cuzstimizer option
 *
 * @param string $context desktop or mobile.
 * @return void
 */
function slikk_output_complementary_menu( $context = 'desktop' ) {

	$cta_content = slikk_get_inherit_mod( 'menu_cta_content_type', 'none' );

	/**
	 * Force shop icons on woocommerce pages
	 */
	$is_wc_page_child = is_page() && wp_get_post_parent_id( get_the_ID() ) == slikk_get_woocommerce_shop_page_id() && slikk_get_woocommerce_shop_page_id(); // phpcs:ignore
	$is_wc            = slikk_is_woocommerce_page() || is_singular( 'product' ) || $is_wc_page_child;

	if ( apply_filters( 'slikk_force_display_nav_shop_icons', $is_wc ) ) { // Can be disable just in case.
		$cta_content = 'shop_icons';
	}

	/**
	 * If shop icons are set on discography page, apply on all release pages
	 */
	$is_disco_page_child = is_page() && wp_get_post_parent_id( get_the_ID() ) == slikk_get_discography_page_id() && slikk_get_discography_page_id();
	$is_disco_page       = is_page( slikk_get_discography_page_id() ) || is_singular( 'release' ) || $is_disco_page_child;

	if ( $is_disco_page && get_post_meta( slikk_get_discography_page_id(), '_post_menu_cta_content_type', true ) ) {
		$cta_content = get_post_meta( slikk_get_discography_page_id(), '_post_menu_cta_content_type', true );
	}

	/**
	 * If shop icons are set on events page, apply on all event pages
	 */
	$is_events_page_child = is_page() && wp_get_post_parent_id( get_the_ID() ) == slikk_get_events_page_id() && slikk_get_events_page_id();
	$is_events_page       = is_page( slikk_get_events_page_id() ) || is_singular( 'event' ) || $is_events_page_child;

	if ( $is_events_page && get_post_meta( slikk_get_events_page_id(), '_post_menu_cta_content_type', true ) ) {
		$cta_content = get_post_meta( slikk_get_events_page_id(), '_post_menu_cta_content_type', true );
	}
	?>
	<?php if ( 'shop_icons' === $cta_content && 'desktop' === $context ) { ?>
		<?php if ( slikk_display_shop_search_menu_item() ) : ?>
				<div class="search-container cta-item">
					<?php
						/**
						 * Search
						 */
						echo slikk_search_menu_item(); // WPCS XSS ok.
					?>
				</div><!-- .search-container -->
			<?php endif; ?>
			<?php if ( slikk_display_account_menu_item() ) : ?>
				<div class="account-container cta-item">
					<?php
						/**
						 * Account icon
						 */
						slikk_account_menu_item();
					?>
				</div><!-- .cart-container -->
			<?php endif; ?>
			<?php if ( slikk_display_wishlist_menu_item() ) : ?>
				<div class="wishlist-container cta-item">
					<?php
						/**
						 * Wishlist icon
						 */
						slikk_wishlist_menu_item();
					?>
				</div><!-- .cart-container -->
			<?php endif; ?>
			<?php if ( slikk_display_cart_menu_item() ) : ?>
				<div class="cart-container cta-item">
					<?php
						/**
						 * Cart icon
						 */
						slikk_cart_menu_item();

						/**
						 * Cart panel
						 */
						echo slikk_cart_panel(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped,Generic.Files.EndFileNewline.NotFound
					?>
				</div><!-- .cart-container -->
			<?php endif; ?>

	<?php } elseif ( 'search_icon' === $cta_content && 'desktop' === $context ) { ?>

		<div class="search-container cta-item">
			<?php
				/**
				 * Search
				 */
				echo slikk_kses( slikk_search_menu_item() );
			?>
		</div><!-- .search-container -->

		<?php
	} elseif ( 'socials' === $cta_content ) {

		if ( slikk_is_wolf_extension_activated() && ( function_exists( 'wvc_socials' ) || function_exists( 'wolf_core_get_socials' ) ) ) {

			if ( function_exists( 'wolf_core_social_icons' ) ) {

				echo wolf_core_social_icons( array( 'services' => slikk_get_inherit_mod( 'menu_socials', 'facebook,twitter,instagram' ) ) );

			} elseif ( function_exists( 'wvc_socials' ) ) {

				echo wvc_socials( array( 'services' => slikk_get_inherit_mod( 'menu_socials', 'facebook,twitter,instagram' ) ) );
			}
		}
	} elseif ( 'secondary-menu' === $cta_content && 'desktop' === $context ) {

		slikk_secondary_desktop_navigation();

	} elseif ( 'wpml' === $cta_content && 'desktop' === $context ) {

		do_action( 'wpml_add_language_selector' ); // phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals

	} elseif ( 'custom' === $cta_content && 'desktop' === $context ) {

		do_action( 'slikk_custom_menu_cta_content' );

	} // end type
}
add_action( 'slikk_secondary_menu', 'slikk_output_complementary_menu', 10, 1 );

/**
 * Add side panel
 */
function slikk_side_panel() {

	if ( slikk_can_display_sidepanel() ) {
		get_template_part( slikk_get_template_dirname() . '/components/layout/sidepanel' );
	}
}
add_action( 'slikk_body_start', 'slikk_side_panel' );

/**
 * Overwrite sidepanel position for non-top menu
 *
 * @param string $position the side panel position.
 * @return string
 */
function slikk_overwrite_side_panel_position( $position ) {

	$menu_layout = slikk_get_inherit_mod( 'menu_layout', 'top-right' );

	if ( $position && 'overlay' === $menu_layout ) {
		$position = 'left';
	}

	return $position;
}
add_action( 'slikk_side_panel_position', 'slikk_overwrite_side_panel_position' );

/**
 * Off Canvas menus
 */
function slikk_offcanvas_menu() {

	if ( 'offcanvas' !== slikk_get_inherit_mod( 'menu_layout' ) ) {
		return;
	}
	?>
	<div class="offcanvas-menu-panel">
		<?php
			/* Off-Canvas Menu Panel start hook */
			do_action( 'slikk_offcanvas_menu_start' );
		?>
		<div class="offcanvas-menu-panel-inner">
			<?php
			/**
			 * Menu
			 */
			slikk_primary_vertical_navigation();
			?>
		</div><!-- .offcanvas-menu-panel-inner -->
	</div><!-- .offcanvas-menu-panel -->
	<?php
}
add_action( 'slikk_body_start', 'slikk_offcanvas_menu' );

/**
 * Infinite scroll pagination
 *
 * @param object $query The WP Query.
 * @param array  $pagination_args The pagination arguments.
 */
function slikk_output_pagination( $query = null, $pagination_args = array() ) {

	if ( ! $query ) {
		global $wp_query;
		$main_query = $wp_query;
		$query      = $wp_query;
	}

	$pagination_args = extract(
		wp_parse_args(
			$pagination_args,
			array(
				'post_type'                => 'post',
				'pagination_type'          => '',
				'product_category_link_id' => '',
				'video_category_link_id'   => '',
				'paged'                    => 1,
				'container_id'             => '',
			)
		)
	);

	$max = $query->max_num_pages;

	$pagination_type = ( $pagination_type ) ? $pagination_type : apply_filters( 'slikk_post_pagination', slikk_get_theme_mod( 'post_pagination' ) );

	$button_class = apply_filters( 'slikk_loadmore_button_class', 'button', $pagination_type );

	$container_class = apply_filters( 'slikk_loadmore_container_class', 'trigger-container wvc-element' );

	if ( 'link_to_blog' === $pagination_type ) {

		?>
		<div class="<?php echo slikk_sanitize_html_classes( $container_class ); ?>">
			<a class="<?php echo esc_attr( $button_class ); ?>" data-aos="fade" data-aos-once="true" href="<?php echo esc_url( slikk_get_blog_url() ); ?>"><?php echo esc_attr( apply_filters( 'slikk_view_more_posts_text', esc_html__( 'View more posts', 'slikk' ) ) ); ?></a>
		</div>
		<?php

	} elseif ( 'link_to_shop' === $pagination_type ) {

		?>
		<div class="<?php echo slikk_sanitize_html_classes( $container_class ); ?>">
			<a class="<?php echo esc_attr( $button_class ); ?>" data-aos="fade" data-aos-once="true" href="<?php echo esc_url( slikk_get_shop_url() ); ?>"><?php echo esc_attr( apply_filters( 'slikk_view_more_products_text', esc_html__( 'View more products', 'slikk' ) ) ); ?></a>
		</div>
		<?php

	} elseif ( 'link_to_shop_category' === $pagination_type && $product_category_link_id ) {
		$cat_url = get_category_link( $product_category_link_id );
		?>
		<div class="<?php echo slikk_sanitize_html_classes( $container_class ); ?>">
			<a class="<?php echo esc_attr( $button_class ); ?>" data-aos="fade" data-aos-once="true" href="<?php echo esc_url( $cat_url ); ?>"><?php echo apply_filters( 'slikk_view_more_products_text', esc_html__( 'View more products', 'slikk' ) ); ?></a>
		</div>
		<?php

	} elseif ( 'link_to_portfolio' === $pagination_type ) {

		?>
		<div class="<?php echo slikk_sanitize_html_classes( $container_class ); ?>">
			<a class="<?php echo esc_attr( $button_class ); ?>" data-aos="fade" data-aos-once="true" href="<?php echo slikk_get_portfolio_url(); ?>"><?php echo apply_filters( 'slikk_view_more_works_text', esc_html__( 'View more works', 'slikk' ) ); ?></a>
		</div>
		<?php

	} elseif ( 'link_to_events' === $pagination_type ) {

		?>
		<div class="<?php echo slikk_sanitize_html_classes( $container_class ); ?>">
			<a class="<?php echo esc_attr( $button_class ); ?>" data-aos="fade" data-aos-once="true" href="<?php echo slikk_get_events_url(); ?>"><?php echo apply_filters( 'slikk_view_more_events_text', esc_html__( 'View more events', 'slikk' ) ); ?></a>
		</div>
		<?php

	} elseif ( 'link_to_videos' === $pagination_type ) {

		?>
		<div class="<?php echo slikk_sanitize_html_classes( $container_class ); ?>">
			<a class="<?php echo esc_attr( $button_class ); ?>" data-aos="fade" data-aos-once="true" href="<?php echo slikk_get_videos_url(); ?>"><?php echo apply_filters( 'slikk_view_more_videos_text', esc_html__( 'View more videos', 'slikk' ) ); ?></a>
		</div>
		<?php

	} elseif ( 'link_to_video_category' === $pagination_type && $video_category_link_id ) {
		$cat_url = get_category_link( $video_category_link_id );
		?>
		<div class="<?php echo slikk_sanitize_html_classes( $container_class ); ?>">
			<a class="<?php echo esc_attr( $button_class ); ?>" data-aos="fade" data-aos-once="true" href="<?php echo esc_url( $cat_url ); ?>"><?php echo apply_filters( 'slikk_view_more_products_text', esc_html__( 'View more products', 'slikk' ) ); ?></a>
		</div>
		<?php

	} elseif ( 'link_to_artists' === $pagination_type ) {

		?>
		<div class="<?php echo slikk_sanitize_html_classes( $container_class ); ?>">
			<a class="<?php echo esc_attr( $button_class ); ?>" data-aos="fade" data-aos-once="true" href="<?php echo wolf_artists_get_page_link(); ?>"><?php echo apply_filters( 'slikk_view_more_artists_text', esc_html__( 'View more artists', 'slikk' ) ); ?></a>
		</div>
		<?php

	} elseif ( 'link_to_albums' === $pagination_type ) {
		?>
		<div class="<?php echo slikk_sanitize_html_classes( $container_class ); ?>">
			<a class="<?php echo esc_attr( $button_class ); ?>" data-aos="fade" data-aos-once="true" href="<?php echo slikk_get_albums_url(); ?>"><?php echo apply_filters( 'slikk_view_more_albums_text', esc_html__( 'View more albums', 'slikk' ) ); ?></a>
		</div>
		<?php

	} elseif ( 'link_to_discography' === $pagination_type ) {
		?>
		<div class="<?php echo slikk_sanitize_html_classes( $container_class ); ?>">
			<a class="<?php echo esc_attr( $button_class ); ?>" data-aos="fade" data-aos-once="true" href="<?php echo slikk_get_discography_url(); ?>"><?php echo apply_filters( 'slikk_view_more_releases_text', esc_html__( 'View more releases', 'slikk' ) ); ?></a>
		</div>
		<?php

	} elseif ( 'link_to_attachments' === $pagination_type && function_exists( 'slikk_get_photos_url' ) && slikk_get_photos_url() ) {
		?>
		<div class="<?php echo slikk_sanitize_html_classes( $container_class ); ?>">
			<a class="<?php echo esc_attr( $button_class ); ?>" data-aos="fade" data-aos-once="true" href="<?php echo slikk_get_photos_url(); ?>"><?php echo apply_filters( 'slikk_view_more_albums_text', esc_html__( 'View more photos', 'slikk' ) ); ?></a>
		</div>
		<?php

	} elseif ( 'load_more' === $pagination_type ) {

		wp_enqueue_script( 'slikk-loadposts' );

		$next_page = $paged + 1;

		$next_page_href = get_pagenum_link( $next_page );
		?>
		<?php if ( 1 < $max && $next_page <= $max ) : ?>
			<div class="<?php echo slikk_sanitize_html_classes( $container_class ); ?>">
				<a data-current-page="1" data-next-page="<?php echo absint( $next_page ); ?>" data-max-pages="<?php echo absint( $max ); ?>" class="<?php echo esc_attr( $button_class ); ?> loadmore-button" data-current-url="<?php echo slikk_get_current_url(); ?>" href="<?php echo esc_url( $next_page_href ); ?>"><span><?php echo apply_filters( 'slikk_load_more_posts_text', esc_html__( 'Load More', 'slikk' ) ); ?></span></a>
			</div><!-- .trigger-containe -->
		<?php endif; ?>
		<?php

	} elseif ( 'infinitescroll' === $pagination_type ) {

		if ( 'attachment' === $post_type ) {
			slikk_paging_nav( $query );
		}
	} elseif ( 'none' !== $pagination_type && ( 'numbers' === $pagination_type || 'standard_pagination' === $pagination_type ) ) {

		/**
		 * Pagination numbers
		 */
		if ( ! slikk_is_home_as_blog() ) {
			$GLOBALS['wp_query']->max_num_pages       = $max; // overwrite max_num_pages with custom query
			$GLOBALS['wp_query']->query_vars['paged'] = $paged;
		}

		the_posts_pagination(
			apply_filters(
				'slikk_the_post_pagination_args',
				array(
					'prev_text' => '<i class="pagination-icon-prev"></i>',
					'next_text' => '<i class="pagination-icon-next"></i>',
				)
			)
		);
	}
}
add_action( 'slikk_pagination', 'slikk_output_pagination', 10, 3 );
