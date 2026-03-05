<?php
/**
 * The portoflio taxonomy template file.
 *
 * @package WordPress
 * @subpackage Slikk
 * @version 1.4.2
 */
get_header();
?>
	<div id="primary" class="content-area">
		<main id="content" class="clearfix">
			<?php
				/**
				 * Output post loop through hook so we can do the magic however we want
				 */
				do_action( 'slikk_posts', array(
					'work_index' => true,
					'el_id' => 'portfolio-index',
					'post_type' => 'work',
					'pagination' => slikk_get_theme_mod( 'work_pagination', '' ),
					'works_per_page' => slikk_get_theme_mod( 'works_per_page', '' ),
					'grid_padding' => slikk_get_theme_mod( 'work_grid_padding', 'yes' ),
					'item_animation' => slikk_get_theme_mod( 'work_item_animation' ),
				) );
			?>
		</main><!-- #content -->
	</div><!-- #primary -->
<?php
get_sidebar( 'portfolio' );
get_footer();
?>