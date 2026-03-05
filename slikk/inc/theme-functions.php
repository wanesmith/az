<?php
/**
 * Slikk frontend theme specific functions
 *
 * @package WordPress
 * @subpackage Slikk
 * @version 1.4.2
 */

defined( 'ABSPATH' ) || exit;

/**
 * Add custom fonts
 *
 * @param  array $google_fonts array of Google fonts.
 * @return array
 */
function slikk_add_google_font( $google_fonts ) {

	$default_fonts = array(
		'Lato'             => 'Lato:400,700,900',
		'Oswald'           => 'Oswald:400,500,600,700,800',
		'Playfair Display' => 'Playfair+Display:400,700',
	);

	foreach ( $default_fonts as $key => $value ) {
		if ( ! isset( $google_fonts[ $key ] ) ) {
			$google_fonts[ $key ] = $value;
		}
	}

	return $google_fonts;
}
add_filter( 'slikk_google_fonts', 'slikk_add_google_font' );

/**
 * Overwrite standard post entry slider image size
 */
function slikk_overwrite_entry_slider_img_size( $size ) {

	add_filter(
		'slikk_entry_slider_image_size',
		function() {
			return '847x508';
		}
	);
}
add_action( 'after_setup_theme', 'slikk_overwrite_entry_slider_img_size', 50 );

/**
 * Add custom elements to theme
 *
 * @param array $elements Available page builder elements.
 * @return  array
 */
function slikk_add_available_wvc_elements( $elements ) {

	// $elements[] = 'text-slider';

	if ( class_exists( 'WooCommerce' ) ) {
		$elements[] = 'login-form';
		$elements[] = 'product-presentation';
	}

	return $elements;
}
add_filter( 'wvc_element_list', 'slikk_add_available_wvc_elements', 44 );

/**
 * Disable default loading and transition animation
 *
 * @param  bool $bool enable/disable default loading animation.
 * @return bool
 */
function slikk_reset_loading_anim( $bool ) {
	return false;
}
// add_filter( 'slikk_display_loading_logo', 'slikk_reset_loading_anim' );
// add_filter( 'slikk_display_loading_overlay', 'slikk_reset_loading_anim' );
// add_filter( 'slikk_default_page_loading_animation', 'slikk_reset_loading_anim' );
// add_filter( 'slikk_default_page_transition_animation', 'slikk_reset_loading_anim' );

/**
 * Loading title markup
 */
function slikk_loading_animation_markup() {

	if ( 'none' !== slikk_get_inherit_mod( 'loading_animation_type', 'overlay' ) ) :
		?>
	<div class="slikk-loader-overlay">
		<div class="slikk-loader">
			<?php if ( 'slikk' === slikk_get_inherit_mod( 'loading_animation_type', 'overlay' ) ) : ?>
				<div id="slikk-percent">0%</div>
			<?php endif; ?>
		</div>
	</div>
		<?php
	endif;
}
// add_action( 'slikk_body_start', 'slikk_loading_animation_markup', 0 );

/**
 * Spinners folder
 */
add_filter(
	'slikk_spinners_folder',
	function() {
		return slikk_get_template_dirname() . '/components/spinners/';
	}
);

/**
 * Add lateral menu for the vertical bar
 *
 * @param array $menus Available menus.
 * @return array
 */
function slikk_add_lateral_menu( $menus ) {

	$menus['vertical'] = esc_html__( 'Vertical Menu (optional)', 'slikk' );

	return $menus;

}
add_filter( 'slikk_menus', 'slikk_add_lateral_menu' );

/**
 * Login popup markup
 */
function slikk_login_form_markup() {
	if ( function_exists( 'wvc_login_form' ) && class_exists( 'WooCommerce' ) ) {
		?>
		<div id="loginform-overlay">
			<div id="loginform-overlay-inner">
				<div id="loginform-overlay-content" class="wvc-font-dark">
					<a href="#" id="close-vertical-bar-menu-icon" class="close-panel-button close-loginform-button">X</a>
					<?php // echo wvc_login_form(); ?>
				</div>
			</div>
		</div>
		<?php
	}
}
add_action( 'slikk_body_start', 'slikk_login_form_markup', 5 );

/**
 * Get available display options for posts
 *
 * @return array
 */
function slikk_set_post_display_options() {

	return array(
		'standard'     => esc_html__( 'Standard', 'slikk' ),
		// 'grid_square' => esc_html__( 'Modern Square Grid', 'slikk' ),
		'grid_classic' => esc_html__( 'Simple Grid', 'slikk' ),
		'metro'        => esc_html__( 'Metro', 'slikk' ),
	);
}
add_filter( 'slikk_post_display_options', 'slikk_set_post_display_options' );

/**
 * Set default metro thumbnail size dimension
 */
function slikk_set_metro_thumbnail_sizes( $size ) {
	add_image_size( 'slikk-metro', 550, 702 );
}
// add_action( 'after_setup_theme', 'slikk_set_metro_thumbnail_sizes', 44 );

/**
 * Returns large
 */
function slikk_set_large_metro_thumbnail_size() {
	return 'large';
}

/**
 * Filter metro thumnail size depending on row context
 */
function slikk_optimize_metro_thumbnail_size( $atts ) {

	$column_type   = isset( $atts['column_type'] ) ? $atts['column_type'] : null;
	$content_width = isset( $atts['content_width'] ) ? $atts['content_width'] : null;

	if ( 'column' === $column_type ) {
		if ( 'full' === $content_width || 'large' === $content_width ) {
			add_filter( 'slikk_metro_thumbnail_size_name', 'slikk_set_large_metro_thumbnail_size' );
		}
	}
}
add_action( 'wvc_add_row_filters', 'slikk_optimize_metro_thumbnail_size', 10, 1 );

/* Remove metro thumbnail size filter */
add_action(
	'wvc_remove_row_filters',
	function() {
		remove_filter( 'slikk_metro_thumbnail_size_name', 'slikk_set_large_metro_thumbnail_size' );
	}
);

/**
 * Get available display options for pages
 *
 * @return array
 */
function slikk_set_page_display_options() {

	return array(
		'grid_overlay' => esc_html__( 'Image Grid', 'slikk' ),
		'masonry'      => esc_html__( 'Masonry', 'slikk' ),
	);
}
add_filter( 'slikk_page_display_options', 'slikk_set_page_display_options' );

/**
 * Get available display options for works
 *
 * @return array
 */
function slikk_set_work_display_options() {

	return array(
		'grid'    => esc_html__( 'Grid', 'slikk' ),
		'masonry' => esc_html__( 'Masonry', 'slikk' ),
		// 'text-background' => esc_html__( 'Text Background', 'slikk' ),
	);
}
add_filter( 'slikk_work_display_options', 'slikk_set_work_display_options' );

/**
 * Set portfolio template folder
 */
function slikk_set_portfolio_template_url( $template_url ) {

	return slikk_get_template_url() . '/portfolio/';
}
add_filter( 'wolf_portfolio_template_url', 'slikk_set_portfolio_template_url' );

/**
 * Set mobile menu template
 *
 * @param string $string Mobile menu template slug.
 * @return string
 */
function slikk_set_mobile_menu_template( $string ) {

	return 'content-mobile-alt';
}
add_filter( 'slikk_mobile_menu_template', 'slikk_set_mobile_menu_template' );

/**
 * Add mobile closer overlay
 */
function slikk_add_mobile_panel_closer_overlay() {
	?>
	<div id="mobile-panel-closer-overlay" class="panel-closer-overlay toggle-mobile-menu"></div>
	<?php
}
add_action( 'slikk_main_content_start', 'slikk_add_mobile_panel_closer_overlay' );

/**
 * Off mobile menu
 */
function slikk_mobile_alt_menu() {
	?>
	<div id="mobile-menu-panel">
		<a href="#" id="close-mobile-menu-icon" class="close-panel-button toggle-mobile-menu">X</a>
		<div id="mobile-menu-panel-inner">
		<?php
			/**
			 * Menu
			 */
			slikk_primary_mobile_navigation();
		?>
		</div><!-- .mobile-menu-panel-inner -->
	</div><!-- #mobile-menu-panel -->
	<?php
}
add_action( 'slikk_body_start', 'slikk_mobile_alt_menu' );

/**
 * Add panel closer icon
 */
function slikk_add_side_panel_close_button() {
	?>
	<a href="#" id="close-side-panel-icon" class="close-panel-button toggle-side-panel">X</a>
	<?php
}
add_action( 'slikk_sidepanel_start', 'slikk_add_side_panel_close_button' );

/**
 * Add offcanvas menu closer icon
 */
function slikk_add_offcanvas_menu_close_button() {
	?>
	<a href="#" id="close-side-panel-icon" class="close-panel-button toggle-offcanvas-menu">X</a>
	<?php
}
add_action( 'slikk_offcanvas_menu_start', 'slikk_add_offcanvas_menu_close_button' );

/**
 * Secondary navigation hook
 *
 * Display cart icons, social icons or secondary menu depending on cuzstimizer option
 */
function slikk_output_mobile_complementary_menu( $context = 'desktop' ) {
	if ( 'mobile' === $context ) {
		$cta_content = slikk_get_inherit_mod( 'menu_cta_content_type', 'none' );

		/**
		 * Force shop icons on woocommerce pages
		 */
		$is_wc_page_child = is_page() && wp_get_post_parent_id( get_the_ID() ) == slikk_get_woocommerce_shop_page_id() && slikk_get_woocommerce_shop_page_id(); // phpcs:ignore
		$is_wc            = slikk_is_woocommerce_page() || is_singular( 'product' ) || $is_wc_page_child;

		if ( apply_filters( 'slikk_force_display_nav_shop_icons', $is_wc ) ) { // can be disable just in case.
			$cta_content = 'shop_icons';
		}

		if ( 'shop_icons' === $cta_content ) {
			?>
			<div class="search-container cta-item">
					<?php
						/**
						 * Search
						 */
						echo slikk_search_menu_item(); // WPCS XSS ok.
					?>
				</div><!-- .search-container -->
			<?php
			if ( slikk_display_account_menu_item() ) :
				?>
				<div class="account-container cta-item">
					<?php
						/**
						 * Account icon
						 */
						slikk_account_menu_item();
					?>
				</div><!-- .cart-container -->
				<?php
			endif;
			if ( slikk_display_cart_menu_item() ) {
				?>
				<div class="cart-container cta-item">
					<?php
						/**
						 * Cart icon
						 */
						slikk_cart_menu_item();
					?>
				</div><!-- .cart-container -->
				<?php
			}
		}
	}
}
add_action( 'slikk_secondary_menu', 'slikk_output_mobile_complementary_menu', 10, 1 );

/**
 * Add currency switcher
 */
function slikk_output_currency_switcher() {

	$cta_content = slikk_get_inherit_mod( 'menu_cta_content_type', 'none' );

	$is_wc_page_child = is_page() && wp_get_post_parent_id( get_the_ID() ) == slikk_get_woocommerce_shop_page_id() && slikk_get_woocommerce_shop_page_id(); // phpcs:ignore
	$is_wc            = slikk_is_woocommerce_page() || is_singular( 'product' ) || $is_wc_page_child;

	if ( apply_filters( 'slikk_force_display_nav_shop_icons', $is_wc ) ) { // can be disable just in case.
		$cta_content = 'shop_icons';
	}

	if ( 'shop_icons' === $cta_content && slikk_get_inherit_mod( 'currency_switcher' ) ) {

		if ( function_exists( 'wwcs_currency_switcher' ) ) {
			echo '<div class="cta-item currency-switcher">';
			wwcs_currency_switcher();
			echo '</div>';
		} elseif ( defined( 'WOOCS_VERSION' ) ) {
			echo '<div class="cta-item currency-switcher">';
			echo do_shortcode( '[woocs style=1]' );
			echo '</div>';
		}
	}
}
add_action( 'slikk_secondary_menu', 'slikk_output_currency_switcher', 100 );

