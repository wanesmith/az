<?php
/**
 * Template part for displaying posts with the "grid square" display
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage Slikk
 * @version 1.4.2
 */
extract( wp_parse_args( $template_args, array(
	'post_excerpt_length' => 'shorten',
	'post_display_elements' => 'show_thumbnail,show_date,show_text,show_author,show_category',
) ) );

$post_display_elements = slikk_list_to_array( $post_display_elements );
$show_thumbnail = ( in_array( 'show_thumbnail', $post_display_elements ) );
$show_date = ( in_array( 'show_date', $post_display_elements ) );
$show_text = ( in_array( 'show_text', $post_display_elements ) );
$show_author = ( in_array( 'show_author', $post_display_elements ) );
$show_category = ( in_array( 'show_category', $post_display_elements ) );
$show_tags = ( in_array( 'show_tags', $post_display_elements ) );
$show_extra_meta = ( in_array( 'show_extra_meta', $post_display_elements ) );
?>
<article <?php slikk_post_attr(); ?>>
	<a href="<?php the_permalink(); ?>" class="entry-link-mask"></a>
	<div class="entry-box">
		<div class="entry-container">
			<div class="entry-image">
				<?php
					echo slikk_background_img( array(
						'background_img_size' => 'large',
					) );
				?>
			</div><!-- .entry-image -->
			<div class="entry-grid_square-overlay"></div>

			<?php if ( $show_category ) : ?>
				<a class="category-label" href="<?php echo slikk_get_first_category_url(); ?>"><?php echo slikk_get_first_category(); ?></a>
			<?php endif; ?>
			<?php
				if ( is_sticky() && ! is_paged() ) {
					echo '<span class="sticky-post" title="' . esc_attr( __( 'Featured', 'slikk' ) ) . '"></span>';
				}
			?>
			<div class="entry-summary">
				<div class="entry-summary-inner">
					<?php if ( $show_date ) : ?>
						<span class="entry-date">
							<?php slikk_entry_date(); ?>
						</span>
					<?php endif; ?>
					<h2 class="entry-title">
						<?php the_title(); ?>
					</h2>
					<?php if ( $show_text ) : ?>
						<div class="entry-excerpt">
							<?php echo slikk_sample( get_the_excerpt(), 14 ); ?>
						</div><!-- .entry-excerpt -->
					<?php endif; ?>
				</div><!-- .entry-summary-inner -->
				<?php if ( $show_author || $show_tags || $show_extra_meta || slikk_edit_post_link() ) : ?>
					<div class="entry-meta">
						<?php if ( $show_author ) : ?>
							<?php slikk_get_author_avatar(); ?>
						<?php endif; ?>
						<?php if ( $show_tags ) : ?>
							<?php slikk_entry_tags(); ?>
						<?php endif; ?>
						<?php if ( $show_extra_meta ) : ?>
							<?php slikk_get_extra_meta(); ?>
						<?php endif; ?>
						<?php slikk_edit_post_link(); ?>
					</div><!-- .entry-meta -->
				<?php endif; ?>
			</div><!-- .entry-summary -->
		</div><!-- .entry-container -->
	</div><!-- .entry-box -->
</article><!-- #post-## -->