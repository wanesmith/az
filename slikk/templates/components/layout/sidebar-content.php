<?php
/**
 * Displays sidebar content
 *
 * @package WordPress
 * @subpackage Slikk
 * @version 1.4.2
 */

if ( slikk_is_woocommerce_page() ) {

	dynamic_sidebar( 'sidebar-shop' );

} else {

	if ( function_exists( 'wolf_sidebar' ) ) {

		wolf_sidebar();

	} else {

		dynamic_sidebar( 'sidebar-page' );
	}
}