/**
 * Default product loop layout
 */
add_filter(
	'slikk_product_loop_container_class',
	function( $class ) {

		$class = $class . ' product-layout-' . slikk_get_theme_mod( 'product_loop_layout', 'standard' );

		if ( function_exists( 'is_cart' ) && is_cart() ) {
			$class = 'products list clearfix';
		}

		return $class;
	},
	99
);

add_filter(
	'slikk_mod_product_display',
	function( $layout ) {

		if ( function_exists( 'is_cart' ) && is_cart() ) {
			$layout = 'cart';
		}

		return $layout;
	},
	99
);

/**
 * Side Panel font class
 */
function slikk_set_side_panel_class( $class ) {

	if ( slikk_get_theme_mod( 'side_panel_bg_img' ) ) {
		$class .= ' wvc-font-light';
	}

	return $class;
}
add_filter( 'slikk_side_panel_class', 'slikk_set_side_panel_class' );

/**
 * Overwrite hamburger icon
 */
function slikk_set_hamburger_icon( $html, $class, $title_attr ) {

	$title_attr = esc_html__( 'Menu', 'slikk' );

	ob_start();
	?>
	<a class="hamburger-icon <?php echo esc_attr( $class ); ?>" href="#" title="<?php echo esc_attr( $title_attr ); ?>">
		<span class="line line-first"></span>
		<span class="line line-second"></span>
		<span class="line line-third"></span>
		<span class="cross">
			<span></span>
			<span></span>
		</span>
	</a>
	<?php
	$html = ob_get_clean();

	return $html;

}
add_filter( 'slikk_hamburger_icon', 'slikk_set_hamburger_icon', 10, 3 );

/**
 * Filter fullPage Transition
 *
 * @return array
 */
function slikk_set_fullpage_transition( $transition ) {

	if ( is_page() || is_single() ) {
		if ( get_post_meta( wvc_get_the_ID(), '_post_fullpage', true ) ) {
			$transition = get_post_meta( wvc_get_the_ID(), '_post_fullpage_transition', true );
		}
	}

	return $transition;
}
add_filter( 'wvc_fp_transition_effect', 'slikk_set_fullpage_transition' );

/**
 * Product Subheading
 */
function slikk_add_product_subheading() {

	$subheading = get_post_meta( get_the_ID(), '_post_subheading', true );

	if ( is_single() && $subheading ) {
		?>
		<div class="product-subheading">
			<?php echo sanitize_text_field( $subheading ); ?>
		</div>
		<?php
	}

}
add_action( 'woocommerce_single_product_summary', 'slikk_add_product_subheading', 6 );

/**
 * WC gallery aimeg size overwrite
 */
add_filter(
	'woocommerce_gallery_thumbnail_size',
	function( $size ) {
		return array( 100, 100 );
	},
	40
);

/**
 * Category thumbnail fields.
 */
function slikk_add_category_fields() {
	?>
	<div class="form-field term-thumbnail-wrap">
		<label><?php esc_html_e( 'Size Chart', 'slikk' ); ?></label>
		<div id="sizechart_img" style="float: left; margin-right: 10px;"><img src="<?php echo esc_url( wc_placeholder_img_src() ); ?>" width="60px" height="60px" /></div>
		<div style="line-height: 60px;">
			<input type="hidden" id="product_cat_sizechart_img_id" name="product_cat_sizechart_img_id" />
			<button type="button" id="upload_sizechart_image_button" class="upload_sizechart_image_button button"><?php esc_html_e( 'Upload/Add image', 'slikk' ); ?></button>
				<button type="button" id="remove_sizechart_image_button" class="remove_sizechart_image_button button" style="display:none;"><?php esc_html_e( 'Remove image', 'slikk' ); ?></button>
		</div>
		<script type="text/javascript">

			// Only show the "remove image" button when needed
			if ( ! jQuery( '#product_cat_sizechart_img_id' ).val() ) {
				jQuery( '#remove_sizechart_image_button' ).hide();
			}

			// Uploading files
			var sizechart_frame;

			jQuery( document ).on( 'click', '#upload_sizechart_image_button', function( event ) {

				event.preventDefault();

				// If the media frame already exists, reopen it.
				if ( sizechart_frame ) {
					sizechart_frame.open();
					return;
				}

				// Create the media frame.
				sizechart_frame = wp.media.frames.downloadable_file = wp.media({
					title: '<?php esc_html_e( 'Choose an image', 'slikk' ); ?>',
					button: {
						text: '<?php esc_html_e( 'Use image', 'slikk' ); ?>'
					},
					multiple: false
				} );

				// When an image is selected, run a callback.
				sizechart_frame.on( 'select', function() {
					var attachment           = sizechart_frame.state().get( 'selection' ).first().toJSON();
					var attachment_thumbnail = attachment.sizes.thumbnail || attachment.sizes.full;

					jQuery( '#product_cat_sizechart_img_id' ).val( attachment.id );
					jQuery( '#sizechart_img' ).find( 'img' ).attr( 'src', attachment_thumbnail.url );
					jQuery( '#remove_sizechart_image_button' ).show();
				} );

				// Finally, open the modal.
				sizechart_frame.open();
			} );

			jQuery( document ).on( 'click', '#remove_sizechart_image_button', function() {
				jQuery( '#sizechart_img' ).find( 'img' ).attr( 'src', '<?php echo esc_js( wc_placeholder_img_src() ); ?>' );
				jQuery( '#product_cat_sizechart_img_id' ).val( '' );
				jQuery( '#remove_sizechart_image_button' ).hide();
				return false;
			} );

			jQuery( document ).ajaxComplete( function( event, request, options ) {
				if ( request && 4 === request.readyState && 200 === request.status
					&& options.data && 0 <= options.data.indexOf( 'action=add-tag' ) ) {

					var res = wpAjax.parseAjaxResponse( request.responseXML, 'ajax-response' );
					if ( ! res || res.errors ) {
						return;
					}
					// Clear Thumbnail fields on submit
					jQuery( '#sizechart_img' ).find( 'img' ).attr( 'src', '<?php echo esc_js( wc_placeholder_img_src() ); ?>' );
					jQuery( '#product_cat_sizechart_img_id' ).val( '' );
					jQuery( '#remove_sizechart_image_button' ).hide();
					// Clear Display type field on submit
					jQuery( '#display_type' ).val( '' );
					return;
				}
			} );

		</script>
		<div class="clear"></div>
	</div>
	<?php
}
add_action( 'product_cat_add_form_fields', 'slikk_add_category_fields', 100 );

/**
 * Edit category thumbnail field.
 *
 * @param mixed $term Term (category) being edited
 */
function slikk_edit_category_fields( $term ) {

	$sizechart_id = absint( get_term_meta( $term->term_id, 'sizechart_id', true ) );

	if ( $sizechart_id ) {
		$image = wp_get_attachment_thumb_url( $sizechart_id );
	} else {
		$image = wc_placeholder_img_src();
	}
	?>
	<tr class="form-field">
		<th scope="row" valign="top"><label><?php esc_html_e( 'Size Chart', 'slikk' ); ?></label></th>
		<td>
			<div id="sizechart_img" style="float: left; margin-right: 10px;"><img src="<?php echo esc_url( $image ); ?>" width="60px" height="60px" /></div>
			<div style="line-height: 60px;">
				<input type="hidden" id="product_cat_sizechart_img_id" name="product_cat_sizechart_img_id" value="<?php echo absint( $sizechart_id ); ?>" />
				<button type="button" id="upload_sizechart_image_button" class="upload_sizechart_image_button button"><?php esc_html_e( 'Upload/Add image', 'slikk' ); ?></button>
				<button type="button" id="remove_sizechart_image_button" class="remove_sizechart_image_button button" style="display:none;"><?php esc_html_e( 'Remove image', 'slikk' ); ?></button>
			</div>
			<script type="text/javascript">

				// Only show the "remove image" button when needed
				if ( jQuery( '#product_cat_sizechart_img_id' ).val() ) {
					jQuery( '#remove_sizechart_image_button' ).show();
				}

				// Uploading files
				var sizechart_frame;

				jQuery( document ).on( 'click', '#upload_sizechart_image_button', function( event ) {

					event.preventDefault();

					// If the media frame already exists, reopen it.
					if ( sizechart_frame ) {
						sizechart_frame.open();
						return;
					}

					// Create the media frame.
					sizechart_frame = wp.media.frames.downloadable_file = wp.media({
						title: '<?php esc_html_e( 'Choose an image', 'slikk' ); ?>',
						button: {
							text: '<?php esc_html_e( 'Use image', 'slikk' ); ?>'
						},
						multiple: false
					} );

					// When an image is selected, run a callback.
					sizechart_frame.on( 'select', function() {
						var attachment           = sizechart_frame.state().get( 'selection' ).first().toJSON();
						var attachment_thumbnail = attachment.sizes.thumbnail || attachment.sizes.full;

						jQuery( '#product_cat_sizechart_img_id' ).val( attachment.id );
						jQuery( '#sizechart_img' ).find( 'img' ).attr( 'src', attachment_thumbnail.url );
						jQuery( '#remove_sizechart_image_button' ).show();
					} );

					// Finally, open the modal.
					sizechart_frame.open();
				} );

				jQuery( document ).on( 'click', '#remove_sizechart_image_button', function() {
					jQuery( '#sizechart_img' ).find( 'img' ).attr( 'src', '<?php echo esc_js( wc_placeholder_img_src() ); ?>' );
					jQuery( '#product_cat_sizechart_img_id' ).val( '' );
					jQuery( '#remove_sizechart_image_button' ).hide();
					return false;
				} );

			</script>
			<div class="clear"></div>
		</td>
	</tr>
	<?php
}
add_action( 'product_cat_edit_form_fields', 'slikk_edit_category_fields', 100 );

/**
 * save_category_fields function.
 *
 * @param mixed  $term_id Term ID being saved
 * @param mixed  $tt_id
 * @param string $taxonomy
 */
function slikk_save_category_fields( $term_id, $tt_id = '', $taxonomy = '' ) {

	if ( isset( $_POST['product_cat_sizechart_img_id'] ) && 'product_cat' === $taxonomy ) {
		update_woocommerce_term_meta( $term_id, 'sizechart_id', absint( $_POST['product_cat_sizechart_img_id'] ) );
	}
}
add_action( 'created_term', 'slikk_save_category_fields', 10, 3 );
add_action( 'edit_term', 'slikk_save_category_fields', 10, 3 );

/**
 * Product Size Chart Image
 */
function slikk_product_size_chart_img() {

	$hide_sizechart = get_post_meta( get_the_ID(), '_post_wc_product_hide_size_chart_img', true );

	if ( $hide_sizechart || ! is_singular( 'product' ) ) {
		return;
	}

	global $post;
	$sc_img = null;
	$terms  = get_the_terms( $post, 'product_cat' );

	foreach ( $terms as $term ) {

		$sizechart_id = absint( get_term_meta( $term->term_id, 'sizechart_id', true ) );

		if ( $sizechart_id ) {
			$sc_img = $sizechart_id;
		}
	}

	if ( get_post_meta( get_the_ID(), '_post_wc_product_size_chart_img', true ) ) {
		$sc_img = get_post_meta( get_the_ID(), '_post_wc_product_size_chart_img', true );
	}

	if ( is_single() && $sc_img ) {
		$href = slikk_get_url_from_attachment_id( $sc_img, 'slikk-XL' );
		?>
		<div class="size-chart-img">
			<a href="<?php echo esc_url( $href ); ?>" class="lightbox"><?php esc_html_e( 'Size Chart', 'slikk' ); ?></a>
		</div>
		<?php
	}
}
add_action( 'woocommerce_single_product_summary', 'slikk_product_size_chart_img', 25 );

