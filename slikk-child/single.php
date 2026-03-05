<?php

get_header();
?>
	<div id="primary" class="content-area">
		<main id="content" class="site-content clearfix" role="main">
			<?php
				/* Start the Loop */
			while ( have_posts() ) :
				the_post();

				/*
				 * Post content
				 */
				get_template_part( slikk_get_template_dirname() . '/components/post/content', 'single' );

				/*
				 * If comments are open or we have at least one comment, load up the comment template.
				 */
				if ( comments_open() || get_comments_number() ) :
					if(get_default_comment_status()) :
                        comments_template();
                        endif;
					endif;

				endwhile; // End of the loop.
			?>
		</main><!-- main#content .site-content-->
	</div><!-- #primary .content-area -->
<?php
get_sidebar();
get_footer();
