<?php
/**
 * Slikk customizer fonts preview functions
 *
 * @package WordPress
 * @subpackage Slikk
 * @version 1.4.2
 */

defined( 'ABSPATH' ) || exit;

/**
 * Returns CSS for the layout.
 *
 * @param array $values Fonts family.
 * @return string
 */
function slikk_get_layout_css( $values ) {

	$values = wp_parse_args(
		$values,
		array(
			'site_width'                   => '',
			'menu_item_horizontal_padding' => '',
			'logo_max_width'               => '',
		)
	);

	extract( $values );

	$layout_css = '';

	if ( $site_width ) {
	}

	if ( $logo_max_width ) {
		$layout_css .= '
			.logo{
				max-width:' . $logo_max_width . ';
			}
		';
	}

	if ( $menu_item_horizontal_padding ) {
		$layout_css .= '
			.nav-menu-desktop li a{
				padding: 0 ' . $menu_item_horizontal_padding . 'px;
			}
		';
	}

	/* make "hot" & "new" menu label translatable */
	$layout_css .= '
		.nav-menu li.hot > a .menu-item-text-container:before{
			content : "' . esc_html__( 'hot', 'slikk' ) . '";
		}

		.nav-menu li.new > a .menu-item-text-container:before{
			content : "' . esc_html__( 'new', 'slikk' ) . '";
		}

		.nav-menu li.sale > a .menu-item-text-container:before{
			content : "' . esc_html__( 'sale', 'slikk' ) . '";
		}
	';

	return apply_filters( 'slikk_layout_css_output', $layout_css, $values );
}

/**
 * Get array of layout values of the Underscore template
 *
 * @return array $values
 */
function slikk_get_template_layout() {

	$values = array(
		'site_width',
		'logo_max_width',
	);

	foreach ( $values as $id ) {
		$values[ $id ] = '{{ data.' . $id . ' }}';
	}

	return $values;
}

/**
 * Outputs an Underscore template for generating CSS for the layout.
 *
 * The template generates the css dynamically for instant display in the
 * Customizer preview.
 */
function slikk_layout_css_template() {
	$layout = slikk_get_template_layout();
	?>
	<script type="text/html" id="tmpl-slikk-layout">
		<?php echo slikk_get_layout_css( $layout ); ?>
	</script>
	<?php
}
add_action( 'customize_controls_print_footer_scripts', 'slikk_layout_css_template' );