add_filter(
	'slikk_entry_tag_list_separator',
	function() {
		return ' / ';
	}
);

/**
 * Quickview product excerpt lenght
 */
add_filter(
	'wwcqv_excerpt_length',
	function() {
		return 28;
	}
);

/**
 * After quickview summary hook
 */
add_action(
	'wwcqv_product_summary',
	function() {
		?>
	<hr>
	<div class="single-add-to-wishlist">
		<span class="single-add-to-wishlist-label"><?php esc_html_e( 'Wishlist', 'slikk' ); ?></span>
		<?php slikk_add_to_wishlist(); ?>
	</div><!-- .single-add-to-wishlist -->
	<hr>
	<p><a class="wvc-button wvc-button-size-sm slikk-button-simple internal-link" href="<?php the_permalink(); ?>"><?php esc_html_e( 'View details', 'slikk' ); ?></a></p>
		<?php
	},
	30
);

add_filter(
	'slikk_show_single_product_wishlist_button',
	function() {
		return false;
	}
);

/**
 * Re-put add to wishlist button after add to cart button
 */
function slikk_wc_reput_single_wishlist() {
	add_action( 'woocommerce_after_add_to_cart_button', 'slikk_single_add_to_wishlist_button' );

}
add_action( 'init', 'slikk_wc_reput_single_wishlist' );

/**
 * Add to wishlist button in single product page
 */
function slikk_single_add_to_wishlist_button() {

	if ( ! function_exists( 'www_get_wishlist_product_ids' ) ) {
		return;
	}

	$wishlist = www_get_wishlist_product_ids();

	$product_id     = get_the_ID();
	$is_in_wishlist = ( $wishlist ) ? ( in_array( $product_id, $wishlist ) ) : false;

	$class = ( $is_in_wishlist ) ? 'wolf_in_wishlist' : '';

	$class .= ' slikk-button-primary-alt button no-tipsy wvc-button wvc-button-size-sm';

	$text = ( $is_in_wishlist ) ? esc_html__( 'Remove from wishlist', 'slikk' ) : esc_html__( 'Add to wishlist', 'slikk' );
	do_action( 'www_before_add_to_wishlist' );

	$class .= apply_filters( 'wolf_add_to_wishlist_class', ' wolf_add_to_wishlist button' );

	?>
	<a
	class="<?php echo esc_attr( $class ); ?>"
	href="?add_to_wishlist=<?php the_ID(); ?>"
	title="<?php echo esc_attr( $text ); ?>"
	rel="nofollow"
	data-product-title="<?php echo esc_attr( get_the_title() ); ?>"
	data-product-id="<?php the_ID(); ?>"><span class="wolf_add_to_wishlist_heart"></span> <span class="wolf-add-to-wishlist-button-text"><?php echo esc_attr( $text ); ?></span></a>
	<?php
	do_action( 'www_after_add_to_wishlist' );
}

/**
 * Filter post modules
 *
 * @param array $atts
 * @return array $atts
 */
function slikk_filter_post_module_atts( $atts ) {

	if ( 'add_filmgrain' === $atts['work_layout'] ) {
		$atts['work_layout'] = 'overlay';
		$atts['el_class']   .= ' hover-filmgrain';
	}

	return $atts;
}
add_filter( 'slikk_post_module_atts', 'slikk_filter_post_module_atts' );

/**
 * No header post types
 *
 * @param  array $post_types Post types where the default hero block is disabled.
 * @return array
 */
function slikk_filter_no_hero_post_types( $post_types ) {

	$post_types = array( 'product', 'attachment', 'wpm_playlist' );

	return $post_types;
}
add_filter( 'slikk_no_header_post_types', 'slikk_filter_no_hero_post_types', 40 );

function slikk_show_shop_header_content_block_single_product( $bool ) {

	if ( is_singular( 'product' ) ) {
		$bool = true;
	}

	return $bool;
}
add_filter( 'slikk_force_display_shop_after_header_block', 'slikk_show_shop_header_content_block_single_product' );

/**
 * Disable single post pagination
 *
 * @param bool $bool
 * @return bool
 */
add_filter( 'slikk_disable_single_post_pagination', '__return_true' );

/**
 * Read more text
 */
function slikk_view_post_text( $string ) {
	return esc_html__( 'Read more', 'slikk' );
}
add_filter( 'slikk_view_post_text', 'slikk_view_post_text' );

/**
 * Search form placeholder
 */
function slikk_set_searchform_placeholder( $string ) {
	return esc_attr_x( 'Search&hellip;', 'placeholder', 'slikk' );
}
add_filter( 'slikk_searchform_placeholder', 'slikk_set_searchform_placeholder', 40 );

/**
 * Filter WVC theme accent color
 *
 * @param string $color
 * @return string $color
 */
function slikk_set_wvc_secondary_theme_accent_color( $color ) {
	return slikk_get_inherit_mod( 'secondary_accent_color' );
}
add_filter( 'wvc_theme_secondary_accent_color', 'slikk_set_wvc_theme_secondary_accent_color' );

/**
 * Add theme secondary accent color to shared colors
 *
 * @param array $colors
 * @return array $colors
 */
function slikk_wvc_add_secondary_accent_color_option( $colors ) {

	$colors = array( esc_html__( 'Theme Secondary Accent Color', 'slikk' ) => 'secondary_accent' ) + $colors;

	return $colors;
}
add_filter( 'wvc_shared_colors', 'slikk_wvc_add_secondary_accent_color_option' );

/**
 * Filter WVC shared color hex
 *
 * @param array $colors
 * @return array $colors
 */
function slikk_add_secondary_accent_color_hex( $colors ) {

	$secondary_accent_color = get_theme_mod( 'secondary_accent_color' );

	if ( $secondary_accent_color ) {
		$colors['secondary_accent'] = $secondary_accent_color;
	}

	return $colors;
}
add_filter( 'wvc_shared_colors_hex', 'slikk_add_secondary_accent_color_hex' );

/**
 * Add form in no result page
 */
function slikk_add_no_result_form() {
	get_search_form();
}
add_action( 'slikk_no_result_end', 'slikk_add_no_result_form' );

/**
 * Remove unused mods
 *
 * @param array $mods The default mods.
 * @return void
 */
function slikk_remove_mods( $mods ) {

	// Unset
	unset( $mods['layout']['options']['button_style'] );
	unset( $mods['layout']['options']['site_layout'] );

	unset( $mods['fonts']['options']['body_font_size'] );

	unset( $mods['shop']['options']['product_display'] );

	unset( $mods['navigation']['options']['menu_hover_style'] );
	unset( $mods['navigation']['options']['menu_layout']['choices']['overlay'] );
	unset( $mods['navigation']['options']['menu_skin'] );

	unset( $mods['header_settings']['options']['hero_scrolldown_arrow'] );

	unset( $mods['blog']['options']['post_display'] );

	return $mods;
}
add_filter( 'slikk_customizer_mods', 'slikk_remove_mods', 20 );

/**
 * Disable parallax effect in masonry
 *
 * @param string $string
 * @return string
 */
function slikk_disable_masonry_parallax_effect( $string ) {

	return 'none';
}
add_filter( 'slikk_masonry_modern_image_format_effect', 'slikk_disable_masonry_parallax_effect' );

/**
 * Custom button types
 */
function slikk_custom_button_types() {
	return array(
		esc_html__( 'Default', 'slikk' )           => 'default',
		esc_html__( 'Special Primary', 'slikk' )   => 'slikk-button-special-primary',
		esc_html__( 'Special Secondary', 'slikk' ) => 'slikk-button-special-secondary',
		esc_html__( 'Primary', 'slikk' )           => 'slikk-button-primary',
		esc_html__( 'Secondary', 'slikk' )         => 'slikk-button-secondary',
		esc_html__( 'Primary Alt', 'slikk' )       => 'slikk-button-primary-alt',
		esc_html__( 'Secondary Alt', 'slikk' )     => 'slikk-button-secondary-alt',
		esc_html__( 'Simple', 'slikk' )            => 'slikk-button-simple',
	);
}

/**
 * Custom backgorund effect output
 */
function slikk_get_filmgrain( $html ) {

	ob_start();
	?>
	<div class="slikk-bg-overlay"></div>
	<?php
	$html = ob_get_clean();

	return $html;
}
add_filter( 'wvc_background_effect', 'slikk_get_filmgrain' );

/**
 * Custom backgorund effect output
 */
function slikk_output_filmgrain() {
	?>
	<div class="slikk-bg-overlay"></div>
	<?php
}
add_action( 'slikk_overlay_menu_panel_start', 'slikk_output_filmgrain', 40 );
add_action( 'slikk_sidepanel_start', 'slikk_output_filmgrain', 40 );

/**
 *  Add phase background effect
 *
 * @param string $effects
 * @return string $effects
 */
function slikk_add_wvc_custom_background_effect( $effects ) {

	if ( function_exists( 'vc_add_param' ) ) {
		vc_add_param(
			'vc_row',
			array(
				'type'       => 'checkbox',
				'heading'    => esc_html__( 'Add Film Grain Effect', 'slikk' ),
				'param_name' => 'add_effect',
				'group'      => esc_html__( 'Style', 'slikk' ),
			)
		);

		vc_add_param(
			'vc_column',
			array(
				'type'       => 'checkbox',
				'heading'    => esc_html__( 'Add Film Grain Effect', 'slikk' ),
				'param_name' => 'add_effect',
				'group'      => esc_html__( 'Style', 'slikk' ),
			)
		);

		vc_add_param(
			'vc_column_inner',
			array(
				'type'       => 'checkbox',
				'heading'    => esc_html__( 'Add Film Grain Effect', 'slikk' ),
				'param_name' => 'add_effect',
				'group'      => esc_html__( 'Style', 'slikk' ),
			)
		);

		vc_add_param(
			'wvc_advanced_slide',
			array(
				'type'       => 'checkbox',
				'heading'    => esc_html__( 'Add Film Grain Effect', 'slikk' ),
				'param_name' => 'add_effect',
				// 'group' => esc_html__( 'Background', 'slikk' ),
			)
		);

		vc_add_param(
			'wvc_interactive_link_item',
			array(
				'type'       => 'checkbox',
				'heading'    => esc_html__( 'Add Film Grain Effect', 'slikk' ),
				'param_name' => 'add_effect',
				'group'      => esc_html__( 'Background', 'slikk' ),
			)
		);

		vc_add_param(
			'vc_column',
			array(
				'type'       => 'checkbox',
				'heading'    => esc_html__( 'Add Film Grain Effect', 'slikk' ),
				'param_name' => 'add_effect',
				'group'      => esc_html__( 'Style', 'slikk' ),
			)
		);

		vc_add_param(
			'wvc_work_index',
			array(
				'param_name'  => 'work_layout',
				'heading'     => esc_html__( 'Layout', 'slikk' ),
				'type'        => 'dropdown',
				'value'       => array(
					esc_html__( 'Classic', 'slikk' ) => 'standard',
					esc_html__( 'Overlay', 'slikk' ) => 'overlay',
					esc_html__( 'Filmgrain Overlay', 'slikk' ) => 'add_filmgrain',
				),
				'admin_label' => true,
				'dependency'  => array(
					'element'            => 'work_display',
					'value_not_equal_to' => array( 'list_minimal' ),
				),
			)
		);

		vc_add_param(
			'rev_slider_vc',
			array(
				'type'       => 'checkbox',
				'heading'    => esc_html__( 'Preloader Background', 'slikk' ),
				'param_name' => 'preloader_bg',
			)
		);
	}
}
add_action( 'init', 'slikk_add_wvc_custom_background_effect' );

