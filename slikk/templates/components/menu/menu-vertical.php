<?php
/**
 * The main navigation for vertical menus
 *
 * @package WordPress
 * @subpackage Slikk
 * @version 1.4.2
 */

if ( ! slikk_do_onepage_menu() ) {

	if ( has_nav_menu( 'vertical' ) ) {

		wp_nav_menu( slikk_get_menu_args( 'vertical', 'vertical' ) );

	} else {
		wp_nav_menu( slikk_get_menu_args( 'primary', 'vertical' ) );
	}
}

