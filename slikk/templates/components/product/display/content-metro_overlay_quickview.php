<?php
/**
 * Template part for displaying posts with the "metro" display
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage Slikk
 * @version 1.4.2
 */
$classes = array();

/* Related product default class */
if ( is_singular( 'product' ) ) {
	$classes = array( 'entry-product entry-product-metro_overlay_quickview', 'entry-columns-default' );
} else {
	$columns = slikk_get_theme_mod( 'product_columns', 'default' );
	$classes = array( $columns );
}

$metro_size = apply_filters( 'slikk_metro_thumbnail_size_name', 'slikk-metro' );
$thumbnail_size = ( slikk_is_gif( get_post_thumbnail_id() ) ) ? 'full' : $metro_size;
?>
<article <?php slikk_post_attr( $classes ); ?>>
	<div class="entry-box">
		<div class="entry-outer">
			<div class="entry-container">
				<div class="product-thumbnail-container entry-image">
					<div class="product-thumbnail-inner entry-cover">
						<?php do_action( 'slikk_product_minimal_player' ); ?>
						<?php woocommerce_show_product_loop_sale_flash(); ?>
						
						<?php echo woocommerce_get_product_thumbnail( $thumbnail_size ); ?>
						<?php slikk_woocommerce_second_product_thumbnail( $thumbnail_size ); ?>

						<div class="product-overlay">
							<a class="entry-link-mask" href="<?php the_permalink(); ?>"></a>
							<div class="product-overlay-table">
								<div class="product-overlay-table-cell">
									<div class="product-actions">
										<?php
											/**
											 * Quickview button
											 */
											do_action( 'slikk_product_quickview_button' );
										?>
										<?php
											/**
											 * Wishlist button
											 */
											do_action( 'slikk_add_to_wishlist_button' );
										?>
										<?php
											/**
											 * Add to cart button
											 */
											do_action( 'slikk_product_add_to_cart_button' );
										?>
										<?php
											/**
											 * More button
											 */
											do_action( 'slikk_product_more_button' );
										?>
									</div><!-- .product-actions -->
								</div><!-- .product-overlay-table-cell -->
							</div><!-- .product-overlay-table -->
						</div><!-- .product-overlay -->
					</div><!-- .product-thumbnail-inner -->
				</div><!-- .product-thumbnail-container -->

				<div class="product-summary clearfix">
					<?php woocommerce_template_loop_product_link_open(); ?>
						<?php woocommerce_template_loop_product_title(); ?>
						<?php
							/**
							 * After title
							 */
							do_action( 'slikk_after_shop_loop_item_title' );
						?>
						<?php woocommerce_template_loop_price(); ?>
					<?php woocommerce_template_loop_product_link_close(); ?>
				</div><!-- .product-summary -->
			</div><!-- .entry-container -->
		</div><!-- .entry-outer -->
	</div><!-- .entry-box -->
</article><!-- #post-## -->