/**
 * Add theme button option
 */
function slikk_add_button_dependency_params() {

	if ( ! class_exists( 'WPBMap' ) || ! class_exists( 'Wolf_Visual_Composer' ) || ! defined( 'WVC_OK' ) || ! WVC_OK ) {
		return;
	}

	$param               = WPBMap::getParam( 'vc_button', 'color' );
	$param['dependency'] = array(
		'element' => 'button_type',
		'value'   => 'default',
	);
	vc_update_shortcode_param( 'vc_button', $param );

	$param               = WPBMap::getParam( 'vc_button', 'shape' );
	$param['dependency'] = array(
		'element' => 'button_type',
		'value'   => 'default',
	);
	vc_update_shortcode_param( 'vc_button', $param );

	$param               = WPBMap::getParam( 'vc_button', 'hover_effect' );
	$param['dependency'] = array(
		'element' => 'button_type',
		'value'   => 'default',
	);
	vc_update_shortcode_param( 'vc_button', $param );

	$param               = WPBMap::getParam( 'vc_cta', 'btn_color' );
	$param['dependency'] = array(
		'element' => 'btn_button_type',
		'value'   => 'default',
	);

	vc_update_shortcode_param( 'vc_cta', $param );

	$param               = WPBMap::getParam( 'vc_cta', 'btn_shape' );
	$param['dependency'] = array(
		'element' => 'btn_button_type',
		'value'   => 'default',
	);
	vc_update_shortcode_param( 'vc_cta', $param );

	$param               = WPBMap::getParam( 'vc_cta', 'btn_hover_effect' );
	$param['dependency'] = array(
		'element' => 'btn_button_type',
		'value'   => 'default',
	);
	vc_update_shortcode_param( 'vc_cta', $param );
}
add_action( 'init', 'slikk_add_button_dependency_params', 15 );

/**
 * Filter button attribute
 *
 * @param array $atts
 * @return array $atts
 */
function woltheme_filter_button_atts( $atts ) {

	// button
	if ( isset( $atts['button_type'] ) && 'default' !== $atts['button_type'] ) {
		$atts['shape']        = '';
		$atts['color']        = '';
		$atts['hover_effect'] = '';
		$atts['el_class']    .= ' ' . $atts['button_type'];
	}

	return $atts;
}
add_filter( 'wvc_button_atts', 'woltheme_filter_button_atts' );

/**
 * Filter button attribute
 *
 * @param array $atts the shortcode atts we get
 * @param array $btn_params the button attribute to filter
 * @return array $btn_params
 */
function woltheme_filter_elements_button_atts( $btn_params, $atts ) {

	// button
	if (
		isset( $atts['btn_button_type'] ) && 'default' !== $atts['btn_button_type']
	) {
		$btn_params['shape']        = '';
		$btn_params['color']        = '';
		$btn_params['hover_effect'] = '';

		if ( isset( $btn_params['el_class'] ) ) {
			$btn_params['el_class'] .= ' ' . $atts['btn_button_type'];
		} else {
			$btn_params['el_class'] = ' ' . $atts['btn_button_type'];
		}
	}

	if ( isset( $atts['b1_button_type'] ) && 'default' !== $atts['b1_button_type'] ) {

		$btn_params['shape']        = '';
		$btn_params['color']        = '';
		$btn_params['hover_effect'] = '';

		if ( isset( $btn_params['el_class'] ) ) {
			$btn_params['el_class'] .= ' ' . $atts['b1_button_type'];
		} else {
			$btn_params['el_class'] = ' ' . $atts['b1_button_type'];
		}
	}

	// if ( isset( $atts['b2_button_type'] ) && 'default' !== $atts['b2_button_type'] ) {

	// $btn_params['shape'] = '';
	// $btn_params['color'] = '';
	// $btn_params['hover_effect'] = '';

	// if ( isset( $btn_params['el_class'] ) ) {
	// $btn_params['el_class'] .= ' ' . $atts['b2_button_type'];
	// } else {
	// $btn_params['el_class'] = ' ' . $atts['b2_button_type'];
	// }

	// }

	return $btn_params;
}
add_filter( 'wvc_cta_button_atts', 'woltheme_filter_elements_button_atts', 10, 2 );
add_filter( 'wvc_banner_button_atts', 'woltheme_filter_elements_button_atts', 10, 2 );
add_filter( 'wvc_advanced_slider_b1_button_atts', 'woltheme_filter_elements_button_atts', 10, 2 );

add_filter(
	'wvc_advanced_slider_b2_button_atts',
	function( $btn_params, $atts ) {

		if ( isset( $atts['b2_button_type'] ) && 'default' !== $atts['b2_button_type'] ) {

			$btn_params['shape']        = '';
			$btn_params['color']        = '';
			$btn_params['hover_effect'] = '';

			if ( isset( $btn_params['el_class'] ) ) {
				$btn_params['el_class'] .= ' ' . $atts['b2_button_type'];
			} else {
				$btn_params['el_class'] = ' ' . $atts['b2_button_type'];
			}
		}

		return $btn_params;

	},
	10,
	2
);

add_filter(
	'wvc_revslider_container_class',
	function( $class, $atts ) {

		if ( isset( $atts['preloader_bg'] ) && 'true' === $atts['preloader_bg'] ) {
			$class .= ' wvc-preloader-bg';
		}

		return $class;

	},
	10,
	2
);

/**
 * Add theme button option to Button element
 */
function slikk_add_theme_buttons() {

	if ( function_exists( 'vc_add_params' ) ) {
		vc_add_params(
			'vc_button',
			array(
				array(
					'heading'    => esc_html__( 'Button Type', 'slikk' ),
					'param_name' => 'button_type',
					'type'       => 'dropdown',
					'value'      => slikk_custom_button_types(),
					'weight'     => 1000,
				),
			)
		);

		vc_add_params(
			'vc_cta',
			array(
				array(
					'heading'    => esc_html__( 'Button Type', 'slikk' ),
					'param_name' => 'btn_button_type',
					'type'       => 'dropdown',
					'value'      => slikk_custom_button_types(),
					'weight'     => 10,
					'group'      => esc_html__( 'Button', 'slikk' ),
				),
			)
		);

		vc_add_params(
			'wvc_banner',
			array(
				array(
					'heading'    => esc_html__( 'Button Type', 'slikk' ),
					'param_name' => 'btn_button_type',
					'type'       => 'dropdown',
					'value'      => slikk_custom_button_types(),
					// 'weight' => 10,
					'group'      => esc_html__( 'Button', 'slikk' ),
				),
			)
		);

		vc_add_params(
			'wvc_advanced_slide',
			array(
				array(
					'heading'    => esc_html__( 'Button Type', 'slikk' ),
					'param_name' => 'b1_button_type',
					'type'       => 'dropdown',
					'value'      => slikk_custom_button_types(),
					'weight'     => 10,
					'group'      => esc_html__( 'Button 1', 'slikk' ),
					'dependency' => array(
						'element' => 'add_button_1',
						'value'   => array( 'true' ),
					),
				),
			)
		);

		vc_add_params(
			'wvc_advanced_slide',
			array(
				array(
					'heading'    => esc_html__( 'Button Type', 'slikk' ),
					'param_name' => 'b2_button_type',
					'type'       => 'dropdown',
					'value'      => slikk_custom_button_types(),
					'weight'     => 10,
					'group'      => esc_html__( 'Button 2', 'slikk' ),
					'dependency' => array(
						'element' => 'add_button_2',
						'value'   => array( 'true' ),
					),
				),
			)
		);

		// vc_add_params(
		// 'vc_custom_heading',
		// array(
		// array(
		// 'heading' => esc_html__( 'Style', 'slikk' ),
		// 'param_name' => 'style',
		// 'type' => 'dropdown',
		// 'value' => array(
		// esc_html__( 'Theme Style', 'slikk' ) => 'slikk-heading',
		// esc_html__( 'Default', 'slikk' ) => '',
		// ),
		// 'weight' => 10,
		// ),
		// )
		// );
	}
}
add_action( 'init', 'slikk_add_theme_buttons' );

/**
 * Add style option to tabs element
 */
function slikk_add_vc_accordion_and_tabs_options() {
	if ( function_exists( 'vc_add_params' ) ) {
		vc_add_params(
			'vc_tabs',
			array(
				array(
					'heading'    => esc_html__( 'Background', 'slikk' ),
					'param_name' => 'background',
					'type'       => 'dropdown',
					'value'      => array(
						esc_html__( 'Solid', 'slikk' ) => 'solid',
						esc_html__( 'Transparent', 'slikk' ) => 'transparent',
					),
					'weight'     => 1000,
				),
			)
		);
	}

	if ( function_exists( 'vc_add_params' ) ) {
		vc_add_params(
			'vc_accordion',
			array(
				array(
					'heading'    => esc_html__( 'Background', 'slikk' ),
					'param_name' => 'background',
					'type'       => 'dropdown',
					'value'      => array(
						esc_html__( 'Solid', 'slikk' ) => 'solid',
						esc_html__( 'Transparent', 'slikk' ) => 'transparent',
					),
					'weight'     => 1000,
				),
			)
		);
	}
}
add_action( 'init', 'slikk_add_vc_accordion_and_tabs_options' );

/**
 * Filter tabs shortcode attribute
 */
function slikk_add_vc_tabs_params( $params ) {

	if ( isset( $params['background'] ) ) {
		$params['el_class'] = $params['el_class'] . ' wvc-tabs-background-' . $params['background'];
	}

	return $params;
}
add_filter( 'shortcode_atts_vc_tabs', 'slikk_add_vc_tabs_params' );

/**
 * Filter accordion shortcode attribute
 */
function slikk_add_vc_accordion_params( $params ) {

	if ( isset( $params['background'] ) ) {
		$params['el_class'] = $params['el_class'] . ' wvc-accordion-background-' . $params['background'];
	}

	return $params;
}
add_filter( 'shortcode_atts_vc_accordion', 'slikk_add_vc_accordion_params' );

/**
 *  Set default button shape
 *
 * @param string $shape
 * @return string $shape
 */
function slikk_set_default_wvc_button_shape( $shape ) {
	return 'boxed';
}
add_filter( 'wvc_default_button_shape', 'slikk_set_default_wvc_button_shape', 40 );

/**
 *  Set default button shape
 *
 * @param string $shape
 * @return string $shape
 */
function slikk_set_default_theme_button_shape( $shape ) {
	return 'square';
}
add_filter( 'slikk_mod_button_style', 'slikk_set_default_theme_button_shape', 40 );

/**
 *  Set default button font weight
 *
 * @param string $shape
 * @return string $shape
 */
function slikk_set_default_wvc_button_font_weight( $font_weight ) {
	return 400;
}
add_filter( 'wvc_button_default_font_weight', 'slikk_set_default_wvc_button_font_weight', 40 );

/**
 *  Set default pie chart line width
 *
 * @param string $width
 * @return string $width
 */
function wvc_set_default_pie_chart_line_width( $width ) {

	return 3;
}
add_filter( 'wvc_default_pie_chart_line_width', 'wvc_set_default_pie_chart_line_width', 40 );

/**
 * Added selector to heading_family_selectors
 *
 * @param  array $selectors headings related CSS selectors.
 * @return array $selectors
 */
