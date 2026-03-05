<?php
/**
 * Slikk shop
 *
 * @package WordPress
 * @subpackage Slikk
 * @version 1.4.2
 */

defined( 'ABSPATH' ) || exit;

/**
 * Shop mods
 *
 * @param array $mods Array of mods.
 * @return array
 */
function slikk_set_product_mods( $mods ) {

	if ( class_exists( 'WooCommerce' ) ) {
		$mods['shop'] = array(
			'id'      => 'shop',
			'title'   => esc_html__( 'Shop', 'slikk' ),
			'icon'    => 'cart',
			'options' => array(

				'product_layout'            => array(
					'id'        => 'product_layout',
					'label'     => esc_html__( 'Products Layout', 'slikk' ),
					'type'      => 'select',
					'choices'   => array(
						'standard'      => esc_html__( 'Standard', 'slikk' ),
						'sidebar-right' => esc_html__( 'Sidebar at right', 'slikk' ),
						'sidebar-left'  => esc_html__( 'Sidebar at left', 'slikk' ),
						'fullwidth'     => esc_html__( 'Full width', 'slikk' ),
					),
					'transport' => 'postMessage',
				),

				'product_display'           => array(
					'id'      => 'product_display',
					'label'   => esc_html__( 'Products Archive Display', 'slikk' ),
					'type'    => 'select',
					'choices' => apply_filters(
						'slikk_product_display_options',
						array(
							'grid_classic' => esc_html__( 'Grid', 'slikk' ),
						)
					),
				),
				'product_single_layout'     => array(
					'id'        => 'product_single_layout',
					'label'     => esc_html__( 'Single Product Layout', 'slikk' ),
					'type'      => 'select',
					'choices'   => array(
						'standard'      => esc_html__( 'Standard', 'slikk' ),
						'sidebar-right' => esc_html__( 'Sidebar at right', 'slikk' ),
						'sidebar-left'  => esc_html__( 'Sidebar at left', 'slikk' ),
						'fullwidth'     => esc_html__( 'Full Width', 'slikk' ),
					),
					'transport' => 'postMessage',
				),

				'product_columns'           => array(
					'id'      => 'product_columns',
					'label'   => esc_html__( 'Columns', 'slikk' ),
					'type'    => 'select',
					'choices' => array(
						'default' => esc_html__( 'Auto', 'slikk' ),
						3         => 3,
						2         => 2,
						4         => 4,
						6         => 6,
					),
				),

				'product_item_animation'    => array(
					'label'   => esc_html__( 'Shop Archive Item Animation', 'slikk' ),
					'id'      => 'product_item_animation',
					'type'    => 'select',
					'choices' => slikk_get_animations(),
				),

				'product_zoom'              => array(
					'label' => esc_html__( 'Single Product Zoom', 'slikk' ),
					'id'    => 'product_zoom',
					'type'  => 'checkbox',
				),

				'related_products_carousel' => array(
					'label' => esc_html__( 'Related Products Carousel', 'slikk' ),
					'id'    => 'related_products_carousel',
					'type'  => 'checkbox',
				),

				'cart_menu_item'            => array(
					'label' => esc_html__( 'Add a "Cart" Menu Item', 'slikk' ),
					'id'    => 'cart_menu_item',
					'type'  => 'checkbox',
				),

				'account_menu_item'         => array(
					'label' => esc_html__( 'Add a "Account" Menu Item', 'slikk' ),
					'id'    => 'account_menu_item',
					'type'  => 'checkbox',
				),

				'shop_search_menu_item'     => array(
					'label' => esc_html__( 'Search Menu Item', 'slikk' ),
					'id'    => 'shop_search_menu_item',
					'type'  => 'checkbox',
				),

				'products_per_page'         => array(
					'label'       => esc_html__( 'Products per Page', 'slikk' ),
					'id'          => 'products_per_page',
					'type'        => 'text',
					'placeholder' => 12,
				),
			),
		);
	}

	if ( class_exists( 'Wolf_WooCommerce_Currency_Switcher' ) || defined( 'WOOCS_VERSION' ) ) {
		$mods['shop']['options']['currency_switcher'] = array(
			'label' => esc_html__( 'Add Currency Switcher to Menu', 'slikk' ),
			'id'    => 'currency_switcher',
			'type'  => 'checkbox',
		);
	}

	if ( class_exists( 'Wolf_WooCommerce_Wishlist' ) && class_exists( 'WooCommerce' ) ) {
		$mods['shop']['options']['wishlist_menu_item'] = array(
			'label' => esc_html__( 'Wishlist Menu Item', 'slikk' ),
			'id'    => 'wishlist_menu_item',
			'type'  => 'checkbox',
		);
	}

	return $mods;
}
add_filter( 'slikk_customizer_mods', 'slikk_set_product_mods' );
