<?php
/**
 * Template part for displaying the post metro layout
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage Slikk
 * @version 1.4.2
 */
extract( wp_parse_args( $template_args, array(
	'display' => 'metro',
	'post_excerpt_length' => 'shorten',
	'post_display_elements' => 'show_thumbnail,show_date,show_author,show_category',
) ) );

$post_display_elements = slikk_list_to_array( $post_display_elements );
?>
<article <?php slikk_post_attr(); ?>>
	<div class="entry-box">
		<div class="entry-outer">
			<div class="entry-container">
				<a class="entry-link-mask" href="<?php the_permalink(); ?>"></a>
				<?php
					/**
					 * Hook: slikk_before_post_content_metro.
					 *
					 * @hooked slikk_output_post_content_metro_sticky_label - 10
					 */
					do_action( 'slikk_before_post_content_metro', $post_display_elements, $display );


					/**
					 * Hook: slikk_before_post_content_metro_title.
					 *
					 * @hooked slikk_output_post_content_metro_media - 10
					 * @hooked slikk_output_post_content_metro_date - 10
					 */
					do_action( 'slikk_before_post_content_metro_title', $post_display_elements, $display );

					/**
					 * Hook: slikk_post_content_metro_title.
					 *
					 * @hooked slikk_output_post_content_metro_title - 10
					 */
					do_action( 'slikk_post_content_metro_title', $post_display_elements );

					/**
					 * Hook: slikk_after_post_content_metro_title.
					 *
					 * @hooked slikk_output_post_content_metro_excerpt - 10
					 */
					do_action( 'slikk_after_post_content_metro_title', $post_display_elements, $post_excerpt_type, $display );

					/**
					 * Hook: slikk_after_post_content_metro.
					 *
					 * @hooked slikk_output_post_content_metro_meta - 10
					 */
					do_action( 'slikk_after_post_content_metro', $post_display_elements );
				?>
			</div><!-- .entry-container -->
		</div><!-- .entry-outer -->
	</div><!-- .entry-box -->
</article><!-- #post-## -->