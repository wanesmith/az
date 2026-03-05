<?php
/**
 * The product content displayed in the loop for the "grid overlay" display
 *
 * @package WordPress
 * @subpackage Slikk
 * @version 1.4.2
 */
$classes = array();

/* Related product default class */
if ( is_singular( 'product' ) ) {
	$classes = array( 'entry-product entry-product-grid_overlay_quickview', 'entry-columns-default' );
} else {
	$columns = slikk_get_theme_mod( 'product_columns', 'default' );
	$classes = array( $columns );
}

$template_args = ( isset( $template_args ) ) ? $template_args : array();

extract( wp_parse_args( $template_args, array(
	'product_thumbnail_size' => 'woocommerce_thumbnail'
) ) );
?>
<article <?php slikk_post_attr( $classes ); ?>>
	<div class="product-thumbnail-container">
		<div class="product-thumbnail-inner">
			
			<?php do_action( 'slikk_product_minimal_player' ); ?>
			<?php woocommerce_show_product_loop_sale_flash(); ?>
			
			<?php echo woocommerce_get_product_thumbnail( $product_thumbnail_size ); ?>
			<?php slikk_woocommerce_second_product_thumbnail( $product_thumbnail_size ); ?>

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
</article><!-- #post-## -->