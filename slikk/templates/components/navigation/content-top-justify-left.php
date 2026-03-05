<?php
/**
 * Displays top justify navigation type
 *
 * @package WordPress
 * @subpackage Slikk
 * @version 1.4.2
 */
?>
<div id="nav-bar" class="nav-bar" data-menu-layout="top-justify-left">
	<div class="flex-wrap">
		<?php
		if ( 'left' === slikk_get_inherit_mod( 'side_panel_position' ) && slikk_can_display_sidepanel() ) {
			/**
			 * Output sidepanel hamburger
			 */
			do_action( 'slikk_sidepanel_hamburger' );
		}
		?>
		<div class="logo-container">
			<?php
				/**
				 * Logo
				 */
				slikk_logo();
			?>
		</div><!-- .logo-container -->
		<nav class="menu-container" itemscope="itemscope"  itemtype="http://schema.org/SiteNavigationElement">
			<?php
				/**
				 * Menu
				 */
				slikk_primary_desktop_navigation();
			?>
		</nav><!-- .menu-container -->
		<div class="cta-container">
			<?php
				/**
				 * Secondary menu hook
				 */
				do_action( 'slikk_secondary_menu', 'desktop' );
			?>
		</div><!-- .cta-container -->
		<?php
		if ( 'right' === slikk_get_inherit_mod( 'side_panel_position' ) && slikk_can_display_sidepanel() ) {
			/**
			 * Output sidepanel hamburger
			 */
			do_action( 'slikk_sidepanel_hamburger' );
		}
		?>
	</div><!-- .flex-wrap -->
</div><!-- #navbar-container -->
