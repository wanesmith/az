
<?php
/**
 * Template part for displaying posts with excerpts
 *
 * Used in Search Results and for Recent Posts in Front Page panels.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
* @package WordPress
 * @subpackage Slikk
 * @version 1.4.2
 */
?>
<article <?php slikk_post_attr(); ?>>
	<a href="<?php the_permalink(); ?>" class="entry-link-mask"></a>
	<div class="entry-container">
		<div class="entry-box">
			<?php if ( has_post_thumbnail() ) : ?>
				<div class="entry-image">
					<?php echo slikk_post_thumbnail( 'slikk-masonry' ); ?>
				</div><!-- .entry-image -->
			<?php endif; ?>
			<div class="entry-summary">
				<div class="entry-summary-inner">
					<?php if ( slikk_get_post_type_name() ) : ?>
						<span class="entry-post-type-name"><?php echo slikk_get_post_type_name(); ?></span>
					<?php endif; ?>
					<h2 class="entry-title">
						<?php the_title(); ?>
					</h2>
					<div class="entry-excerpt">
						<?php do_action( 'slikk_post_search_excerpt' ); ?>
					</div><!-- .entry-excerpt -->
				</div><!-- .entry-summary-inner -->
			</div><!-- .entry-summary -->
		</div><!-- .entry-box -->
	</div><!-- .entry-container -->
</article><!-- #post-## -->