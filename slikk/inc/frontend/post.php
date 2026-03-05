<?php
/**
 * Post hooks functions
 *
 * A function that returns any loop of any post type and push it to the slikk_posts hook
 * Cool right?
 *
 * @package WordPress
 * @subpackage Slikk
 * @version 1.4.2
 */

defined( 'ABSPATH' ) || exit;

/**
 * Output posts
 *
 * @param  [array] $atts an array of options to display different post types.
 * @return void
 */
function slikk_output_posts( $atts ) {

	if ( defined( 'DOING_AJAX' ) && DOING_AJAX ) {
		wp_verify_nonce( $atts['nonce'], 'post_index_content' );
	}

	/* Retrieve all VC shortcode attributes and/or set default values */
	$atts = wp_parse_args(
		$atts,
		array(

			'post_type'                              => 'post',
			'posts_per_page'                         => -1,
			'paged'                                  => null,

			/* Common attributes */
			'grid_padding'                           => slikk_get_theme_mod( 'post_grid_padding', 'yes' ),
			'item_animation'                         => slikk_get_theme_mod( 'post_item_animation' ),
			'columns'                                => 'default',
			'include_ids'                            => '',
			'exclude_ids'                            => '',
			'ignore_sticky_posts'                    => false,
			'exclude_sticky_posts'                   => false,
			'offset'                                 => 0,

			/* Common cosmetic attributes */
			'overlay_color'                          => apply_filters( 'wvc_default_item_overlay_color', 'black' ),
			'overlay_custom_color'                   => apply_filters( 'wvc_default_item_overlay_custom_color', '' ),
			'overlay_text_color'                     => apply_filters( 'wvc_default_item_overlay_text_color', 'white' ),
			'overlay_text_custom_color'              => '',
			'overlay_opacity'                        => apply_filters( 'wvc_default_item_overlay_opacity', 44 ),
			'caption_text_alignment'                 => apply_filters( 'wvc_default_caption_text_align', 'center' ),
			'caption_v_align'                        => apply_filters( 'wvc_default_caption_v_align', 'middle' ),

			/* Post */
			'post_index'                             => false,
			'post_display'                           => slikk_get_theme_mod( 'post_display', 'standard' ),
			'post_metro_pattern'                     => 'auto',
			'post_module'                            => 'grid',
			'post_thumbnail_size'                    => 'standard',
			'post_layout'                            => 'standard',
			'post_category_filter'                   => slikk_get_theme_mod( 'post_category_filter', false ),
			'post_excerpt_type'                      => 'auto', // for standard post type.
			'post_excerpt_length'                    => 'shorten',
			'post_display_elements'                  => slikk_get_theme_mod( 'post_display_elements', 'show_thumbnail,show_date,show_text,show_author,show_category' ),
			'post_show_thumbnail'                    => '',
			'post_show_date'                         => '',
			'post_show_text'                         => '',
			'post_show_author'                       => '',
			'post_show_category'                     => '',
			'post_show_tags'                         => '',

			'post_alternate_thumbnail_position'      => '',
			'category'                               => '',
			'category_exclude'                       => '',
			'set_category_var'                       => '',
			'tag'                                    => '',
			'tag_exclude'                            => '',
			'pagination'                             => 'none',
			'post_category_link_id'                  => '',

			/* Page */
			'page_display'                           => apply_filters( 'page_post_display', 'grid' ), // phpcs:ignore
			'page_by_parent'                         => '',

			/* Works */
			'work_index'                             => false,
			'work_display'                           => slikk_get_theme_mod( 'work_display', 'grid' ),
			'work_module'                            => 'grid',
			'work_thumbnail_size'                    => 'standard',
			'work_custom_thumbnail_size'             => '',
			'work_layout'                            => 'overlay',
			'work_is_gallery'                        => '',
			'work_category_filter'                   => slikk_get_theme_mod( 'work_category_filter', true ),
			'work_category_filter_text_alignment'    => 'center',
			'work_hover_effect'                      => apply_filters( 'work_default_hover_effect', 'default' ), // phpcs:ignore
			'work_type_include'                      => '',
			'work_type_exclude'                      => '',

			/* Products */
			'product_index'                          => false,
			'product_display'                        => slikk_get_theme_mod( 'product_display', 'grid_classic' ),
			'product_metro_pattern'                  => 'pattern-1',
			'product_text_align'                     => '',
			'product_module'                         => 'grid',
			'product_layout'                         => '',
			'product_cat'                            => '',
			'product_meta'                           => '',
			'product_category_link_id'               => '',
			'orderby'                                => '',
			'order'                                  => '',

			/* Releases */
			'release_index'                          => false,
			'release_display'                        => slikk_get_theme_mod( 'release_display', 'grid' ),
			'release_metro_pattern'                  => 'pattern-1',
			'release_hover_effect'                   => apply_filters( 'release_default_hover_effect', 'default' ), // phpcs:ignore
			'release_category_filter'                => slikk_get_theme_mod( 'release_category_filter', false ),
			'release_category_filter_text_alignment' => 'center',
			'release_module'                         => 'grid',
			'release_thumbnail_size'                 => 'square',
			'release_custom_thumbnail_size'          => '',
			'release_layout'                         => 'standard',
			'release_alternate_thumbnail_position'   => '',
			'release_add_buy_links'                  => false,
			'release_meta'                           => '',
			'band_include'                           => '',
			'band_exclude'                           => '',
			'label_include'                          => '',
			'label_exclude'                          => '',
			'genre_include'                          => '',
			'genre_exclude'                          => '',
			'release_category_link_id'               => '',

			/* Events */
			'event_index'                            => false,
			'event_display'                          => slikk_get_theme_mod( 'event_display', 'list' ),
			'event_module'                           => 'grid',
			'event_thumbnail_size'                   => 'standard',
			'event_custom_thumbnail_size'            => '',
			'event_location'                         => 'location',
			'artist_include'                         => '',
			'artist_exclude'                         => '',
			'timeline'                               => 'future',
			'event_category_link_id'                 => '',

			/* MP Events */
			'mp_event_index'                         => false,
			'mp_event_display'                       => slikk_get_theme_mod( 'mp_event_display', 'grid' ),
			'mp_event_module'                        => 'grid',
			'mp_event_category_include'              => '',
			'mp_event_category_exclude'              => '',
			'mp_event_tag_include'                   => '',
			'mp_event_tag_exclude'                   => '',

			/* Videos */
			'video_index'                            => false,
			'video_display'                          => slikk_get_theme_mod( 'video_display', 'grid' ),
			'video_layout'                           => 'overlay',
			'video_module'                           => 'grid',
			'video_preview'                          => false,
			'video_onclick'                          => slikk_get_theme_mod( 'video_onclick', 'lightbox' ),
			'video_category_filter'                  => slikk_get_theme_mod( 'video_category_filter', false ),
			'video_category_filter_text_alignment'   => 'center',
			'video_type_include'                     => '',
			'video_type_exclude'                     => '',
			'video_tag_include'                      => '',
			'video_tag_exclude'                      => '',
			'video_category_link_id'                 => '',
			'video_thumbnail_size'                   => '',
			'video_custom_thumbnail_size'            => '',

			/* Artists */
			'artist_index'                           => false,
			'artist_display'                         => slikk_get_theme_mod( 'artist_display', 'list' ),
			'artist_metro_pattern'                   => 'auto',
			'artist_hover_effect'                    => apply_filters( 'artist_default_hover_effect', 'default' ), // phpcs:ignore
			'artist_module'                          => 'grid',
			'artist_category_filter'                 => slikk_get_theme_mod( 'artist_category_filter', false ),
			'artist_category_filter_text_alignment'  => 'center',
			'artist_thumbnail_size'                  => 'standard',
			'artist_custom_thumbnail_size'           => '',
			'artist_genre_include'                   => '',
			'artist_genre_exclude'                   => '',

			/* Albums */
			'gallery_index'                          => false,
			'gallery_display'                        => slikk_get_theme_mod( 'gallery_display', 'grid' ),
			'gallery_module'                         => 'grid',
			'gallery_thumbnail_size'                 => 'standard',
			'gallery_custom_thumbnail_size'          => 'standard',
			'gallery_layout'                         => 'standard',
			'gallery_category_filter'                => slikk_get_theme_mod( 'gallery_category_filter', true ),
			'gallery_category_filter_text_alignment' => 'center',
			'gallery_hover_effect'                   => apply_filters( 'gallery_default_hover_effect', 'default' ), // phpcs:ignore
			'gallery_type_include'                   => '',
			'gallery_type_exclude'                   => '',
			'gallery_type_set'                       => '',

			/* Attachments */
			'attachment_index'                       => false,
			'attachment_display'                     => slikk_get_theme_mod( 'attachment_display', 'masonry_horizontal' ),
			'attachment_thumbnail_size'              => 'standard',
			'attachment_custom_thumbnail_size'       => 'standard',
			'attachemnt_orderby'                     => '',
			'attachment_photo_category_include'      => '',
			'attachment_photo_category_exclude'      => '',
			'attachment_photo_tag_include'           => '',
			'attachment_photo_tag_exclude'           => '',
			'attachment_author'                      => '',

			/* Additional styles */
			'hide_class'                             => '',
			'inline_style'                           => '',
			'el_class'                               => '',
			'el_id'                                  => '',
			'css'                                    => '',
		)
	);

	$clean_atts  = array_filter(
		$atts,
		function( $var ) {
			return ( $var );
		}
	); // clean empty atts for json params.
	$json_params = wp_json_encode( $clean_atts );

	$atts = apply_filters( 'slikk_post_module_atts', $atts );

	extract( $atts ); // phpcs:ignore
	if ( 'yes' === $post_show_thumbnail ||
			'yes' === $post_show_date ||
			'yes' === $post_show_text ||
			'yes' === $post_show_author ||
			'yes' === $post_show_category ||
			'yes' === $post_show_tags ) {

		$post_display_elements = '';

		$group_checkbox_options = array( 'thumbnail', 'date', 'text', 'author', 'category', 'tags' );

		foreach ( $group_checkbox_options as $group_checkbox_option ) {

			if ( 'yes' === ${'post_show_' . $group_checkbox_option} ) {

				$post_display_elements .= ',show_' . $group_checkbox_option;
			}
		}

		$post_display_elements = trim( $post_display_elements, ',' );
	}
	$posts_per_page = ( isset( ${$post_type . 's_per_page'} ) ) ? ${$post_type . 's_per_page'} : $posts_per_page;
	$posts_per_page = ( $posts_per_page ) ? $posts_per_page : -1;
	$unique_id = uniqid( 'items-' . esc_attr( $post_type ) . '-' );
	$id        = ( $el_id ) ? $el_id : $unique_id;
	$layout = ( isset( ${$post_type . '_layout'} ) ) ? ${$post_type . '_layout'} : 'standard';
	$layout = apply_filters( 'slikk_post_module_layout', $layout, $atts );
	$display = ( isset( ${$post_type . '_display'} ) ) ? ${$post_type . '_display'} : 'standard';
	if ( 'mp-event' === $post_type && isset( $mp_event_display ) ) {
		$display = $mp_event_display;
	}

	$display = apply_filters( 'slikk_post_module_display', $display, $atts );
	$metro_pattern = ( isset( ${$post_type . '_metro_pattern'} ) ) ? ${$post_type . '_metro_pattern'} : 'auto';
	$metro_pattern = apply_filters( 'slikk_post_module_metro_pattern', $metro_pattern, $atts );
	$module = ( isset( ${$post_type . '_module'} ) ) ? ${$post_type . '_module'} : 'grid';
	$module = apply_filters( 'slikk_post_module_module', $module, $atts );
	$category_filter = ( isset( ${$post_type . '_category_filter'} ) ) ? slikk_attr_bool( ${$post_type . '_category_filter'} ) : false;

	$thumbnail_size        = ( isset( ${$post_type . '_thumbnail_size'} ) ) ? ${$post_type . '_thumbnail_size'} : 'standard';
	$custom_thumbnail_size = ( isset( ${$post_type . '_custom_thumbnail_size'} ) ) ? ${$post_type . '_custom_thumbnail_size'} : '';
	$custom_thumbnail_size = apply_filters( 'slikk_post_module_custom_thumbnail_size', $custom_thumbnail_size, $display, $atts );

	$is_index = ( isset( ${$post_type . '_index'} ) ) ? slikk_attr_bool( ${$post_type . '_index'} ) : false;

	$inline_style  = slikk_sanitize_css_field( $inline_style ); // sanitize user CSS input.
	$inline_style .= slikk_shortcode_custom_style( $css ); // add VC CSS from custom class.
	$class  = $el_class;
	$class .= " $hide_class clearfix items wvc-element wolf-core-element entry-grid-loading";
	$class .= ' ' . $post_type . '-items';
	$class .= ' ' . $post_type . 's';
	$class .= " caption-text-align-$caption_text_alignment";
	$class .= " caption-valign-$caption_v_align";
	$class .= " grid-padding-$grid_padding";

	$class .= " display-$display";
	$class .= " $post_type-display-$display";

	if ( class_exists( 'Wolf_Core' ) ) {
		$class .= ' wolf-core-element';
	} else {
		$class .= ' wvc-element';
	}

	if ( preg_match( '/metro/', $display ) ) {
		$class .= " metro-pattern-$metro_pattern";
		$class .= " $post_type-metro-pattern-$metro_pattern";
	}

	$class .= " module-$module";
	$class .= " $post_type-module-$module";

	$class .= " items-thumbnail-size-$thumbnail_size";

	$class .= " layout-$layout";
	$class .= " $post_type-layout-$layout";

	$paginated_post_types = array( 'post', 'product', 'event', 'release', 'attachment', 'gallery', 'video', 'work', 'artist', 'mp-event' );
	$pagination           = ( in_array( $post_type, $paginated_post_types, true ) ) ? $pagination : 'none';

	$class .= " pagination-$pagination";
	$not_grid = array( 'masonry_horizontal', 'list', 'list_minimal', 'metro', 'metro_modern', 'mosaic', 'standard', 'standard_modern', 'lateral', 'offgrid', 'metro_overlay_quickview', 'metro_modern_alt', 'parallax' );

	$is_list = in_array( $display, array( 'list', 'list_minimal', 'text-background' ), true );

	if ( $is_list ) {
		$class .= ' list';
	}

	$metro_display = array( 'metro', 'metro_modern', 'metro_overlay_quickview', 'metro_modern_alt' );

	if ( ! in_array( $display, $not_grid, true ) ) {

		$class .= ' grid';

	} elseif ( in_array( $display, $metro_display, true ) ) {

		$class .= ' metro';

	} else {

		$class .= ' list';
	}

	$masonry_display = array( 'masonry', 'masonry_modern', 'metro', 'metro_modern', 'masonry_overlay_quickview', 'metro_overlay_quickview', 'metro_modern_alt' );

	if ( in_array( $display, $masonry_display, true ) || 'page' === $post_type ) { // always masonry for pages for now.
		$class .= ' masonry-container';
	}

	if ( 'masonry_horizontal' === $display ) {
		$class .= ' fleximages-container';
	}
	if ( 'carousel' === $module ) {
		$pagination      = 'none';
		$category_filter = null;
	}

	if ( $category_filter && ( 'work' === $post_type || 'video' === $post_type || 'gallery' === $post_type || 'release' === $post_type || 'artist' === $post_type ) ) {
		$class .= ' filtered-content';
	}

	if ( $category_filter && 'post' === $post_type ) {
		$class .= ' ajax-filtered-content';
	}
	if ( isset( $_GET['wpage'] ) && isset( $_GET['index'] ) && $id === esc_attr( $_GET['index'] ) ) {
		$paged = absint( $_GET['wpage'] );
	}

	if ( ! $paged ) {
		/* Fixed in  4.8 ? */
		$page_var = ( is_front_page() ) ? 'page' : 'paged';
		$paged    = ( get_query_var( $page_var ) ) ? get_query_var( $page_var ) : 1;
	}
	if ( $offset ) {

		$sticky_posts       = ( get_option( 'sticky_posts' ) && is_array( get_option( 'sticky_posts' ) ) ) ? get_option( 'sticky_posts' ) : array();
		$sticky_posts_count = ( 'post' === $post_type ) ? count( $sticky_posts ) : 0;
		if ( -1 === $posts_per_page ) {
			$posts_per_page = get_option( 'posts_per_page' );
		}

		if ( 1 === $paged ) {

		} else {
			$offset = $offset + ( ( $paged - 1 ) * $posts_per_page );
		}
	}

	if ( $category_filter && 'post' !== $post_type ) {
		$pagination_type = 'none';
	}
	$args = array(
		'post_type'           => $post_type,
		'post_status'         => array( 'publish' ), // published post only.
		'posts_per_page'      => $posts_per_page,
		'ignore_sticky_posts' => $ignore_sticky_posts,
		'paged'               => $paged,
	);

	if ( $offset ) {
		$args['offset']              = $offset;
		$args['ignore_sticky_posts'] = 1; // force ignoring sticky posts.
	}
	$args['post__in'] = array();
	if ( $include_ids ) {
		$args['post__in'] = slikk_list_to_array( $include_ids );
	}
	$exclude_ids_array   = array();
	$exclude_ids_array[] = slikk_get_the_id(); // exclude current post, obviously or the internet will explode.

	if ( $exclude_sticky_posts ) {
		$exclude_ids_array = array_merge( $exclude_ids_array, get_option( 'sticky_posts' ) );
	}

	if ( $exclude_ids ) {
		$exclude_ids_array = array_merge( $exclude_ids_array, slikk_list_to_array( $exclude_ids ) );
	}

	$exclude_ids_array = array_unique( $exclude_ids_array );

	$args['post__not_in'] = $exclude_ids_array;

	/*
	---------------------------------
		POST
	------------------------------------
	*/

	if ( 'post' === $post_type ) {
		if ( $set_category_var ) {

			if ( 'all' === $set_category_var ) {
				$is_index = false;
				$category = '';
				$tag      = '';

			} else {
				$is_index = false;
				$category = $set_category_var;
			}
		}

		if ( $category ) {
			$args['category_name'] = slikk_clean_list( $category );
		}

		if ( $category_exclude ) {
			$args['category__not_in'] = array( slikk_clean_list( $category_exclude ) );
		}
		if ( $tag ) {
			$args['tag'] = slikk_clean_list( $tag );
		}

		if ( $tag_exclude ) {
			$args['tag__not_in'] = slikk_clean_list( $tag_exclude );
		}
		$force_featured_image_post_display = array( 'mosaic', 'grid_square', 'metro', 'offgrid', 'animated_cover' );

		if ( in_array( $post_display, $force_featured_image_post_display ) ) {
			$args['meta_key'] = '_thumbnail_id';
		}
	}

	/*
	---------------------------------
		WORK
	------------------------------------
	*/

	if ( 'work' === $post_type ) {
		if ( $work_type_include ) {
			$args['work_type'] = slikk_clean_list( $work_type_include );
		}
		if ( $work_type_exclude ) {
			$args['tax_query'] = array(
				array(
					'taxonomy' => 'work_type',
					'terms'    => array( slikk_clean_list( $work_type_exclude ) ),
					'field'    => 'slug',
					'operator' => 'NOT IN',
				),
			);
		}

		$args['meta_key'] = '_thumbnail_id'; // force post with thumbnail.

		$class .= " hover-effect-$work_hover_effect";
		$class .= " work-hover-effect-$work_hover_effect";
	}

	/*
	---------------------------------
		VIDEO
	------------------------------------
	*/

	if ( 'video' === $post_type ) {

		$class .= " video-preview-$video_preview";
		if ( $video_type_include ) {
			$args['video_type'] = slikk_clean_list( $video_type_include );
		}
		if ( $video_type_exclude ) {
			$args['tax_query'] = array(
				array(
					'taxonomy' => 'video_type',
					'terms'    => array( slikk_clean_list( $video_type_exclude ) ),
					'field'    => 'slug',
					'operator' => 'NOT IN',
				),
			);
		}
		if ( $video_tag_include ) {
			$args['video_tag'] = slikk_clean_list( $video_tag_include );
		}
		if ( $video_tag_exclude ) {
			$args['tax_query'] = array(
				array(
					'taxonomy' => 'video_tag',
					'terms'    => array( slikk_clean_list( $video_tag_exclude ) ),
					'field'    => 'slug',
					'operator' => 'NOT IN',
				),
			);
		}

		$args['meta_key'] = '_thumbnail_id'; // force post with thumbnail
	}

	/*
	---------------------------------
		MP EVENT
	------------------------------------
	*/

	if ( 'mp-event' === $post_type ) {
		if ( $mp_event_category_include ) {
			$args['mp-event_category'] = slikk_clean_list( $mp_event_category_include );
		}
		if ( $mp_event_category_exclude ) {
			$args['tax_query'] = array(
				array(
					'taxonomy' => 'mp-event_category',
					'terms'    => array( slikk_clean_list( $mp_event_category_exclude ) ),
					'field'    => 'slug',
					'operator' => 'NOT IN',
				),
			);
		}
		if ( $mp_event_tag_include ) {
			$args['mp-event_tag'] = slikk_clean_list( $mp_event_tag_include );
		}
		if ( $mp_event_tag_exclude ) {
			$args['tax_query'] = array(
				array(
					'taxonomy' => 'mp-event_tag',
					'terms'    => array( slikk_clean_list( $mp_event_tag_exclude ) ),
					'field'    => 'slug',
					'operator' => 'NOT IN',
				),
			);
		}

		$args['meta_key'] = '_thumbnail_id'; // force post with thumbnail
	}

	/*
	---------------------------------
		GALLERY
	------------------------------------
	*/

	if ( 'gallery' === $post_type ) {
		if ( $gallery_type_include ) {
			$args['gallery_type'] = slikk_clean_list( $gallery_type_include );
		}
		if ( $gallery_type_exclude ) {
			$args['tax_query'] = array(
				array(
					'taxonomy' => 'gallery_type',
					'terms'    => array( slikk_clean_list( $gallery_type_exclude ) ),
					'field'    => 'slug',
					'operator' => 'NOT IN',
				),
			);
		}

		$args['meta_key'] = '_thumbnail_id'; // force post with thumbnail.

		$class .= " hover-effect-$gallery_hover_effect";
		$class .= " gallery-hover-effect-$gallery_hover_effect";
	}

	/*
	---------------------------------
		RELEASE
	------------------------------------
	*/

	if ( 'release' === $post_type ) {
		if ( $band_include ) {
			$args['band'] = slikk_clean_list( $band_include );
		}
		if ( $band_exclude ) {
			$args['tax_query'] = array(
				array(
					'taxonomy' => 'band',
					'terms'    => array( slikk_clean_list( $band_exclude ) ),
					'field'    => 'slug',
					'operator' => 'NOT IN',
				),
			);
		}
		if ( $label_include ) {
			$args['label'] = slikk_clean_list( $label_include );
		}
		if ( $label_exclude ) {
			$args['tax_query'] = array(
				array(
					'taxonomy' => 'label',
					'terms'    => array( slikk_clean_list( $label_exclude ) ),
					'field'    => 'slug',
					'operator' => 'NOT IN',
				),
			);
		}
		if ( $genre_include ) {
			$args['genre'] = slikk_clean_list( $genre_include );
		}
		if ( $genre_exclude ) {
			$args['tax_query'] = array(
				array(
					'taxonomy' => 'release_genre',
					'terms'    => array( slikk_clean_list( $genre_exclude ) ),
					'field'    => 'slug',
					'operator' => 'NOT IN',
				),
			);
		}

		$args['meta_key'] = '_thumbnail_id'; // force post with thumbnail.

		if ( 'featured' === $release_meta ) {

			$args['meta_query'] = array(
				array(
					'key'     => '_post_release_meta',
					'value'   => 'featured',
					'compare' => '=',
				),
			);

		} elseif ( 'upcoming' === $release_meta ) {

			$args['meta_query'] = array(
				array(
					'key'     => '_post_release_meta',
					'value'   => 'upcoming',
					'compare' => '=',
				),
			);
		}

		$class .= " hover-effect-$release_hover_effect";
		$class .= " release-hover-effect-$release_hover_effect";
	}

	/*
	---------------------------------
		ARTIST
	------------------------------------
	*/

	if ( 'artist' === $post_type ) {
		if ( $artist_genre_include ) {
			$args['artist_genre'] = slikk_clean_list( $artist_genre_include );
		}
		if ( $artist_genre_exclude ) {
			$args['tax_query'] = array(
				array(
					'taxonomy' => 'artist_genre',
					'terms'    => array( slikk_clean_list( $artist_genre_exclude ) ),
					'field'    => 'slug',
					'operator' => 'NOT IN',
				),
			);
		}

		$class .= " hover-effect-$artist_hover_effect";
		$class .= " artist-hover-effect-$artist_hover_effect";
	}

	/*
	---------------------------------
		PAGE
	------------------------------------
	*/

	if ( 'page' === $post_type ) {
		$force_featured_image_page_display = array( 'grid', 'grid_overlay', 'masonry', 'carousel' );

		if ( $page_by_parent ) {

			$parent_page_id = absint( $page_by_parent );

			$child_page_ids = array( $parent_page_id );

			$child_pages = get_page_children(
				$parent_page_id,
				get_posts(
					array(
						'post_type'      => 'page',
						'posts_per_page' => '-1',
					)
				)
			);

			foreach ( $child_pages as $child_page ) {
				$child_page_ids[] = $child_page->ID;
			}

			$args['post__in'] = $child_page_ids;
		}

		if ( in_array( $page_display, $force_featured_image_page_display ) ) {
			$args['meta_key'] = '_thumbnail_id';
		}
	}

	/*
	---------------------------------
		EVENT
	------------------------------------
	*/

	if ( 'event' === $post_type ) {

		$args['meta_key'] = '_wolf_event_start_date';

		$args['orderby'] = 'meta_value';

		if ( 'past' === $timeline ) {
			$args['order'] = 'DESC';
		} else {
			$args['order'] = 'ASC';
		}
		if ( $artist_include ) {
			$args['we_artist'] = slikk_clean_list( $artist_include );
		}
		if ( $artist_exclude ) {
			$args['tax_query'] = array(
				array(
					'taxonomy' => 'we_artist',
					'terms'    => array( slikk_clean_list( $artist_exclude ) ),
					'field'    => 'slug',
					'operator' => 'NOT IN',
				),
			);
		}
	}

	/*
	---------------------------------
		PRODUCT
	------------------------------------
	*/

	$product_thumbnail_size = 'woocommerce_thumbnail';
	if ( 'product' === $post_type ) {

		$class .= " product-text-align-$product_text_align";

		if ( 'featured' === $product_meta ) {

			$meta_query  = WC()->query->get_meta_query();
			$tax_query   = WC()->query->get_tax_query();
			$tax_query[] = array(
				'taxonomy' => 'product_visibility',
				'field'    => 'name',
				'terms'    => 'featured',
				'operator' => 'IN',
			);

			$args['meta_query'] = $meta_query;
			$args['tax_query']  = $tax_query;

		} elseif ( 'onsale' === $product_meta ) {

			$meta_query         = WC()->query->get_meta_query();
			$args['post__in']   = array_merge( $args['post__in'], wc_get_product_ids_on_sale() );
			$args['meta_query'] = $meta_query;

		} elseif ( 'best_selling' === $product_meta ) {

			$args['meta_key'] = 'total_sales'; // @codingStandardsIgnoreLine
			$args['order']    = 'DESC';
			$args['orderby']  = 'meta_value_num';

		} elseif ( 'top_rated' === $product_meta ) {

			$args['meta_key']   = '_wc_average_rating';
			$args['orderby']    = 'meta_value_num';
			$args['order']      = 'DESC';
			$args['meta_query'] = WC()->query->get_meta_query();
			$args['tax_query']  = WC()->query->get_tax_query();

		} else {
			$args['tax_query'] = array(
				array(
					'taxonomy' => 'product_visibility',
					'field'    => 'name',
					'terms'    => 'exclude-from-catalog',
					'operator' => 'NOT IN',
				),
			);
		}

		if ( $product_cat ) {
			$args['product_cat'] = slikk_clean_list( $product_cat );
		}

		if ( 2 == $columns ) {
		}
	}

	/*
	---------------------------------
		ATTACHMENTS
	------------------------------------
	*/

	if ( 'attachment' === $post_type ) {

		$item_animation = 'none';

		$args['post_status'] = 'inherit'; // query all first.

		$tag_terms    = array();
		$cat_terms    = array();
		$taxonomy_tag = 'photo_tag';
		$taxonomy_cat = 'photo_category';

		if ( taxonomy_exists( 'photo_tag' ) && taxonomy_exists( 'photo_category' ) ) {
			$taxonomy_tag_terms = get_terms( $taxonomy_tag, array( 'hide_empty' => false ) );
			foreach ( $taxonomy_tag_terms as $taxonomy_tag_term ) {
				$tag_terms[] = $taxonomy_tag_term->slug;
			}

			$taxonomy_cat_terms = get_terms( $taxonomy_cat, array( 'hide_empty' => false ) );
			foreach ( $taxonomy_cat_terms as $taxonomy_cat_term ) {
				$cat_terms[] = $taxonomy_cat_term->slug;
			}
		}
		if ( isset( $_GET['s'] ) ) {

			$search_term  = esc_attr( $_GET['s'] );
			$search_terms = explode( ' ', $search_term );

			$args['tax_query'] = array(
				'relation' => 'OR',
				array(
					'taxonomy' => 'photo_tag',
					'field'    => 'slug',
					'terms'    => $search_terms,
				),
				array(
					'taxonomy' => $taxonomy_cat,
					'field'    => 'slug',
					'terms'    => $search_terms,
				),
			);

			$tax_query = new WP_Query( apply_filters( 'slikk_post_module_query_args', $args ) );
			if ( 0 === $tax_query->post_count ) {

				global $wpdb;
				$like_seach_terms_post_ids = $wpdb->get_col( "select ID from $wpdb->posts where post_title LIKE '" . $search_term . "%' " );

				$args['post__in'] = $like_seach_terms_post_ids;
				$args['tax_query'] = array(
					'relation' => 'OR',
					array(
						'taxonomy' => $taxonomy_tag,
						'field'    => 'slug',
						'terms'    => $tag_terms,
					),

					array(
						'taxonomy' => $taxonomy_cat,
						'field'    => 'slug',
						'terms'    => $cat_terms,
					),
				);
			}
		} else {

			if ( $attachment_author ) {
				$args['author'] = absint( $attachment_author );
			}

			if ( 'popular' === $attachemnt_orderby ) {
				$args['meta_key'] = '_wolf_views_count';
				$args['orderby']  = 'meta_value_num date';
				$args['order']    = 'DESC';
			}

			$args['tax_query'] = array(
				'relation' => 'OR',
				array(
					'taxonomy' => $taxonomy_tag,
					'field'    => 'slug',
					'terms'    => $tag_terms,
				),

				array(
					'taxonomy' => $taxonomy_cat,
					'field'    => 'slug',
					'terms'    => $cat_terms,
				),
			);
		} // regular query
	}

	/*--------------------------------------------------------------*/
	if ( $orderby ) {
		$args['orderby'] = $orderby;
	}

	if ( $order ) {
		$args['order'] = $order;
	}
	if ( $is_index ) { // is index page.

		global $wp_query;
		$query = $wp_query;

	} else { // custom query.

		add_filter( 'found_posts', 'slikk_offset_pagination_fix', 10, 2 );
		if ( 'event' === $post_type && function_exists( 'we_order_by' ) && function_exists( 'we_future_where' ) ) {

			add_filter( 'posts_orderby', 'we_order_by', 10, 1 );

			if ( 'past' === $timeline ) {

				add_filter( 'posts_where', 'we_past_where', 10, 1 );
			} else {
				add_filter( 'posts_where', 'we_future_where', 10, 1 );
			}
		}

		/* The query */
		$query = new WP_Query( $args );

		if ( 'event' === $post_type && function_exists( 'we_order_by' ) && function_exists( 'we_future_where' ) ) {

			if ( 'past' === $timeline ) {

				remove_filter( 'posts_where', 'we_past_where', 10, 1 );

			} else {

				remove_filter( 'posts_where', 'we_future_where', 10, 1 );
			}
		}

		remove_filter( 'found_posts', 'slikk_offset_pagination_fix', 10, 2 );
	}

	/**
	 * Add action before the output
	 */
	do_action( 'slikk_before_post_module', $atts );
	if ( $query->have_posts() ) {
		if ( in_array( $display, $masonry_display, true ) || 'page' === $post_type ) {
			wp_enqueue_script( 'imagesloaded' );
			wp_enqueue_script( 'isotope' );

			if ( in_array( $display, $metro_display, true ) ) {
				wp_enqueue_script( 'packery-mode' );
			}

			wp_enqueue_script( 'slikk-masonry' );
		}

		if ( 'masonry_horizontal' === $display ) {
			wp_enqueue_script( 'imagesloaded' );
			wp_enqueue_script( 'flex-images' );
			wp_enqueue_script( 'slikk-masonry' );
		}

		if ( 'carousel' === $module ) {
			wp_enqueue_script( 'flickity' );
			wp_enqueue_script( 'slikk-carousels' );
		}

		if ( 'attachment' === $post_type ) {
			wp_enqueue_script( 'infinitescroll' );
			wp_enqueue_script( 'lazyloadxt' );
		}

		if ( $category_filter ) {
			wp_enqueue_script( 'imagesloaded' );
			wp_enqueue_script( 'isotope' );
			wp_enqueue_script( 'slikk-category-filter' );

			/*
			 * Pass args to filter template. Cool stuff.
			 */
			set_query_var(
				'filter_args',
				array(

					/* Post */
					'category'                             => slikk_clean_list( $category ),

					/* Work */
					'work_type_include'                    => slikk_clean_list( $work_type_include ),
					'work_type_exclude'                    => slikk_clean_list( $work_type_exclude ),
					'work_category_filter_text_alignment'  => $work_category_filter_text_alignment,

					/* Albums */
					'gallery_type_include'                 => slikk_clean_list( $gallery_type_include ),
					'gallery_type_exclude'                 => slikk_clean_list( $gallery_type_exclude ),
					'gallery_category_filter_text_alignment' => $gallery_category_filter_text_alignment,

					/* Video */
					'video_type_include'                   => slikk_clean_list( $video_type_include ),
					'video_type_exclude'                   => slikk_clean_list( $video_type_exclude ),
					'video_category_filter_text_alignment' => $video_category_filter_text_alignment,

					/* Artist */
					'artist_genre_include'                 => slikk_clean_list( $artist_genre_include ),
					'artist_genre_exclude'                 => slikk_clean_list( $artist_genre_exclude ),
					'artist_category_filter_text_alignment' => $artist_category_filter_text_alignment,

					/* Release */
					'band_include'                         => slikk_clean_list( $band_include ),
					'band_exclude'                         => slikk_clean_list( $band_exclude ),
					'release_category_filter_text_alignment' => $release_category_filter_text_alignment,
				)
			);

			/**
			 * Category filter
			 */
			get_template_part( slikk_get_template_dirname() . '/components/filter/filter', $post_type );
		}

		$tag = ( $is_list ) ? 'ul' : 'div';
		echo '<' . esc_attr( $tag ) . ' id="' . esc_attr( $id ) . '" data-post-type="' . esc_attr( $post_type ) . '" data-params="' . esc_js( $json_params ) . '" class="' . slikk_sanitize_html_classes( $class ) . '"';

		if ( slikk_esc_style_attr( $inline_style ) ) {
			echo ' style="' . slikk_esc_style_attr( $inline_style ) . '"';
		}

		echo '>';
		echo "\n";

		/**
		 * Filter default post display options from customizer to output the right post class through post_class() function
		 *
		 * @see inc/frontent/post-attributes.php
		 */
		add_filter(
			'slikk_post_display',
			function( $default ) use ( $display ) {
				return $display;
			}
		);
		add_filter(
			'slikk_post_module_layout',
			function( $default ) use ( $layout ) {
				return $layout;
			}
		);
		add_filter(
			'slikk_post_item_animation',
			function( $default ) use ( $item_animation ) {
				return slikk_animation_fallback( $item_animation );
			}
		);
		add_filter(
			'slikk_post_columns',
			function( $default ) use ( $columns ) {
				return $columns;
			}
		);
		add_filter(
			'slikk_post_force_loop_class',
			function() {
				return true;
			}
		);

		$i = 0;

		if ( ( $posts_per_page % 2 !== 0 ) && ( $paged !== 1 ) ) {
			$i = 1;
		}
		while ( $query->have_posts() ) {

			$i++;

			$query->the_post();

			/*
			 * Pass args to template
			 */
			set_query_var(
				'template_args',
				array(

					'index'                                => $i,

					'display'                              => $display,
					'layout'                               => $layout,

					'overlay_color'                        => $overlay_color,
					'overlay_custom_color'                 => $overlay_custom_color,
					'overlay_opacity'                      => $overlay_opacity,
					'overlay_text_color'                   => $overlay_text_color,
					'overlay_text_custom_color'            => $overlay_text_custom_color,
					'thumbnail_size'                       => $thumbnail_size,
					'custom_thumbnail_size'                => $custom_thumbnail_size,

					'post_excerpt_type'                    => $post_excerpt_type,
					'post_excerpt_length'                  => $post_excerpt_length,
					'post_display_elements'                => $post_display_elements,
					'post_alternate_thumbnail_position'    => $post_alternate_thumbnail_position,

					'work_is_gallery'                      => $work_is_gallery,

					'release_alternate_thumbnail_position' => $release_alternate_thumbnail_position,
					'release_add_buy_links'                => $release_add_buy_links,

					'video_onclick'                        => $video_onclick,
					'video_preview'                        => $video_preview,

					'event_location'                       => $event_location,
					'event_timeline'                       => $timeline,

					/* Product */
					'product_thumbnail_size'               => $product_thumbnail_size,
				)
			);

			/*
			 * Include the template part for the content.
			 */
			get_template_part( slikk_get_template_dirname() . '/components/' . $post_type . '/display/content', $display );

		}

		echo '</' . esc_attr( $tag ) . '><!--.items-->';
		remove_all_filters( 'slikk_post_display' );
		remove_all_filters( 'slikk_post_item_animation' );
		remove_all_filters( 'slikk_post_columns' );
		remove_all_filters( 'slikk_post_module_layout' );
		if ( 'none' !== $pagination ) {
			$pagination_args = array(
				'post_type'                => $post_type,
				'pagination_type'          => $pagination,
				'product_category_link_id' => $product_category_link_id,
				'paged'                    => $paged,
				'container_id'             => $id,
			);
			do_action( 'slikk_pagination', $query, $pagination_args );
		}
	} else {
		/* No result */
		if ( 'event' === $post_type ) {

			if ( 'past' === $timeline ) {

				apply_filters( 'slikk_no_past_event_text', esc_html__( 'No past event.', 'slikk' ) );

			} else {
				if ( function_exists( 'we_get_option' ) ) {
					echo esc_attr( we_get_option( 'no_event_text', esc_html__( 'No upcoming shows scheduled.', 'slikk' ) ) );
				}
			}
		} elseif ( 'release' === $post_type ) {

			echo esc_attr( apply_filters( 'slikk_no_release_text', esc_html__( 'No release yet.', 'slikk' ) ) );

			if ( is_user_logged_in() ) {
				echo '&nbsp;';
				echo apply_filters( 'slikk_no_release_user_text', esc_html__( 'Is there a featured image set for each of your release?', 'slikk' ) );
			}
		} elseif ( 'video' === $post_type ) {

			echo esc_attr( apply_filters( 'slikk_no_video_text', esc_html__( 'No video yet.', 'slikk' ) ) );

			if ( is_user_logged_in() ) {
				echo '&nbsp;';
				echo esc_attr( apply_filters( 'slikk_no_video_user_text', esc_html__( 'Is there a featured image set for each of your video?', 'slikk' ) ) );
			}
		} elseif ( 'work' === $post_type ) {

			echo esc_attr( apply_filters( 'slikk_no_work_text', esc_html__( 'No work yet.', 'slikk' ) ) );

		} elseif ( 'page' !== $post_type ) {

			get_template_part( slikk_get_template_dirname() . '/components/post/content', 'none' );
		}
	}
	wp_reset_postdata();
}
add_action( 'slikk_posts', 'slikk_output_posts' );
