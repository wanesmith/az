<?php
/**
 * The main navigation for mobile
 *
 * @package WordPress
 * @subpackage Slikk
 * @version 1.4.2
 */

if ( ! slikk_do_onepage_menu() ) {

	if ( has_nav_menu( 'mobile' ) ) {

		wp_nav_menu( slikk_get_menu_args( 'mobile', 'mobile' ) );

	} else {
		wp_nav_menu( slikk_get_menu_args( 'primary', 'mobile' ) );
	}
}

