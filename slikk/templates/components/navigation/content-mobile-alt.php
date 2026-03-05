<?php
/**
 * Displays mobile navigation
 *
 * @package WordPress
 * @subpackage Slikk
 * @version 1.4.2
 */
?>
<div id="mobile-bar" class="nav-bar">
	<div class="flex-mobile-wrap">
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
				do_action( 'slikk_secondary_menu', 'mobile' );
			?>
		</div><!-- .cta-container -->
		<div class="hamburger-container">
			<?php
				/**
				 * Menu hamburger icon
				 */
				slikk_hamburger_icon( 'toggle-mobile-menu' );
			?>
		</div><!-- .hamburger-container -->
	</div><!-- .flex-wrap -->
</div><!-- #navbar-container -->