function slikk_add_heading_family_selectors( $selectors ) {

	$selectors[] = '.wvc-tabs-menu li a';
	$selectors[] = '.woocommerce-tabs ul.tabs li a';
	$selectors[] = '.wvc-process-number';
	$selectors[] = '.wvc-button';
	$selectors[] = '.button';
	$selectors[] = '.onsale, .category-label';
	$selectors[] = '.entry-post-grid_classic .sticky-post';
	$selectors[] = 'input[type=submit], .wvc-mailchimp-submit';
	$selectors[] = '.nav-next,.nav-previous';
	$selectors[] = '.wvc-embed-video-play-button';
	$selectors[] = '.category-filter ul li';
	$selectors[] = '.wvc-ati-title';
	$selectors[] = '.cart-panel-buttons a';
	$selectors[] = '.wvc-team-member-role';
	$selectors[] = '.wvc-svc-item-tagline';
	$selectors[] = '.entry-metro insta-username';
	$selectors[] = '.wvc-testimonial-cite';
	$selectors[] = '.slikk-button-dir-aware';
	$selectors[] = '.preqelle-button-dir-aware-alt';
	$selectors[] = '.slikk-button-outline';
	$selectors[] = '.slikk-button-outline-alt';
	$selectors[] = '.slikk-button-simple';
	$selectors[] = '.wvc-wc-cat-title';
	$selectors[] = '.wvc-pricing-table-button a';
	// $selectors[] = '.load-more-button-line';
	$selectors[] = '.view-post';
	$selectors[] = '.wolf-gram-follow-button';
	$selectors[] = '.woocommerce-MyAccount-navigation-link a';
	$selectors[] = '#slikk-percent, .woocommerce-Price-amount';

	return $selectors;
}
add_filter( 'slikk_heading_family_selectors', 'slikk_add_heading_family_selectors' );

/**
 * Added selector to heading_family_selectors
 *
 * @param  array $selectors headings related CSS selectors.
 * @return array $selectors
 */
function slikk_add_slikk_heading_selectors( $selectors ) {

	$selectors[] = '.wvc-tabs-menu li a';
	$selectors[] = '.woocommerce-tabs ul.tabs li a';
	$selectors[] = '.wvc-process-number';
	$selectors[] = '.woocommerce-MyAccount-navigation-link a';
	$selectors[] = '.wvc-wc-cat-title';

	return $selectors;
}
add_filter( 'slikk_heading_selectors', 'slikk_add_slikk_heading_selectors' );

/**
 *  Set default heading font size
 *
 * @param int $font_size
 * @return int $font_size
 */
function wvc_set_default_custom_heading_font_size( $font_size ) {
	return 36;
}
add_filter( 'wvc_default_custom_heading_font_size', 'wvc_set_default_custom_heading_font_size', 40 );
add_filter( 'wvc_default_advanced_slide_title_font_size', 'wvc_set_default_custom_heading_font_size', 40 );

/**
 *  Set default heading font weight
 *
 * @param int $font_weight
 * @return int $font_weight
 */
function wvc_set_default_custom_heading_font_weight( $font_weight ) {
	return 500;
}
add_filter( 'wvc_default_custom_heading_font_weight', 'wvc_set_default_custom_heading_font_weight', 40 );
add_filter( 'wvc_default_advanced_slide_title_font_weight', 'wvc_set_default_custom_heading_font_weight', 40 );

/**
 *  Set default heading font size
 *
 * @param string $font_size
 * @return string $font_size
 */
function wvc_set_default_cta_font_size( $font_size ) {
	return 24;
}
add_filter( 'wvc_default_cta_font_size', 'wvc_set_default_cta_font_size', 40 );

/**
 *  Set default heading layout
 *
 * @param string $layout
 * @return string $layout
 */
function wvc_set_default_team_member_layout( $layout ) {
	return 'overlay';
}
add_filter( 'wvc_default_team_member_layout', 'wvc_set_default_team_member_layout', 40 );

/**
 *  Set default team member title font size
 *
 * @param string $font_size
 * @return string $font_size
 */
function wvc_set_default_team_member_font_size( $font_size ) {
	return 24;
}
add_filter( 'wvc_default_team_member_title_font_size', 'wvc_set_default_team_member_font_size', 40 );
add_filter( 'wvc_default_single_image_title_font_size', 'wvc_set_default_team_member_font_size', 40 );

/**
 * Primary buttons class
 *
 * @param string $string
 * @return string
 */
function slikk_set_primary_button_class( $class ) {

	$slikk_button_class = 'slikk-button-primary-alt';

	$class = $slikk_button_class . ' wvc-button wvc-button-size-xs';

	return $class;
}
add_filter( 'wvc_last_posts_big_slide_button_class', 'slikk_set_primary_button_class' );
add_filter( 'slikk_404_button_class', 'slikk_set_primary_button_class' );
add_filter( 'slikk_post_product_button', 'slikk_set_primary_button_class' );

/**
 * Load more buttons class
 *
 * @param string $string
 * @return string
 */
function slikk_set_loadmore_button_class( $class ) {

	$phase_button_class = 'slikk-button-primary-alt';

	$class = $phase_button_class . ' wvc-button wvc-button-size-lg';

	return $class;
}
add_filter( 'slikk_loadmore_button_class', 'slikk_set_loadmore_button_class' );

/**
 * Reod more buttons class
 *
 * @param string $string
 * @return string
 */
function slikk_set_readmore_button_class( $class ) {

	$phase_button_class = 'slikk-button-primary-alt';

	$class = $phase_button_class . ' wvc-button wvc-button-size-sm';

	return $class;
}
add_filter( 'slikk_more_link_button_class', 'slikk_set_readmore_button_class' );

/**
 * Author box buttons class
 *
 * @param string $string
 * @return string
 */
function slikk_set_author_box_button_class( $class ) {

	$class = ' wvc-button wvc-button-size-xs slikk-button-primary-alt';

	return $class;
}
add_filter( 'slikk_author_page_link_button_class', 'slikk_set_author_box_button_class' );


/**
 * Excerpt more
 *
 * Add span to allow more CSS tricks
 *
 * @return string
 */
function slikk_custom_more_text( $string ) {

	$text = '<span>' . esc_html__( 'Read more', 'slikk' ) . '</span>';

	return $text;
}
add_filter( 'slikk_more_text', 'slikk_custom_more_text', 40 );

/**
 * Filter empty p tags in excerpt
 */
function slikk_filter_excerpt_empty_p_tags( $excerpt ) {

	return str_replace( '<p></p>', '', $excerpt );

}
add_filter( 'get_the_excerpt', 'slikk_filter_excerpt_empty_p_tags', 100 );

/**
 * Set related posts text
 *
 * @param string $string
 * @return string
 */
function slikk_set_related_posts_text( $text ) {

	return esc_html__( 'You May Also Like', 'slikk' );
}
add_filter( 'slikk_related_posts_text', 'slikk_set_related_posts_text' );

/**
 *  Set entry slider animation
 *
 * @param string $animation
 * @return string $animation
 */
function slikk_set_entry_slider_animation( $animation ) {
	return 'slide';
}
add_filter( 'slikk_entry_slider_animation', 'slikk_set_entry_slider_animation', 40 );

/**
 *  Set default item overlay color
 *
 * @param string $color
 * @return string $color
 */
function slikk_set_default_item_overlay_color( $color ) {
	return 'black';
}
add_filter( 'wvc_default_item_overlay_color', 'slikk_set_default_item_overlay_color', 40 );

/**
 *  Set default item overlay text color
 *
 * @param string $color
 * @return string $color
 */
function slikk_set_item_overlay_text_color( $color ) {
	return 'white';
}
add_filter( 'wvc_default_item_overlay_text_color', 'slikk_set_item_overlay_text_color', 40 );

/**
 *  Set default item overlay opacity
 *
 * @param int $color
 * @return int $color
 */
function slikk_set_item_overlay_opacity( $opacity ) {
	return 40;
}
add_filter( 'wvc_default_item_overlay_opacity', 'slikk_set_item_overlay_opacity', 40 );

/**
 * Excerpt length hook
 * Set the number of character to display in the excerpt
 *
 * @param int $length
 * @return int
 */
function slikk_overwrite_excerpt_length( $length ) {

	return 23;
}
add_filter( 'slikk_excerpt_length', 'slikk_overwrite_excerpt_length' );

/**
 * Excerpt length hook
 * Set the number of character to display in the excerpt
 *
 * @param int $length
 * @return int
 */
function slikk_overwrite_sticky_menu_height( $length ) {

	return 55;
}
add_filter( 'slikk_sticky_menu_height', 'slikk_overwrite_sticky_menu_height' );

/**
 *  Set menu skin
 *
 * @param string $skin
 * @return string $skin
 */
function slikk_set_menu_skin( $skin ) {
	return 'dark';
}
add_filter( 'slikk_mod_menu_skin', 'slikk_set_menu_skin', 40 );

/**
 * Set menu hover effect
 *
 * @param string $string
 * @return string
 */
function slikk_set_menu_hover_style( $string ) {

	return 's-underline';
}
add_filter( 'slikk_mod_menu_hover_style', 'slikk_set_menu_hover_style' );

/**
 * Get available display options for products
 *
 * @return array
 */
function slikk_set_product_display_options() {

	return array(
		'grid_overlay_quickview'  => esc_html__( 'Grid', 'slikk' ),
		'metro_overlay_quickview' => esc_html__( 'Metro', 'slikk' ),
	);
}
add_filter( 'slikk_product_display_options', 'slikk_set_product_display_options' );

/**
 * Set default shop display
 *
 * @param string $string
 * @return string
 */
function slikk_set_product_display( $string ) {

	return 'grid_overlay_quickview';
}
add_filter( 'slikk_mod_product_display', 'slikk_set_product_display' );

/**
 * Display sale label condition
 *
 * @param bool $bool
 * @return bool
 */
function slikk_do_show_sale_label( $bool ) {

	if ( get_post_meta( get_the_ID(), '_post_product_label', true ) ) {
		$bool = true;
	}

	return $bool;
}
add_filter( 'slikk_show_sale_label', 'slikk_do_show_sale_label' );

/**
 * Sale label text
 *
 * @param string $string
 * @return string
 */
function slikk_sale_label( $string ) {

	if ( get_post_meta( get_the_ID(), '_post_product_label', true ) ) {
		$string = '<span class="onsale">' . esc_attr( get_post_meta( get_the_ID(), '_post_product_label', true ) ) . '</span>';
	}

	return $string;
}
add_filter( 'woocommerce_sale_flash', 'slikk_sale_label' );


add_action(
	'woocommerce_before_quantity_input_field',
	function() {
		echo '<span class="wt-quantity-plus"></span>';
	}
);

add_action(
	'woocommerce_after_quantity_input_field',
	function() {
		echo '<span class="wt-quantity-minus"></span>';
	}
);

/**
 * Product quickview button
 *
 * @param string $string
 * @return string
 */
function slikk_output_product_quickview_button() {

	if ( function_exists( 'wolf_quickview_button' ) ) {
		wolf_quickview_button();
	}
}
add_filter( 'slikk_product_quickview_button', 'slikk_output_product_quickview_button' );

/**
 * Product wishlist button
 *
 * @param string $string
 * @return string
 */
function slikk_output_product_wishlist_button() {

	if ( function_exists( 'wolf_add_to_wishlist' ) ) {
		wolf_add_to_wishlist();
	}
}
add_filter( 'slikk_add_to_wishlist_button', 'slikk_output_product_wishlist_button' );

/**
 * Product Add to cart button
 *
 * @param string $string
 * @return string
 */
