<?php
/**
 * Post index WPBakery Page Builder Template
 *
 * The arguments are passed to the slikk_posts hook so we can do whatever we want with it
 *
 * @author WolfThemes
 * @category Core
 * @package Slikk/WPBakeryPageBuilder
 * @version 1.4.2
 */

defined( 'ABSPATH' ) || exit;

/* retrieve shortcode attributes */
$atts = vc_map_get_attributes( $this->getShortcode(), $atts );

$atts['post_type'] = 'post';

/* hook passing VC arguments */
do_action( 'slikk_posts', $atts );
