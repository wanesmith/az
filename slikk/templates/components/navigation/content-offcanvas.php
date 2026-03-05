<?php
/**
 * Displays offcanvas navigation type
 *
 * @package WordPress
 * @subpackage Slikk
 * @version 1.4.2
 */
?>
<div id="nav-bar" class="nav-bar" data-menu-layout="offcanvas">
	<div class="flex-wrap">
		<div class="logo-container">
			<?php
				/**
				 * Logo
				 */
				slikk_logo();
			?>
		</div><!-- .logo-container -->
		<div class="cta-container">
			<?php
				/**
				 * Secondary menu hook
				 */
				do_action( 'slikk_secondary_menu', 'desktop' );
			?>
		</div><!-- .cta-container -->
		<div class="hamburger-container">
			<?php
				/**
				 * Menu hamburger icon
				 */
				slikk_hamburger_icon( 'toggle-offcanvas-menu' );
			?>
		</div><!-- .hamburger-container -->
	</div><!-- .flex-wrap -->
</div><!-- #navbar-container -->