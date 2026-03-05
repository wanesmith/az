<?php
/**
 * The template for displaying all single work posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package WordPress
 * @subpackage Slikk
 * @version 1.4.2
 */
get_header();
?>
	<div id="primary" class="content-area">
		<main id="content" class="site-content clearfix" role="main">
			<?php
				/* Start the Loop */
				while ( have_posts() ) : the_post();

					/*
					 * Post content
					 */
					get_template_part( slikk_get_template_dirname() . '/components/work/content', 'single' );

				endwhile; // End of the loop.
			?>
		</main><!-- main#content .site-content-->
	</div><!-- #primary .content-area -->
<?php
get_footer();
