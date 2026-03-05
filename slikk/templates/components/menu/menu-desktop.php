<?php
/**
 * The main navigation for desktop
 *
 * @package WordPress
 * @subpackage Slikk
 * @version 1.4.2
 */

if ( ! slikk_do_onepage_menu() ) {
	wp_nav_menu( slikk_get_menu_args() );
}
