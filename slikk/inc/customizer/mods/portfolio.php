<?php
/**
 * Slikk customizer work mods
 *
 * @package WordPress
 * @subpackage Slikk
 * @version 1.4.2
 */

defined( 'ABSPATH' ) || exit;

/**
 * Portoflio mods
 *
 * @param array $mods Array of mods.
 * @return array
 */
function slikk_set_work_mods( $mods ) {

	if ( class_exists( 'Wolf_Portfolio' ) ) {

		$mods['portfolio'] = [
			'id' => 'portfolio',
			'icon' => 'portfolio',
			'title' => esc_html__( 'Portfolio', 'slikk' ),
			'options' => [

				'work_layout' => [
					'id' =>'work_layout',
					'label' => esc_html__( 'Portfolio Layout', 'slikk' ),
					'type' => 'select',
					'choices' => [
						'standard' => esc_html__( 'Standard', 'slikk' ),
						'fullwidth' => esc_html__( 'Full width', 'slikk' ),
					],
				],

				'work_display' => [
					'id' =>'work_display',
					'label' => esc_html__( 'Portfolio Display', 'slikk' ),
					'type' => 'select',
					'choices' => apply_filters( 'slikk_work_display_options', [
						'grid' => esc_html__( 'Grid', 'slikk' ),
					] ),
				],

				'work_grid_padding' => [
					'id' => 'work_grid_padding',
					'label' => esc_html__( 'Padding (for grid style display only)', 'slikk' ),
					'type' => 'select',
					'choices' => [
						'yes' => esc_html__( 'Yes', 'slikk' ),
						'no' => esc_html__( 'No', 'slikk' ),
					],
					'transport' => 'postMessage',
				],

				'work_item_animation' => [
					'label' => esc_html__( 'Portfolio Post Animation', 'slikk' ),
					'id' => 'work_item_animation',
					'type' => 'select',
					'choices' => slikk_get_animations(),
				],

				'work_pagination' => [
					'id' => 'work_pagination',
					'label' => esc_html__( 'Portfolio Archive Pagination', 'slikk' ),
					'type' => 'select',
					'choices' => [
						'none' => esc_html__( 'None', 'slikk' ),
						'standard_pagination' => esc_html__( 'Numeric Pagination', 'slikk' ),
						'load_more' => esc_html__( 'Load More Button', 'slikk' ),
					],
					'description' => esc_html__( 'You must set a number of posts per page below. The category filter will not be disabled.', 'slikk' ),
				],

				'works_per_page' => [
					'label' => esc_html__( 'Works per Page', 'slikk' ),
					'id' => 'works_per_page',
					'type' => 'text',
					'placeholder' => 6,
				],
			],
		];
	}

	return $mods;
}
add_filter( 'slikk_customizer_mods', 'slikk_set_work_mods' );