function slikk_output_product_add_to_cart_button() {

	global $product;

	if ( $product->is_type( 'variable' ) ) {

		// echo '<a class="product-quickview-button" href="' . esc_url( get_permalink() ) . '"><span class="fa quickview-product-add-to-cart-icon" title="' . esc_attr( __( 'Select option', 'slikk' ) ). '"></span></a>';

		echo '<a class="product-quickview-button quickview-product-add-to-cart" href="' . esc_url( get_permalink() ) . '"><span>' . esc_attr( __( 'Select option', 'slikk' ) ) . '</span></a>';

	} elseif ( $product->is_type( 'external' ) || $product->is_type( 'grouped' ) ) {

		echo '<a class="product-quickview-button quickview-product-add-to-cart" href="' . esc_url( get_permalink() ) . '"><span>' . esc_attr( __( 'View product', 'slikk' ) ) . '</span></a>';

	} else {

		// echo slikk_add_to_cart(
		// get_the_ID(),
		// 'quickview-product-add-to-cart product-quickview-button',
		// '<span class="fa quickview-product-add-to-cart-icon" title="' . esc_attr( __( 'Add to cart', 'slikk' ) ). '"></span>'
		// );

		echo slikk_add_to_cart(
			get_the_ID(),
			'quickview-product-add-to-cart product-quickview-button',
			'<span>' . esc_attr( __( 'Add to cart', 'slikk' ) ) . '</span>'
		);
	}

}
add_filter( 'slikk_product_add_to_cart_button', 'slikk_output_product_add_to_cart_button' );

/**
 * Product more button
 *
 * @param string $string
 * @return string
 */
function slikk_output_product_more_button() {

	?>
	<a class="product-quickview-button product-more-button" href="<?php the_permalink(); ?>" title="<?php esc_attr_e( 'More details', 'slikk' ); ?>"><span class="fa ion-android-more-vertical"></span></a>
	<?php
}
add_filter( 'slikk_product_more_button', 'slikk_output_product_more_button' );

/**
 * Product stacked images + sticky details
 */
function slikk_single_product_sticky_layout() {

	if ( ! slikk_get_inherit_mod( 'product_sticky' ) || 'no' === slikk_get_inherit_mod( 'product_sticky' ) ) {
		return;
	}

	/* Remove default images */
	remove_action( 'woocommerce_before_single_product_summary', 'woocommerce_show_product_images', 20 );

	global $product;

	$product_id = $product->get_id();

	echo '<div class="images">';

	woocommerce_show_product_sale_flash();
	/**
	 * If gallery
	 */
	$attachment_ids = $product->get_gallery_image_ids();

	if ( is_array( $attachment_ids ) && ! empty( $attachment_ids ) ) {

		echo '<ul>';

		if ( has_post_thumbnail( $product_id ) ) {

			$caption = get_post_field( 'post_excerpt', get_post_thumbnail_id( $post_thumbnail_id ) );
			?>
			<li class="stacked-image">
				<a class="lightbox" data-fancybox="wc-stacked-images-<?php echo absint( $product_id ); ?>" href="<?php echo get_the_post_thumbnail_url( $product_id, 'full' ); ?>" data-caption="<?php echo esc_attr( $caption ); ?>">
					<?php echo slikk_kses( $product->get_image( 'large' ) ); ?>
				</a>
			</li>
			<?php
		}

		foreach ( $attachment_ids as $attachment_id ) {
			if ( wp_attachment_is_image( $attachment_id ) ) {

				$caption = get_post_field( 'post_excerpt', $attachment_id );
				?>
				<li class="stacked-image">
					<a class="lightbox" data-fancybox="wc-stacked-images-<?php echo absint( $product_id ); ?>" href="<?php echo wp_get_attachment_url( $attachment_id, 'full' ); ?>" data-caption="<?php echo esc_attr( $caption ); ?>">
						<?php echo wp_get_attachment_image( $attachment_id, 'large' ); ?>
					</a>
				</li>
				<?php
			}
		}

		echo '</ul>';

		/**
		 * If featured image only
		 */
	} elseif ( has_post_thumbnail( $product_id ) ) {
		?>
		<span class="stacked-image">
			<a class="lightbox" data-fancybox="wc-stacked-images-<?php echo absint( $product_id ); ?>" href="<?php echo get_the_post_thumbnail_url( $product_id, 'full' ); ?>">
				<?php echo slikk_kses( $product->get_image( 'large' ) ); ?>
			</a>
		</span>
		<?php
		/**
		 * Placeholder
		 */
	} else {

		$html  = '<span class="woocommerce-product-gallery__image--placeholder">';
		$html .= sprintf( '<img src="%s" alt="%s" class="wp-post-image" />', esc_url( wc_placeholder_img_src() ), esc_html__( 'Awaiting product image', 'slikk' ) );
		$html .= '</span>';

		echo apply_filters( 'woocommerce_single_product_image_thumbnail_html', $html, $attachment_id );
	}

	echo '</div>';
}
add_action( 'woocommerce_before_single_product_summary', 'slikk_single_product_sticky_layout' );

add_filter(
	'woocommerce_product_additional_information_tab_title',
	function( $text ) {
		return esc_html__( 'Details', 'slikk' );
	}
);

/**
 * Add mods
 *
 * @param array $mods
 * @return array $mods
 */
