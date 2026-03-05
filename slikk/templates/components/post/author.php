<?php
/**
 * Template part for displaying the author box
 *
 * @package WordPress
 * @subpackage Slikk
 * @version 1.4.2
 */
if ( ! get_the_author_meta( 'description' ) ) {
	return;
}
?>
<section class="author-box-container entry-section">
	<div class="author-box clearfix">
		<div class="author-avatar">
			<a itemprop="url" href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>" rel="author">
				<?php echo get_avatar( get_the_author_meta( 'user_email' ), apply_filters( 'slikk_author_box_avatar_size', 80 ) ); ?>
			</a>
		</div><!-- .author-avatar -->
		<div class="author-description" itemprop="author" itemscope itemtype="https://schema.org/Person">
			<h5 class="author-name"><span class="vcard author author_name"><span class="fn" itemprop="name"><?php the_author_meta( 'display_name' ); ?></span></span></h5>
			<p>
				<?php the_author_meta( 'description' ); ?>
			</p>
			<p>
				<a itemprop="url" class="author-page-link <?php echo esc_attr( apply_filters( 'slikk_author_page_link_button_class', 'button-secondary' ) ); ?>" href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>" rel="author">
					<?php printf( esc_html__( 'View all posts by %s', 'slikk' ), get_the_author() ); ?>
				</a>
			</p>
		</div><!-- .author-description -->
	</div><!-- .author-box -->
</section><!-- .author-box-container -->
