<?php
/**
 * Displays side panel
 *
 * @package WordPress
 * @subpackage Slikk
 * @version 1.4.2
 */
$sp_classes = apply_filters( 'slikk_side_panel_class', '' );
?>
<div id="side-panel" class="side-panel <?php echo slikk_sanitize_html_classes( $sp_classes ); ?>">
	<div class="side-panel-inner">
		<?php
			/* Side Panel start hook */
			do_action( 'slikk_sidepanel_start' );

		if ( slikk_get_theme_mod( 'sidepanel_content_block_id' ) ) {

			echo '<div id="side-panel-block" class="sidebar-container sidebar-side-panel">';
			echo '<div class="sidebar-inner">';
			echo ( function_exists( 'slikk_get_block' ) ) ? slikk_get_block( slikk_get_theme_mod( 'sidepanel_content_block_id' ) ) : '';
			echo '</div>';
			echo '</div>';

		} else {
			get_sidebar( 'side-panel' );
		}
		?>
	</div><!-- .side-panel-inner -->
</div><!-- .side-panel -->