function slikk_add_mods( $mods ) {

	$color_scheme = slikk_get_color_scheme();

	$mods['colors']['options']['secondary_accent_color'] = array(
		'id'        => 'secondary_accent_color',
		'label'     => esc_html__( 'Secondary Accent Color', 'slikk' ),
		'type'      => 'color',
		'transport' => 'postMessage',
		'default'   => $color_scheme[8],
	);

	$mods['loading'] = array(

		'id'      => 'loading',
		'title'   => esc_html__( 'Loading', 'slikk' ),
		'icon'    => 'update',
		'options' => array(

			array(
				'label'   => esc_html__( 'Loading Animation Type', 'slikk' ),
				'id'      => 'loading_animation_type',
				'type'    => 'select',
				'choices' => array(
					'none'             => esc_html__( 'None', 'slikk' ),
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

			'loading_logo' => array(
				'id'          => 'loading_logo',
				'description' => esc_html__( 'The loading animation will be disabled if you upload a loading logo.', 'slikk' ),
				'label'       => esc_html__( 'Optional Loading Logo', 'slikk' ),
				'type'        => 'image',
			),

			array(
				'label'   => esc_html__( 'Loading Logo Animation', 'slikk' ),
				'id'      => 'loading_logo_animation',
				'type'    => 'select',
				'choices' => array(
					'none'  => esc_html__( 'None', 'slikk' ),
					'pulse' => esc_html__( 'Pulse', 'slikk' ),
				),
			),
		),
	);

	$mods['navigation']['options']['side_panel_bg_img'] = array(
		'label' => esc_html__( 'Side Panel Background', 'slikk' ),
		'id'    => 'side_panel_bg_img',
		'type'  => 'image',
	);

	$mods['blog']['options']['post_hero_layout'] = array(
		'label'   => esc_html__( 'Single Post Header Layout', 'slikk' ),
		'id'      => 'post_hero_layout',
		'type'    => 'select',
		'choices' => array(
			''           => esc_html__( 'Default', 'slikk' ),
			'standard'   => esc_html__( 'Standard', 'slikk' ),
			'big'        => esc_html__( 'Big', 'slikk' ),
			'small'      => esc_html__( 'Small', 'slikk' ),
			'fullheight' => esc_html__( 'Full Height', 'slikk' ),
			'none'       => esc_html__( 'No header', 'slikk' ),
		),
	);

	if ( isset( $mods['portfolio'] ) ) {
		$mods['portfolio']['options']['work_hero_layout'] = array(
			'label'   => esc_html__( 'Single Work Header Layout', 'slikk' ),
			'id'      => 'work_hero_layout',
			'type'    => 'select',
			'choices' => array(
				''           => esc_html__( 'Default', 'slikk' ),
				'standard'   => esc_html__( 'Standard', 'slikk' ),
				'big'        => esc_html__( 'Big', 'slikk' ),
				'small'      => esc_html__( 'Small', 'slikk' ),
				'fullheight' => esc_html__( 'Full Height', 'slikk' ),
				'none'       => esc_html__( 'No header', 'slikk' ),
			),
		);
	}

	if ( isset( $mods['shop'] ) && class_exists( 'WooCommerce' ) ) {
		$mods['shop']['options']['product_sticky']            = array(
			'label'       => esc_html__( 'Stacked Images with Sticky Product Details', 'slikk' ),
			'id'          => 'product_sticky',
			'type'        => 'checkbox',
			'description' => esc_html__( 'Not compatible with sidebar layouts.', 'slikk' ),
		);
		$mods['shop']['options']['product_thumbnail_padding'] = array(
			'label' => esc_html__( 'Product Thumbnail Padding', 'slikk' ),
			'id'    => 'product_thumbnail_padding',
			'type'  => 'text',
		);
	}

	return $mods;
}
add_filter( 'slikk_customizer_mods', 'slikk_add_mods', 40 );

/**
 * Remove some params
 */
function slikk_remove_vc_params() {

	if ( function_exists( 'vc_remove_element' ) ) {
		vc_remove_element( 'wvc_page_index' );
		vc_remove_element( 'wvc_interactive_overlays' );
	}

	if ( function_exists( 'vc_remove_param' ) ) {

		// vc_remove_param( 'wvc_product_index', 'product_display' );
		vc_remove_param( 'wvc_product_index', 'product_text_align' );

		vc_remove_param( 'wvc_interactive_links', 'align' );
		vc_remove_param( 'wvc_interactive_links', 'display' );
		vc_remove_param( 'wvc_interactive_overlays', 'align' );
		vc_remove_param( 'wvc_interactive_overlays', 'display' );

		vc_remove_param( 'wvc_team_member', 'layout' );
		vc_remove_param( 'wvc_team_member', 'alignment' );
		vc_remove_param( 'wvc_team_member', 'v_alignment' );
	}
}
add_action( 'init', 'slikk_remove_vc_params' );

/**
 *  Set smooth scroll speed
 *
 * @param string $speed
 * @return string $speed
 */
function slikk_set_smooth_scroll_speed( $speed ) {
	return 1400;
}
add_filter( 'slikk_smooth_scroll_speed', 'slikk_set_smooth_scroll_speed' );
add_filter( 'wvc_smooth_scroll_speed', 'slikk_set_smooth_scroll_speed' );

/**
 *  Set smooth scroll speed
 *
 * @param string $speed
 * @return string $speed
 */
function slikk_set_fp_anim_time( $speed ) {
	return 1000;
}
add_filter( 'wvc_fp_anim_time', 'slikk_set_fp_anim_time' );

/**
 * Add additional JS scripts and functions
 */
function slikk_enqueue_additional_scripts() {

	$version = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? time() : slikk_get_theme_version();

	if ( ! slikk_is_wolf_extension_activated() ) {
		wp_register_style( 'ionicons', get_template_directory_uri() . '/assets/css/lib/fonts/ionicons/ionicons.min.css', array(), slikk_get_theme_version() );

		wp_register_style( 'dripicons', get_template_directory_uri() . '/assets/css/lib/fonts/dripicons-v2/dripicons.min.css', array(), slikk_get_theme_version() );

		wp_register_script( 'countup', get_template_directory_uri() . '/assets/js/lib/countUp.min.js', array(), '1.9.3', true );
	}

	wp_enqueue_style( 'ionicons' );
	wp_enqueue_style( 'dripicons' );

	wp_enqueue_script( 'countup' );

	wp_enqueue_script( 'jquery-effects-core' );
	wp_enqueue_script( 'slikk-custom', get_template_directory_uri() . '/assets/js/t/slikk.js', array( 'jquery' ), $version, true );
}
add_action( 'wp_enqueue_scripts', 'slikk_enqueue_additional_scripts', 100 );

/**
 *  Set smooth scroll easing effect
 *
 * @param string $ease
 * @return string $ease
 */
function slikk_set_smooth_scroll_ease( $ease ) {
	return 'easeOutCubic';
}
add_filter( 'slikk_smooth_scroll_ease', 'slikk_set_smooth_scroll_ease' );
add_filter( 'wvc_smooth_scroll_ease', 'slikk_set_smooth_scroll_ease' );
add_filter( 'wvc_fp_easing', 'slikk_set_smooth_scroll_ease' );

/**
 * Add mobile alt body class
 *
 * @param array
 * @return array
 */
function slikk_additional_bodu_classes( $classes ) {

	$classes[] = 'mobile-menu-alt';

	$sticky_details_meta   = slikk_get_inherit_mod( 'product_sticky' ) && 'no' !== slikk_get_inherit_mod( 'product_sticky' );
	$single_product_layout = slikk_get_inherit_mod( 'product_single_layout' );

	if ( is_singular( 'product' ) && $sticky_details_meta && 'sidebar-right' !== $single_product_layout && 'sidebar-left' !== $single_product_layout ) {
		$classes[] = 'sticky-product-details';
	}

	return $classes;

}
add_filter( 'body_class', 'slikk_additional_bodu_classes' );

/**
 * Returns CSS for the color schemes.
 *
 * @param array $colors Color scheme colors.
 * @return string Color scheme CSS.
 */
function slikk_edit_color_scheme_css( $output, $colors ) {

	extract( $colors );

	$output = '';

	$border_color           = vsprintf( 'rgba( %s, 0.03)', slikk_hex_to_rgb( $strong_text_color ) );
	$overlay_panel_bg_color = vsprintf( 'rgba( %s, 0.95)', slikk_hex_to_rgb( $submenu_background_color ) );

	$link_selector       = '.link, p:not(.attachment) > a:not(.no-link-style):not(.button):not(.button-download):not(.added_to_cart):not(.button-secondary):not(.menu-link):not(.filter-link):not(.entry-link):not(.more-link):not(.wvc-image-inner):not(.wvc-button):not(.wvc-bigtext-link):not(.wvc-fittext-link):not(.ui-tabs-anchor):not(.wvc-icon-title-link):not(.wvc-icon-link):not(.wvc-social-icon-link):not(.wvc-team-member-social):not(.wolf-tweet-link):not(.author-link):not(.gallery-quickview)';
	$link_selector_after = '.link:after, p:not(.attachment) > a:not(.no-link-style):not(.button):not(.button-download):not(.added_to_cart):not(.button-secondary):not(.menu-link):not(.filter-link):not(.entry-link):not(.more-link):not(.wvc-image-inner):not(.wvc-button):not(.wvc-bigtext-link):not(.wvc-fittext-link):not(.ui-tabs-anchor):not(.wvc-icon-title-link):not(.wvc-icon-link):not(.wvc-social-icon-link):not(.wvc-team-member-social):not(.wolf-tweet-link):not(.author-link):not(.gallery-quickview):after';

	$output .= "/* Color Scheme */

	/* Body Background Color */
	body,
	.frame-border{
		background-color: $body_background_color;
	}

	/* Page Background Color */
	.site-header,
	.post-header-container,
	.content-inner,
	#logo-bar,
	.nav-bar,
	.loading-overlay,
	.no-hero #hero,
	.wvc-font-default,
	#topbar{
		background-color: $page_background_color;
	}

	.spinner:before,
	.spinner:after{
		background-color: $page_background_color;
	}

	/* Submenu color */
	#site-navigation-primary-desktop .mega-menu-panel,
	#site-navigation-primary-desktop ul.sub-menu,
	#mobile-menu-panel,
	.offcanvas-menu-panel,
	.lateral-menu-panel,
	.cart-panel,
	.wwcs-selector,
	.currency-switcher .woocs-style-1-dropdown .woocs-style-1-dropdown-menu{
		background:$submenu_background_color;
	}

	.currency-switcher .woocs-style-1-dropdown .woocs-style-1-dropdown-menu li{
		background-color:$submenu_background_color!important;
	}

	.cart-panel{
		background:$submenu_background_color!important;
	}

	.menu-hover-style-border-top .nav-menu li:hover,
	.menu-hover-style-border-top .nav-menu li.current_page_item,
	.menu-hover-style-border-top .nav-menu li.current-menu-parent,
	.menu-hover-style-border-top .nav-menu li.current-menu-ancestor,
	.menu-hover-style-border-top .nav-menu li.current-menu-item,
	.menu-hover-style-border-top .nav-menu li.menu-link-active{
		box-shadow: inset 0px 5px 0px 0px $submenu_background_color;
	}

	.menu-hover-style-plain .nav-menu li:hover,
	.menu-hover-style-plain .nav-menu li.current_page_item,
	.menu-hover-style-plain .nav-menu li.current-menu-parent,
	.menu-hover-style-plain .nav-menu li.current-menu-ancestor,
	.menu-hover-style-plain .nav-menu li.current-menu-item,
	.menu-hover-style-plain .nav-menu li.menu-link-active{
		background:$submenu_background_color;
	}

	.panel-closer-overlay{
		background:$submenu_background_color;
	}

	.overlay-menu-panel{
		background:$overlay_panel_bg_color;
	}

	/* Sub menu Font Color */
	.nav-menu-desktop li ul li:not(.menu-button-primary):not(.menu-button-secondary) .menu-item-text-container,
	.nav-menu-desktop li ul.sub-menu li:not(.menu-button-primary):not(.menu-button-secondary).menu-item-has-children > a:before,
	.nav-menu-desktop li ul li.not-linked > a:first-child .menu-item-text-container,
	.wwcs-selector,
	.currency-switcher .woocs-style-1-dropdown .woocs-style-1-dropdown-menu,
	.widget .woocommerce-Price-amount{
		color: $submenu_font_color;
	}

	.nav-menu-vertical li a,
	.nav-menu-mobile li a,
	.nav-menu-vertical li.menu-item-has-children:before,
	.nav-menu-vertical li.page_item_has_children:before,
	.nav-menu-vertical li.active:before,
	.nav-menu-mobile li.menu-item-has-children:before,
	.nav-menu-mobile li.page_item_has_children:before,
	.nav-menu-mobile li.active:before{
		color: $submenu_font_color!important;
	}

	.lateral-menu-panel .wvc-icon:before{
		color: $submenu_font_color!important;
	}

	.nav-menu-desktop li ul.sub-menu li.menu-item-has-children > a:before{
		color: $submenu_font_color;
	}

	body.wolf.side-panel-toggle.menu-style-transparent .hamburger-icon .line,
	body.wolf.side-panel-toggle.menu-style-semi-transparent-white .hamburger-icon .line,
	body.wolf.side-panel-toggle.menu-style-semi-transparent-black .hamburger-icon .line {
		//background-color: $submenu_font_color !important;
	}

	.cart-panel,
	.cart-panel a,
	.cart-panel strong,
	.cart-panel b{
		color: $submenu_font_color!important;
	}

	/* Accent Color */
	.accent{
		color:$accent_color;
	}

	#slikk-loading-point{
		color:$accent_color;
	}

	.wvc-single-image-overlay-title span:after,
	.work-meta-value a:hover{
		color:$accent_color;
	}

	.nav-menu li.sale .menu-item-text-container:before,
	.nav-menu-mobile li.sale .menu-item-text-container:before,
	.wolf-share-button-count{
		background:$accent_color!important;
	}

	.entry-post-standard:hover.entry-title,
	.entry-post-grid_classic:hover .entry-title{
		color:$accent_color!important;
	}

	.entry-metro .entry-container{
		background:$accent_color;
	}

	.menu-hover-style-s-underline .nav-menu-desktop li a span.menu-item-text-container:after{
		background-color:$accent_color!important;
	}

	.widget_price_filter .ui-slider .ui-slider-range,
	mark,
	p.demo_store,
	.woocommerce-store-notice{
		background-color:$accent_color;
	}

	.button-secondary{
		background-color:$accent_color;
		border-color:$accent_color;
	}

	.nav-menu li.menu-button-primary > a:first-child > .menu-item-inner{
		border-color:$accent_color;
		background-color:$accent_color;
	}

	.nav-menu li.menu-button-secondary > a:first-child > .menu-item-inner{
		border-color:$accent_color;
	}

	.nav-menu li.menu-button-secondary > a:first-child > .menu-item-inner:hover{
		background-color:$accent_color;
	}

	.fancybox-thumbs>ul>li:before{
		border-color:$accent_color;
	}

	.added_to_cart, .button, .button-download, .more-link, .wvc-mailchimp-submit, input[type=submit]{
		background-color:$accent_color;
		border-color:$accent_color;
	}

	.wvc-background-color-accent{
		background-color:$accent_color;
	}

	// .entry-post-grid_classic .category-label:hover,
	// .entry-post-metro .category-label:hover{
	// 	background-color:$accent_color;
	// }

	.page-numbers:hover:before,
	.page-numbers.current:before{
		background-color:$accent_color!important;
	}

	.wvc-highlight-accent{
		background-color:$accent_color;
		color:#fff;
	}

	.wvc-icon-background-color-accent{
		box-shadow:0 0 0 0 $accent_color;
		background-color:$accent_color;
		color:$accent_color;
		border-color:$accent_color;
	}

	.wvc-icon-background-color-accent .wvc-icon-background-fill{
		box-shadow:0 0 0 0 $accent_color;
		background-color:$accent_color;
	}

	.wvc-button-background-color-accent{
		background-color:$accent_color;
		color:$accent_color;
		border-color:$accent_color;
	}

	.wvc-button-background-color-accent .wvc-button-background-fill{
		box-shadow:0 0 0 0 $accent_color;
		background-color:$accent_color;
	}

	.wvc-svg-icon-color-accent svg * {
		stroke:$accent_color!important;
	}

	.wvc-one-page-nav-bullet-tip{
		background-color: $accent_color;
	}

	.wvc-one-page-nav-bullet-tip:before{
		border-color: transparent transparent transparent $accent_color;
	}

	.accent,
	.comment-reply-link,
	.bypostauthor .avatar{
		color:$accent_color;
	}

	.wvc-button-color-button-accent,
	.more-link,
	.buton-accent{
		background-color: $accent_color;
		border-color: $accent_color;
	}

	.wvc-ils-active .wvc-ils-item-title:after,
	.wvc-interactive-link-item a:hover .wvc-ils-item-title:after {
	    color:$accent_color;
	}

	.wvc-io-active .wvc-io-item-title:after,
	.wvc-interactive-overlay-item a:hover .wvc-io-item-title:after {
	    color:$accent_color;
	}

	/* WVC icons */
	.wvc-icon-color-accent{
		color:$accent_color;
	}

	.wvc-icon-background-color-accent{
		box-shadow:0 0 0 0 $accent_color;
		background-color:$accent_color;
		color:$accent_color;
		border-color:$accent_color;
	}

	.wvc-icon-background-color-accent .wvc-icon-background-fill{
		box-shadow:0 0 0 0 $accent_color;
		background-color:$accent_color;
	}

	#ajax-progress-bar,
	.cart-icon-product-count{
		background:$accent_color;
	}

	.background-accent,
	.mejs-container .mejs-controls .mejs-time-rail .mejs-time-current,
	.mejs-container .mejs-controls .mejs-time-rail .mejs-time-current, .mejs-container .mejs-controls .mejs-horizontal-volume-slider .mejs-horizontal-volume-current{
		background: $accent_color!important;
	}

	.trigger{
		background-color: $accent_color!important;
		border : solid 1px $accent_color;
	}

	.bypostauthor .avatar {
		border: 3px solid $accent_color;
	}

	::selection {
		background: $accent_color;
	}
	::-moz-selection {
		background: $accent_color;
	}

	.spinner{
		color:$accent_color;
	}

	/*********************
		WVC
	***********************/

	.wvc-icon-box.wvc-icon-type-circle .wvc-icon-no-custom-style.wvc-hover-fill-in:hover, .wvc-icon-box.wvc-icon-type-square .wvc-icon-no-custom-style.wvc-hover-fill-in:hover {
		-webkit-box-shadow: inset 0 0 0 1em $accent_color;
		box-shadow: inset 0 0 0 1em $accent_color;
		border-color: $accent_color;
	}

	.wvc-pricing-table-featured-text,
	.wvc-pricing-table-featured .wvc-pricing-table-button a{
		background: $accent_color;
	}

	.wvc-pricing-table-featured .wvc-pricing-table-price,
	.wvc-pricing-table-featured .wvc-pricing-table-currency {
		color: $accent_color;
	}

	.wvc-pricing-table-featured .wvc-pricing-table-price-strike:before {
		background-color: $accent_color;
	}

	.wvc-team-member-social-container a:hover{
		color: $accent_color;
	}

	/* Main Text Color */
	body,
	.nav-label{
		color:$main_text_color;
	}

	/*.spinner-color, .sk-child:before, .sk-circle:before, .sk-cube:before{
		background-color: $main_text_color!important;
	}*/

	/* Secondary Text Color */

	/* Strong Text Color */
	a,strong,
	.products li .price,
	.products li .star-rating,
	.wr-print-button,
	table.cart thead, #content table.cart thead{
		color: $strong_text_color;
	}

	.menu-hover-style-p-underline .nav-menu-desktop li a span.menu-item-text-container:after,
	.menu-hover-style-underline .nav-menu-desktop li a span.menu-item-text-container:after,
	.menu-hover-style-underline-centered .nav-menu-desktop li a span.menu-item-text-container:after{
		background: $strong_text_color;
	}

	body.wolf.menu-hover-style-overline .nav-menu-desktop li a span.menu-item-text-container:after{
		background: $accent_color!important;
	}

	.menu-hover-style-line .nav-menu li a span.menu-item-text-container:after{
		background-color: $strong_text_color;
	}

	.bit-widget-container,
	.entry-link{
		color: $strong_text_color;
	}

	.wr-stars>span.wr-star-voted:before, .wr-stars>span.wr-star-voted~span:before{
		color: $strong_text_color!important;
	}

	/* Border Color */
	.author-box,
	input[type=text],
	input[type=search],
	input[type=tel],
	input[type=time],
	input[type=url],
	input[type=week],
	input[type=password],
	input[type=checkbox],
	input[type=color],
	input[type=date],
	input[type=datetime],
	input[type=datetime-local],
	input[type=email],
	input[type=month],
	input[type=number],
	select,
	textarea{
		border-color:$border_color;
	}

	.widget-title,
	.woocommerce-tabs ul.tabs{
		border-bottom-color:$border_color;
	}

	.widget_layered_nav_filters ul li a{
		border-color:$border_color;
	}

	hr{
		background:$border_color;
	}
	";

	$link_selector_after  = '.link:after, .underline:after, p:not(.attachment) > a:not(.no-link-style):not(.button):not(.button-download):not(.added_to_cart):not(.button-secondary):not(.menu-link):not(.filter-link):not(.entry-link):not(.more-link):not(.wvc-image-inner):not(.wvc-button):not(.wvc-bigtext-link):not(.wvc-fittext-link):not(.ui-tabs-anchor):not(.wvc-icon-title-link):not(.wvc-icon-link):not(.wvc-social-icon-link):not(.wvc-team-member-social):not(.wolf-tweet-link):not(.author-link):after';
	$link_selector_before = '.link:before, .underline:before, p:not(.attachment) > a:not(.no-link-style):not(.button):not(.button-download):not(.added_to_cart):not(.button-secondary):not(.menu-link):not(.filter-link):not(.entry-link):not(.more-link):not(.wvc-image-inner):not(.wvc-button):not(.wvc-bigtext-link):not(.wvc-fittext-link):not(.ui-tabs-anchor):not(.wvc-icon-title-link):not(.wvc-icon-link):not(.wvc-social-icon-link):not(.wvc-team-member-social):not(.wolf-tweet-link):not(.author-link):before';

	$output .= "

		$link_selector_after,
		$link_selector_before{
			//background: $accent_color!important;
		}

		.category-filter ul li a:before{
			background-color:$accent_color!important;
		}

		.category-label{
			background:$accent_color!important;
		}

		#back-to-top:hover{
			background:$accent_color!important;
		}

		.entry-video:hover .video-play-button,
		.video-opener:hover{
			border-left-color:$accent_color!important;
		}

		body.wolf.menu-hover-style-highlight .nav-menu-desktop li a span.menu-item-text-container:after{
			background: $accent_color!important;
		}

		.widget.widget_tag_cloud .tagcloud a:hover,
		.wvc-font-dark .widget.widget_tag_cloud .tagcloud a:hover,
		.wvc-font-light .widget.widget_tag_cloud .tagcloud a:hover{
			color:$accent_color!important;
		}

		.wvc-breadcrumb a:hover{
			color:$accent_color!important;
		}

		.nav-menu-desktop > li:not(.menu-button-primary):not(.menu-button-secondary) > a:first-child .menu-item-text-container:before{
			color:$accent_color;
		}

		// .accent-color-light .category-label{
		// 	color:#333!important;
		// }

		// .accent-color-dark .category-label{
		// 	color:#fff!important;
		// }

		.accent-color-light #back-to-top:hover:after{
			color:#333!important;
		}

		.accent-color-dark #back-to-top:hover:after{
			color:#fff!important;
		}

		.coupon .button:hover{
			background:$accent_color!important;
			border-color:$accent_color!important;
		}

		.slikk-button-primary,
		.slikk-button-special-primary{
			background-color:$accent_color;
			border-color:$accent_color;
		}

		.slikk-button-secondary,
		.slikk-button-special-secondary{
			background-color:$secondary_accent_color;
			border-color:$secondary_accent_color;
		}

		.slikk-button-primary-alt:hover{
			background-color:$accent_color;
			border-color:$accent_color;
		}

		.slikk-button-secondary-alt:hover{
			background-color:$secondary_accent_color;
			border-color:$secondary_accent_color;
		}

		button.wvc-mailchimp-submit,
		.login-submit #wp-submit,
		.single_add_to_cart_button,
		.wc-proceed-to-checkout .button,
		.woocommerce-form-login .button,
		.woocommerce-alert .button,
		.woocommerce-message .button{
			background:$accent_color;
			border-color:$accent_color;
		}

		.woocommerce-alert .button,
		.woocommerce-message .button{
			background-color:$accent_color!important;
			border-color:$accent_color;
			color:white!important;
		}

		.audio-shortcode-container .mejs-container .mejs-controls > .mejs-playpause-button{
			background:$accent_color;
		}

		ul.wc-tabs li:hover,
		ul.wc-tabs li.ui-tabs-active,
		ul.wc-tabs li.active,
		ul.wvc-tabs-menu li:hover,
		ul.wvc-tabs-menu li.ui-tabs-active,
		ul.wvc-tabs-menu li.active,
		.woocommerce-MyAccount-navigation ul li:hover,
		.woocommerce-MyAccount-navigation ul li.is-active{
			border-top-color: $accent_color;
		}

		.wvc-accordion .wvc-accordion-tab.ui-state-active {
    			border-bottom-color: $accent_color;
    		}

		/* Secondary accent color */
		.wvc-text-color-secondary_accent{
			color:$secondary_accent_color;
		}

		.entry-product ins .woocommerce-Price-amount,
		.entry-single-product ins .woocommerce-Price-amount{
			color:$accent_color;
		}

		.wolf-tweet-text a,
		.wolf ul.wolf-tweet-list li:before,
		.wolf-bigtweet-content:before,
		.wolf-bigtweet-content a{
			color:$accent_color!important;
		}

		.wvc-background-color-secondary_accent{
			background-color:$secondary_accent_color;
		}

		.wvc-highlight-secondary_accent{
			background-color:$secondary_accent_color;
			color:#fff;
		}

		.wvc-icon-background-color-secondary_accent{
			box-shadow:0 0 0 0 $secondary_accent_color;
			background-color:$secondary_accent_color;
			color:$secondary_accent_color;
			border-color:$secondary_accent_color;
		}

		.wvc-icon-background-color-secondary_accent .wvc-icon-background-fill{
			box-shadow:0 0 0 0 $secondary_accent_color;
			background-color:$secondary_accent_color;
		}

		.wvc-button-background-color-secondary_accent{
			background-color:$secondary_accent_color;
			color:$secondary_accent_color;
			border-color:$secondary_accent_color;
		}

		.wvc-button-background-color-secondary_accent .wvc-button-background-fill{
			box-shadow:0 0 0 0 $secondary_accent_color;
			background-color:$secondary_accent_color;
		}

		.wvc-svg-icon-color-secondary_accent svg * {
			stroke:$secondary_accent_color!important;
		}

		.wvc-button-color-button-secondary_accent{
			background-color: $secondary_accent_color;
			border-color: $secondary_accent_color;
		}

		/* WVC icons */
		.wvc-icon-color-secondary_accent{
			color:$secondary_accent_color;
		}

		.wvc-icon-background-color-secondary_accent{
			box-shadow:0 0 0 0 $secondary_accent_color;
			background-color:$secondary_accent_color;
			color:$secondary_accent_color;
			border-color:$secondary_accent_color;
		}

		.wvc-icon-background-color-secondary_accent .wvc-icon-background-fill{
			box-shadow:0 0 0 0 $secondary_accent_color;
			background-color:$secondary_accent_color;
		}

	";

	// If dark
	if ( preg_match( '/dark/', slikk_get_theme_mod( 'color_scheme' ) ) ) {
		$output .= ".wvc-background-color-default.wvc-font-light{
			background-color:$page_background_color;
		}";
	}

	// if light
	if ( preg_match( '/light/', slikk_get_theme_mod( 'color_scheme' ) ) ) {
		$output .= ".wvc-background-color-default.wvc-font-dark{
			background-color:$page_background_color;
		}";
	}

	return $output;
}
add_filter( 'slikk_color_scheme_output', 'slikk_edit_color_scheme_css', 10, 2 );

