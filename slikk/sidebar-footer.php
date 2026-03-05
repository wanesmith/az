<?php
/**
 * The sidebar containing the footer widget area
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package WordPress
 * @subpackage Slikk
 * @version 1.4.2
 */

if ( is_active_sidebar( 'sidebar-footer' ) ) :
	$slikk_tertiary_widget_area_class  = 'sidebar-footer';
	$slikk_tertiary_widget_area_class .= ' ' . apply_filters( 'slikk_sidebar_footer_class', '' );
	?>
	<div id="tertiary" class="<?php echo slikk_sanitize_html_classes( $slikk_tertiary_widget_area_class ); ?>">
		<div class="sidebar-footer-inner wrap">
			<div class="widget-area">
				<?php dynamic_sidebar( 'sidebar-footer' ); ?>
			</div><!-- .widget-area -->
		</div><!-- .sidebar-footer-inner -->
	</div><!-- #tertiary .sidebar-footer -->
<?php endif; ?>
