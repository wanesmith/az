<?php
/**
 * Slikk Walker comment class
 *
 * @author WolfThemes
 * @category Core
 * @package Slikk/FRontend
 * @version 1.4.2
 */

defined( 'ABSPATH' ) || exit;

if ( ! class_exists( 'Slikk_Walker_Comment' ) ) {
	class Slikk_Walker_Comment extends Walker_Comment {
		var $tree_type = 'comment';
		var $db_fields = [ 'parent' => 'comment_parent', 'id' => 'comment_ID' ];
		function __construct() { ?>

			<section class="comments-list clearfix">

		<?php }
		function start_lvl( &$output, $depth = 0, $args = [] ) {
			$GLOBALS['comment_depth'] = $depth + 2; ?>

			<section class="child-comments comments-list">

		<?php }
		function end_lvl( &$output, $depth = 0, $args = [] ) {
			$GLOBALS['comment_depth'] = $depth + 2; ?>

			</section>

		<?php }
		function start_el( &$output, $comment, $depth = 0, $args = [], $id = 0 ) {
			$depth++;
			$GLOBALS['comment_depth'] = $depth;
			$GLOBALS['comment'] = $comment;
			$parent_class = ( empty( $args['has_children'] ) ? '' : 'parent' );

			if ( 'article' == $args['style'] ) {

				$tag = 'article';
				$add_below = 'comment';
			} else {

				$tag = 'article';
				$add_below = 'comment';
			} ?>

			<article <?php comment_class( empty( $args['has_children'] ) ? '' : 'parent' ) ?> id="comment-<?php comment_ID() ?>" itemscope itemtype="http://schema.org/Comment">
				<div class="comment-content" itemprop="text">
					<figure class="gravatar"><?php echo get_avatar( $comment, 256 ); ?></figure>
					<div class="comment-meta post-meta" role="complementary">
						<div class="comment-author">
							<b class="fn">
								<a rel="external nofollow" class="url comment-author-link" href="<?php comment_author_url(); ?>" itemprop="author"><?php comment_author(); ?></a>
							</b>
						</div>
						<time class="comment-meta-item" datetime="<?php comment_date( 'Y-m-d' ); ?>T<?php comment_time( 'H:iP' ) ?>" itemprop="datePublished"><span><?php comment_date( 'F jS Y' ); ?>, <a href="#comment-<?php comment_ID(); ?>" itemprop="url"><?php comment_time(); ?></a></span></time>
						<?php edit_comment_link( '<p class="comment-meta-item">' . esc_html__( 'Edit this comment', 'slikk' ) . '</p>', '', '' ); ?>
						<?php if ( $comment->comment_approved == '0' ) : ?>
							<p class="comment-meta-item"><?php esc_html_e( 'Your comment is awaiting moderation.', 'slikk' ); ?></p>
						<?php endif; ?>
						<?php comment_text(); ?>
						<?php comment_reply_link(
								array_merge(
									$args,
									[
										'reply_text' => '<span>' . esc_html__( 'Reply', 'slikk' ) . '</span>',
										'add_below' => $add_below,
										'depth' => $depth,
										'max_depth' => $args['max_depth'],
									]
								)
						); ?>
					</div>
				</div>

		<?php }
		function end_el( &$output, $comment, $depth = 0, $args = [] ) { ?>

			</article>

		<?php }
		function __destruct() { ?>

			</section>

		<?php }

	}
} // end class check