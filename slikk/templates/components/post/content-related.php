<?php
/**
 * Template part for displaying related posts
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage Slikk
 * @version 1.4.2
 */
?>
<article <?php slikk_post_attr(); ?>>
	<?php
		/**
		 * Output related post content
		 */
		do_action( 'slikk_related_post_content' );
	?>
</article><!-- #post-## -->