/**
 * Additional styles
 */
function slikk_output_additional_styles() {

	$output = '';

	/* Content inner background */
	$c_ci_bg_color = slikk_get_inherit_mod( 'content_inner_bg_color' );

	if ( $c_ci_bg_color ) {
		$output .= ".content-inner{
	background-color: $c_ci_bg_color;
}";
	}

	/* Product thumbnail padding */
	$p_t_padding = slikk_get_inherit_mod( 'product_thumbnail_padding' );

	if ( $p_t_padding ) {
		$p_t_padding = slikk_sanitize_css_value( $p_t_padding );
		$output     .= ".entry-product-masonry_overlay_quickview .product-thumbnail-container,
.entry-product-grid_overlay_quickview .product-thumbnail-container,
.wwcq-product-quickview-container .product-images .slide-content img{
	padding: $p_t_padding;
}";
	}

	$output .= '.sticky-post:before{content: "' . esc_html__( 'Featured', 'slikk' ) . '";}';

	if ( ! SCRIPT_DEBUG ) {
		$output = slikk_compact_css( $output );
	}

	wp_add_inline_style( 'slikk-style', $output );
}
add_action( 'wp_enqueue_scripts', 'slikk_output_additional_styles', 999 );

/**
 * Save modal window content after import
 */
function slikk_set_modal_window_content_after_import() {
	$post = get_page_by_title( 'Modal Window Content', OBJECT, 'wvc_content_block' );

	if ( $post && function_exists( 'wvc_update_option' ) ) {
		wvc_update_option( 'modal_window', 'content_block_id', $post->ID );
	}
}
add_action( 'pt-ocdi/after_import', 'slikk_set_modal_window_content_after_import' );

/**
 * Filter lightbox settings
 */
function slikk_filter_lightbox_settings( $settings ) {

	$settings['transitionEffect'] = 'fade';
	$settings['buttons']          = array(
		'zoom',
		'share',
		'close',
	);

	return $settings;
}
add_filter( 'slikk_fancybox_settings', 'slikk_filter_lightbox_settings' );
