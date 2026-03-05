<?php
/**
 * Slikk hook functions
 *
 * Inject content through template hooks
 *
 * @package WordPress
 * @subpackage Slikk
 * @version 1.4.2
 */

defined( 'ABSPATH' ) || exit;

/**
 * Site page hooks
 */
require_once get_parent_theme_file_path( '/inc/frontend/hooks/site.php' );

/**
 * Navigation hooks
 */
require_once get_parent_theme_file_path( '/inc/frontend/hooks/navigation.php' );

/**
 * Post hooks
 */
require_once get_parent_theme_file_path( '/inc/frontend/hooks/post.php' );
