<?php
/**
 * The template for displaying search forms
 *
 * @package WordPress
 * @subpackage Slikk
 * @version 1.4.2
 */

?>

<?php $slikk_unique_id = uniqid( 'search-form-' ); ?>

<form role="search" method="get" class="search-form" action="<?php echo esc_url( home_url( '/' ) ); ?>">
	<label for="<?php echo esc_attr( $slikk_unique_id ); ?>">
		<span class="screen-reader-text"><?php echo esc_attr_x( 'Search for:', 'label', 'slikk' ); ?></span>
	</label>
	<input type="search" id="<?php echo esc_attr( $slikk_unique_id ); ?>" class="search-field" placeholder="<?php echo esc_attr( apply_filters( 'slikk_searchform_placeholder', esc_attr_x( 'Type and hit enter&hellip;', 'placeholder', 'slikk' ) ) ); ?>" value="<?php echo esc_attr( get_search_query() ); ?>" name="s" />
	<button type="submit" class="search-submit"><span class="screen-reader-text"><?php echo esc_attr_x( 'Type and hit enter', 'submit button', 'slikk' ); ?></span></button>
</form>
