<?php // phpcs:ignore
/**
 * WPBakery Page Builder post modules (new version for Wolf Core plugin)
 *
 * @package WordPress
 * @subpackage Slikk
 * @version 1.4.2
 */

if ( ! defined( 'ABSPATH' ) || ! class_exists( 'Wolf_Core' ) || ! defined( 'WOLF_CORE_VERSION' ) ) {
	return;
}

/**
 * Post Loop Module
 */
if ( ! class_exists( 'WPBakeryShortCode_Wolf_Core_Post_Index' ) ) {

	vc_map( wolf_core_convert_params_to_vc( slikk_post_index_params() ) );

	class WPBakeryShortCode_Wolf_Core_Post_Index extends WPBakeryShortCode {} // phpcs:ignore
}

/**
 * Release Loop Module
 */
if ( ! class_exists( 'WPBakeryShortCode_Wolf_Core_Release_Index' ) && class_exists( 'Wolf_Discography' ) ) {

	vc_map( wolf_core_convert_params_to_vc( slikk_release_index_params() ) );

	class WPBakeryShortCode_Wolf_Core_Release_Index extends WPBakeryShortCode {} // phpcs:ignore
}

/**
 * Video Loop Module
 */
if ( ! class_exists( 'WPBakeryShortCode_Wolf_Core_Video_Index' ) && class_exists( 'Wolf_Videos' ) ) {

	vc_map( wolf_core_convert_params_to_vc( slikk_video_index_params() ) );

	class WPBakeryShortCode_Wolf_Core_Video_Index extends WPBakeryShortCode {} // phpcs:ignore
}

/**
 * Event Loop Module
 */
if ( ! class_exists( 'WPBakeryShortCode_Wolf_Core_Event_Index' ) && class_exists( 'Wolf_Events' ) ) {

	vc_map( wolf_core_convert_params_to_vc( slikk_event_index_params() ) );

	class WPBakeryShortCode_Wolf_Core_Event_Index extends WPBakeryShortCode {} // phpcs:ignore
}

/**
 * Work Loop Module
 */
if ( ! class_exists( 'WPBakeryShortCode_Wolf_Core_Work_Index' ) && class_exists( 'Wolf_Portfolio' ) ) {

	vc_map( wolf_core_convert_params_to_vc( slikk_work_index_params() ) );

	class WPBakeryShortCode_Wolf_Core_Work_Index extends WPBakeryShortCode {} // phpcs:ignore
}

/**
 * Album Loop Module
 */
if ( ! class_exists( 'WPBakeryShortCode_Wolf_Core_Gallery_Index' ) && class_exists( 'Wolf_Albums' ) ) {

	vc_map( wolf_core_convert_params_to_vc( slikk_gallery_index_params() ) );

	class WPBakeryShortCode_Wolf_Core_Gallery_Index extends WPBakeryShortCode {} // phpcs:ignore
}

/**
 * Product Loop Module
 */
if ( ! class_exists( 'WPBakeryShortCode_Wolf_Core_Product_Index' ) && class_exists( 'WooCommerce' ) ) {

	vc_map( wolf_core_convert_params_to_vc( slikk_product_index_params() ) );

	class WPBakeryShortCode_Wolf_Core_Product_Index extends WPBakeryShortCode {} // phpcs:ignore
}

/**
 * Page Loop Module
 */
if ( ! class_exists( 'WPBakeryShortCode_Wolf_Core_Page_Index' ) ) {

	vc_map( wolf_core_convert_params_to_vc( slikk_page_index_params() ) );

	class WPBakeryShortCode_Wolf_Core_Page_Index extends WPBakeryShortCode {} // phpcs:ignore
}
