<?php
/**
 * Slikk about page
 *
 * @package WordPress
 * @subpackage Slikk
 * @version 1.4.2
 */

defined( 'ABSPATH' ) || exit;

if ( ! class_exists( 'Slikk_Admin_About_Page' ) ) {
	/**
	 * About Page Class
	 */
	class Slikk_Admin_About_Page {

		var $theme_name;
		var $theme_version;
		var $theme_slug;
		var $user_capability;

		/**
		 * __construct function.
		 */
		public function __construct() {

			$this->theme_name      = slikk_get_theme_name();
			$this->theme_version   = slikk_get_theme_version();
			$this->theme_slug      = slikk_get_theme_slug();
			$this->user_capability = 'activate_plugins';

			$this->dismiss_cookie();

			add_action( 'admin_menu', array( $this, 'admin_menus' ) );
			add_action( 'admin_init', array( $this, 'welcome' ) );
		}

		/**
		 * Add admin menus/screens
		 */
		public function admin_menus() {

			add_theme_page( esc_html__( 'About the Theme', 'slikk' ), esc_html__( 'About the Theme', 'slikk' ), 'switch_themes', $this->theme_slug . '-about', array( $this, 'about_screen' ) );
		}

		/**
		 * Admin notice dismiss
		 *
		 * Set cookie from "hide permanently" admin notice links if JS was not available
		 *
		 * @access private
		 */
		private function dismiss_cookie() {
			if ( isset( $_GET['page'] ) && slikk_get_theme_slug() . '-about' === esc_attr( $_GET['page'] ) && isset( $_GET['dismiss'] ) ) {
				$cookie_id = esc_attr( $_GET['dismiss'] );

				setcookie( $cookie_id, 'hide', time() + 2 * YEAR_IN_SECONDS, '/' );
			}
		}

		/**
		 * Into text/links shown on all about pages.
		 *
		 * @access private
		 */
		private function intro() {
			if ( isset( $_GET['slikk-activated'] ) ) { // phpcs:ignore WordPress.Security.NonceVerification.Recommended
				update_user_meta( get_current_user_id(), 'show_welcome_panel', true );
			}

			?>
			<h1><?php printf( esc_html__( 'Welcome to %1$s %2$s', 'slikk' ), esc_attr( $this->theme_name ), esc_attr( $this->theme_version ) ); ?></h1>

			<div class="wp-badge slikk-about-page-logo">
				<?php printf( esc_html__( 'Version %s', 'slikk' ), esc_attr( $this->theme_version ) ); ?>
			</div>
			<?php
		}

		/**
		 * Output the about screen.
		 */
		public function about_screen() {
			?>
			<div class="wrap slikk-about-page-wrap">
				<?php $this->intro(); ?>
				<?php $this->actions(); ?>
				<?php $this->tabs(); ?>
			</div>
			<?php
		}

		/**
		 * Check if TGM plugin activation is completed
		 *
		 * As there isn't any filter or hook to know if TGMPA plugin installation has been completed
		 * We check if its menu exists as it is disabled when plugin is completed
		 */
		private function is_tgmpa_in_da_place() {
			global $submenu;

			$tgmpa_menu_slug = 'tgmpa-install-plugins'; // must be the same as in the plugin config/plugins.php file.

			if ( ! get_user_meta( get_current_user_id(), 'tgmpa_dismissed_notice_tgmpa' ) ) { // if user didn't dismissed the notice.
				if ( isset( $submenu['themes.php'] ) ) {
					$theme_menu_items = $submenu['themes.php'];

					foreach ( $theme_menu_items as $item ) {

						if ( isset( $item[2] ) && $tgmpa_menu_slug == $item[2] ) {
							return true;
							break;
						}
					}
				}
			}
		}

		/**
		 * Output action buttons
		 */
		public function actions() {
			?>
			<p class="slikk-about-actions">
				<?php if ( $this->is_tgmpa_in_da_place() ) : ?>
					<a href="<?php echo esc_url( admin_url( 'themes.php?page=tgmpa-install-plugins' ) ); ?>" class="button button-primary">
						<span class="dashicons dashicons-admin-plugins"></span>
						<?php esc_html_e( 'Install Recommended Plugins', 'slikk' ); ?>
					</a>
				<?php endif; ?>
				<?php if ( slikk_get_theme_changelog() ) : ?>
					<a target="_blank" href="<?php echo esc_url( 'https://docs.wolfthemes.com/documentation/theme/' . slikk_get_theme_slug() ); ?>" class="button">
						<span class="dashicons dashicons-sos"></span>
						<?php esc_html_e( 'Documentation', 'slikk' ); ?>
					</a>
				<?php endif; ?>
			</p>
			<?php
		}

		/**
		 * Tabs
		 */
		private function tabs() {
			?>
			<div id="slikk-welcome-tabs">
				<h2 class="nav-tab-wrapper">
					<?php if ( slikk_get_theme_changelog() || current_user_can( $this->user_capability ) ) : ?>
						<div class="tabs" id="tabs1">

							<?php
								/**
								 * More tabs
								 */
								do_action( 'slikk_before_about_tabs' );
							?>

							<a href="#faq" class="nav-tab"><?php esc_html_e( 'FAQ', 'slikk' ); ?></a>
							<?php if ( current_user_can( $this->user_capability ) ) : ?>
								<a href="#system-status" class="nav-tab"><?php esc_html_e( 'System Status', 'slikk' ); ?></a>

								<?php if ( slikk_get_theme_changelog() ) : ?>
								<a href="#changelog" class="nav-tab"><?php esc_html_e( 'Changelog', 'slikk' ); ?></a>
								<?php endif; ?>
							<?php endif; ?>

							<?php
								/**
								 * More tabs
								 */
								do_action( 'slikk_after_about_tabs' );
							?>

							<?php
								/**
								 * WVC License tab
								 */
								do_action( 'wvc_license_tab' );

								/**
								 * Extension License tab
								 */
								do_action( 'wolf_core_license_tab' );
							?>
						</div>
					<?php endif; ?>
				</h2>

				<div class="content">

					<?php
						/**
						 * More tabs
						 */
						do_action( 'slikk_before_about_tabs_content' );
					?>

					<div id="faq" class="slikk-options-panel">
						<?php $this->faq(); ?>
					</div><!-- #system-status -->

					<?php if ( current_user_can( $this->user_capability ) ) : ?>
						<div id="system-status" class="slikk-options-panel">
							<?php $this->system_status(); ?>
						</div><!-- #system-status -->
					<?php endif; ?>

					<?php if ( slikk_get_theme_changelog() ) : ?>
						<div id="changelog" class="slikk-options-panel">
							<?php $this->changelog(); ?>
						</div><!-- #changelog -->
					<?php endif; ?>

					<?php
						/**
						 * More tabs
						 */
						do_action( 'slikk_after_about_tabs_content' );
					?>

					<?php
						/**
						 * WVC License tab content
						 */
						do_action( 'wvc_license_tab_content' );

						/**
						 * Wolf Core License tab
						 */
						do_action( 'wolf_core_license_tab_content' );
					?>
				</div>
			</div><!-- #slikk-about-tabs -->
			<?php
		}

		/**
		 * FAQ
		 */
		public function faq() {
			?>
			<div class="faq-text slikk-faq-text">
				<div class="row slikk-about-columns">
					<div class="col col-4">
						<h4><?php esc_html_e( 'Getting Started', 'slikk' ); ?></h4>
						<ul>
							<li><a href="https://wolfthemes.ticksy.com/article/11652/" target="_blank"><?php esc_html_e( 'Before Getting Started', 'slikk' ); ?></a></li>
							<li><a href="https://wolfthemes.ticksy.com/article/11655/" target="_blank"><?php esc_html_e( 'Install Recommended Plugins', 'slikk' ); ?></a></li>
							<li><a href="https://wolfthemes.ticksy.com/article/11656/" target="_blank"><?php esc_html_e( 'Import Demo Data', 'slikk' ); ?></a></li>
							<li><a href="https://wolfthemes.ticksy.com/article/13268/" target="_blank"><?php esc_html_e( 'Activate the Page Builder Extension', 'slikk' ); ?></a></li>
							<li><a href="https://wolfthemes.com/wordpress-theme-installation-customization-services/?o=faq" target="_blank"><?php esc_html_e( 'Installation & Customization Services', 'slikk' ); ?></a></li>
						</ul>
					</div>
					<div class="col col-4">
						<h4><?php esc_html_e( 'Troubleshooting', 'slikk' ); ?></h4>
						<ul>
							<li><a href="https://wolfthemes.ticksy.com/article/11682/" target="_blank"><?php esc_html_e( '"Wrong theme" error message', 'slikk' ); ?></a></li>
							<li><a href="https://wolfthemes.ticksy.com/article/11682/" target="_blank"><?php esc_html_e( 'Stylesheet is missing', 'slikk' ); ?></a></li>
							<li><a href="https://wolfthemes.ticksy.com/article/11680/" target="_blank"><?php esc_html_e( 'Issue Importing the Demo', 'slikk' ); ?></a></li>
							<li><a href="https://wolfthemes.ticksy.com/article/11681/" target="_blank"><?php esc_html_e( '404 error page', 'slikk' ); ?></a></li>
							<li><a href="https://wolfthemes.ticksy.com/article/11678/" target="_blank"><?php esc_html_e( 'Other FAQ\'s', 'slikk' ); ?></a></li>
						</ul>
					</div>
					<div class="col col-4">
						<h4><?php esc_html_e( 'Help', 'slikk' ); ?></h4>
						<ul>
							<li><a href="https://docs.wolfthemes.com/documentation/theme/<?php echo esc_attr( $this->theme_slug ); ?>" target="_blank"><?php esc_html_e( 'Theme Documentation', 'slikk' ); ?></a></li>
							<li><a href="https://wolfthemes.ticksy.com/article/11671/" target="_blank"><?php esc_html_e( 'Update WPBakery Page Builder', 'slikk' ); ?></a></li>
							<li><a href="https://wolfthemes.ticksy.com/article/12629/" target="_blank"><?php esc_html_e( 'Bundled Plugin Activation', 'slikk' ); ?></a></li>
						</ul>
					</div>
				</div>
				<div class="row slikk-about-columns">
					<div class="col col-4">
						<h4><?php esc_html_e( 'How To\'s', 'slikk' ); ?></h4>
						<ul>
							<li><a href="https://wolfthemes.ticksy.com/article/12792" target="_blank"><?php esc_html_e( 'Use Content Blocks', 'slikk' ); ?></a></li>
							<li><a href="https://wolfthemes.ticksy.com/article/13469/" target="_blank"><?php esc_html_e( 'Increase Your Loading Speed', 'slikk' ); ?></a></li>
							<li><a href="https://wolfthemes.ticksy.com/article/11669/" target="_blank"><?php esc_html_e( 'Translate your Theme', 'slikk' ); ?></a></li>
							<li><a href="https://wolfthemes.ticksy.com/article/11664/" target="_blank"><?php esc_html_e( '"Coming Soon" or "Maintenance" Mode', 'slikk' ); ?></a></li>
							<li><a href="https://wolfthemes.ticksy.com/article/11975/" target="_blank"><?php esc_html_e( 'Create a custom 404 Error Page', 'slikk' ); ?></a></li>
						</ul>
					</div>
					<div class="col col-4">
						<h4>
						<?php
						printf(
							/* translators: %s: theme name */
							slikk_kses( __( 'Need more help using %s?', 'slikk' ) ), // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped,Generic.Files.EndFileNewline.NotFound
							esc_attr( $this->theme_name )
						);
						?>
						</h4>
						<p>
							<?php
								printf(
									/* translators: 1: forum KB link, 2: forum link */
									slikk_kses( __( 'We will find our complete knowledge base here: <a href="%1$s" target="_blank">%2$s</a>.', 'slikk' ) ), // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped,Generic.Files.EndFileNewline.NotFound
									'https://wolfthemes.ticksy.com/articles/',
									'https://wolfthemes.com/help/'
								);
							?>
						</p>
					</div>
					<div class="col col-4"></div>
				</div>

			</div>
			<?php
		}

		/**
		 * System status
		 *
		 * Display system status
		 */
		private function system_status() {

			$vars = slikk_get_minimum_required_server_vars();
			?>
			<div id="slikk-system-status">
				<?php if ( ! slikk_get_theme_changelog() ) : ?>
					<h3><?php esc_html_e( 'System Status', 'slikk' ); ?></h3>
				<?php endif; ?>
				<p>
					<?php esc_html_e( 'Check that all the requirements below are fulfiled and labeled in green.', 'slikk' ); ?>
				</p>

				<h4><?php esc_html_e( 'WordPress Environment', 'slikk' ); ?></h4>

				<table>
			<?php
			$xml_latest   = '5.5';
			$xml_requires = $vars['REQUIRED_WP_VERSION'];

			$xml = slikk_get_theme_changelog();

			if ( $xml ) {
				$xml_latest   = (string) $xml->latest;
				$xml_requires = (string) $xml->requires;
			}
			$theme_version = slikk_get_parent_theme_version();

			$required_theme_version      = $xml_latest;
			$theme_version_condition     = ( version_compare( $theme_version, $required_theme_version, '>=' ) );
			$theme_update_url            = ( class_exists( 'Envato_Market' ) ) ? admin_url( 'admin.php?page=envato-market' ) : 'https://wolfthemes.ticksy.com/article/11658/';
			$target                      = ( class_exists( 'Envato_Market' ) ) ? '_parent' : '_blank';
			$theme_version_error_message = ( ! $theme_version_condition ) ? ' - ' . esc_html__( 'It is recommended to update the theme to the latest version', 'slikk' ) : '';
			?>
					<tr>
						<td class="label"><?php esc_html_e( 'Theme Version', 'slikk' ); ?></td>
						<td class="help"><a class="hastip" title="
						<?php
						/* translators: %s: theme version */
						esc_attr_e( sprintf( __( 'The version of %s installed on your site.', 'slikk' ), slikk_get_theme_name() ) );
						?>
						" target="<?php echo esc_attr( $target ); ?>" href="<?php echo esc_url( $theme_update_url ); ?>"><span class="dashicons dashicons-editor-help"></span></a></td>
						<td class="data <?php echo ( esc_attr( $theme_version_condition ) ) ? 'green' : 'red'; ?>"><?php echo esc_attr( $theme_version . $theme_version_error_message ); ?></td>
						<td class="status <?php echo ( esc_attr( $theme_version_condition ) ) ? 'green' : 'red'; ?>"><?php echo ( esc_attr( $theme_version_condition ) ) ? '<span class="dashicons dashicons-yes"></span>' : '<span class="dashicons dashicons-no"></span>'; ?></td>
					</tr>
			<?php
			$wp_version               = get_bloginfo( 'version' );
			$required_wp_version      = $xml_requires;
			$wp_version_condition     = ( version_compare( $wp_version, $required_wp_version, '>=' ) );
			$wp_version_error_message = ( ! $wp_version_condition ) ? ' - ' . esc_html__( 'It is recommended to update WordPress to the latest version', 'slikk' ) : '';
			?>
					<tr>
						<td class="label"><?php esc_html_e( 'WP Version', 'slikk' ); ?></td>
						<td class="help"><a class="hastip" title="<?php esc_attr_e( __( 'The version of WordPress installed on your site.', 'slikk' ) ); ?>" href="https://wolfthemes.ticksy.com/article/11677/" target="_blank"><span class="dashicons dashicons-editor-help"></span></a></td>
						<td class="data <?php echo ( esc_attr( $wp_version_condition ) ) ? 'green' : 'red'; ?>"><?php echo esc_attr( $wp_version . $wp_version_error_message ); ?></td>
						<td class="status <?php echo ( esc_attr( $wp_version_condition ) ) ? 'green' : 'red'; ?>"><?php echo ( esc_attr( $wp_version_condition ) ) ? '<span class="dashicons dashicons-yes"></span>' : '<span class="dashicons dashicons-no"></span>'; ?></td>
					</tr>
			<?php
			$wp_memory_limit = WP_MEMORY_LIMIT;

			$required_wp_memory_limit      = $vars['REQUIRED_WP_MEMORY_LIMIT'];
			$wp_memory_limit_condition     = ( wp_convert_hr_to_bytes( $wp_memory_limit ) >= wp_convert_hr_to_bytes( $required_wp_memory_limit ) );
			$wp_memory_limit_error_message = ( ! $wp_memory_limit_condition ) ? ' - ' . sprintf( __( 'It is recommended to increase your WP memory limit to %s at least', 'slikk' ), $vars['REQUIRED_WP_MEMORY_LIMIT'] ) : '';
			?>
					<tr>
						<td class="label"><?php esc_html_e( 'WP Memory Limit', 'slikk' ); ?></td>
						<td class="help"><a class="hastip" title="<?php esc_attr_e( __( 'The maximum amount of memory (RAM) that your site can use at one time.', 'slikk' ) ); ?>" href="https://wolfthemes.ticksy.com/article/11676/" target="_blank"><span class="dashicons dashicons-editor-help"></span></a></td>
						<td class="data <?php echo ( esc_attr( $wp_memory_limit_condition ) ) ? 'green' : 'red'; ?>"><?php echo esc_attr( $wp_memory_limit . $wp_memory_limit_error_message ); ?></td>
						<td class="status <?php echo ( esc_attr( $wp_memory_limit_condition ) ) ? 'green' : 'red'; ?>"><?php echo ( esc_attr( $wp_memory_limit_condition ) ) ? '<span class="dashicons dashicons-yes"></span>' : '<span class="dashicons dashicons-no"></span>'; ?></td>
					</tr>
			<?php
			$wp_debug               = ( false === WP_DEBUG ) ? 'false' : 'true';
			$required_wp_debug      = false;
			$wp_debug_condition     = ( WP_DEBUG === $required_wp_debug );
			$wp_debug_error_message = ( ! $wp_debug_condition ) ? ' - ' . sprintf( __( 'It is recommended to set WP_DEBUG to %s on a production website.', 'slikk' ), 'false' ) : '';
			?>
					<tr>
						<td class="label"><?php esc_html_e( 'WP Debug', 'slikk' ); ?></td>
						<td class="help"><a class="hastip" title="<?php esc_attr_e( __( 'A PHP constant used to trigger the “debug” mode throughout WordPress.', 'slikk' ) ); ?>" href="https://wordpress.org/support/article/debugging-in-wordpress/" target="_blank"><span class="dashicons dashicons-editor-help"></span></a></td>
						<td class="data <?php echo ( esc_attr( $wp_debug_condition ) ) ? 'green' : 'red'; ?>">
						<?php echo esc_attr( $wp_debug . $wp_debug_error_message ); ?>
						</td>
						<td class="status <?php echo ( esc_attr( $wp_debug_condition ) ) ? 'green' : 'red'; ?>">
						<?php echo ( esc_attr( $wp_debug_condition ) ) ? '<span class="dashicons dashicons-yes"></span>' : '<span class="dashicons dashicons-no"></span>'; ?></td>
					</tr>

			<?php
			$max_upload_size = size_format( wp_max_upload_size() );
			?>
					<tr>
						<td class="label"><?php esc_html_e( 'WP Max Upload Size', 'slikk' ); ?></td>
						<td class="help"><a class="hastip" title="<?php esc_attr_e( __( 'The largest filesize that can be uploaded to your WordPress installation.', 'slikk' ) ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped,Generic.Files.EndFileNewline.NotFound ?>"
						href="https://www.wpbeginner.com/wp-tutorials/how-to-increase-the-maximum-file-upload-size-in-wordpress/" target="_blank"><span class="dashicons dashicons-editor-help"></span></a></td>
						<td class="data"><?php echo esc_attr( $max_upload_size ); ?></td>
						<td class="status">&nbsp;</td>
					</tr>

				</table>

				<h4><?php esc_html_e( 'Server Environment', 'slikk' ); ?></h4>

				<table>
			<?php
			$php_version = phpversion();

			$required_php_version      = $vars['REQUIRED_PHP_VERSION'];
			$php_version_condition     = ( version_compare( $php_version, $required_php_version, '>=' ) );
			$php_version_error_message = ( ! $php_version_condition ) ? ' - ' . sprintf( __( 'The theme needs at least PHP %s installed on your server', 'slikk' ), $vars['REQUIRED_PHP_VERSION'] ) : '';
			?>
					<tr>
						<td class="label"><?php esc_html_e( 'PHP Version', 'slikk' ); ?></td>
						<td class="help"><a class="hastip" title="<?php esc_attr_e( __( 'The version of PHP installed on your hosting server.', 'slikk' ) ); ?>" href="https://wolfthemes.ticksy.com/article/11673/" target="_blank"><span class="dashicons dashicons-editor-help"></span></a></td>
						<td class="data <?php echo ( esc_attr( $php_version_condition ) ) ? 'green' : 'red'; ?>"><?php echo esc_attr( $php_version . $php_version_error_message ); ?></td>
						<td class="status <?php echo ( esc_attr( $php_version_condition ) ) ? 'green' : 'red'; ?>"><?php echo ( esc_attr( $php_version_condition ) ) ? '<span class="dashicons dashicons-yes"></span>' : '<span class="dashicons dashicons-no"></span>'; ?></td>
					</tr>
			<?php
			$max_input_vars = @ini_get( 'max_input_vars' );

			$required_max_input_vars                = $vars['REQUIRED_MAX_INPUT_VARS'];
			$max_input_vars_condition               = ( $max_input_vars >= $required_max_input_vars );
			$max_input_vars_condition_error_message = ( ! $max_input_vars_condition ) ? ' - ' . sprintf( __( 'It is recommended to increase your server max_input_var value to %s at least', 'slikk' ), $vars['REQUIRED_MAX_INPUT_VARS'] ) : '';
			?>
					<tr>
						<td class="label"><?php esc_html_e( 'PHP Max Input Vars', 'slikk' ); ?></td>
						<td class="help"><a class="hastip" title="<?php esc_attr_e( __( 'The maximum amount of variable your server can use for a single function.', 'slikk' ) ); ?>" href="https://wolfthemes.ticksy.com/article/11675/" target="_blank"><span class="dashicons dashicons-editor-help"></span></a></td>
						<td class="data <?php echo ( esc_attr( $max_input_vars_condition ) ) ? 'green' : 'red'; ?>"><?php echo esc_attr( $max_input_vars . $max_input_vars_condition_error_message ); ?></td>
						<td class="status <?php echo ( esc_attr( $max_input_vars_condition ) ) ? 'green' : 'red'; ?>"><?php echo ( esc_attr( $max_input_vars_condition ) ) ? '<span class="dashicons dashicons-yes"></span>' : '<span class="dashicons dashicons-no"></span>'; ?></td>
					</tr>

			<?php
			$php_memory_limit = @ini_get( 'memory_limit' );

			$required_php_memory_limit      = $vars['REQUIRED_SERVER_MEMORY_LIMIT'];
			$php_memory_limit_condition     = ( wp_convert_hr_to_bytes( $php_memory_limit ) >= wp_convert_hr_to_bytes( $required_php_memory_limit ) );
			$php_memory_limit_error_message = ( ! $php_memory_limit_condition ) ? ' - ' . sprintf( __( 'It is recommended to increase your server memory limit to %s at least', 'slikk' ), $vars['REQUIRED_SERVER_MEMORY_LIMIT'] ) : '';
			?>
					<tr>
						<td class="label"><?php esc_html_e( 'Server Memory Limit', 'slikk' ); ?></td>
						<td class="help"><a class="hastip" title="<?php esc_attr_e( __( 'The maximum amount of memory (RAM) that your server can use at one time.', 'slikk' ) ); ?>" href="https://wolfthemes.ticksy.com/article/11674/" target="_blank"><span class="dashicons dashicons-editor-help"></span></a></td>
						<td class="data <?php echo ( esc_attr( $php_memory_limit_condition ) ) ? 'green' : 'red'; ?>"><?php echo esc_attr( $php_memory_limit . $php_memory_limit_error_message ); ?></td>
						<td class="status <?php echo ( esc_attr( $php_memory_limit_condition ) ) ? 'green' : 'red'; ?>"><?php echo ( esc_attr( $php_memory_limit_condition ) ) ? '<span class="dashicons dashicons-yes"></span>' : '<span class="dashicons dashicons-no"></span>'; ?></td>
					</tr>

			<?php
			$gd_library = extension_loaded( 'gd' );
			?>
					<tr>
						<td class="label"><?php esc_html_e( 'GD Library', 'slikk' ); ?></td>
						<td class="help"><a class="hastip" title="<?php esc_attr_e( __( 'A common PHP extension to process image.', 'slikk' ) ); ?>" href="https://wolfthemes.ticksy.com/article/14455" target="_blank"><span class="dashicons dashicons-editor-help"></span></a></td>
						<td class="data <?php echo ( esc_attr( $gd_library ) ) ? 'green' : ''; ?>"><?php echo ( esc_attr( $gd_library ) ) ? esc_html__( 'YES', 'slikk' ) : esc_html__( 'NO', 'slikk' ); ?></td>
						<td class="status <?php echo ( esc_attr( $gd_library ) ) ? 'green' : ''; ?>"><?php echo ( esc_attr( $gd_library ) ) ? '<span class="dashicons dashicons-yes"></span>' : '<span class="dashicons dashicons-no"></span>'; ?></td>
					</tr>

			<?php
			$php_post_max_size = size_format( wp_convert_hr_to_bytes( @ini_get( 'post_max_size' ) ) );
			?>
					<tr>
						<td class="label"><?php esc_html_e( 'PHP Post Max Size', 'slikk' ); ?></td>
						<td class="help"><a class="hastip" title="<?php esc_attr_e( __( 'The largest filesize that can be contained in one post.', 'slikk' ) ); ?>" href="https://wolfthemes.ticksy.com/article/11672/" target="_blank"><span class="dashicons dashicons-editor-help"></span></a></td>
						<td class="data"><?php echo esc_attr( $php_post_max_size ); ?></td>
						<td class="status">&nbsp;</td>
					</tr>
				</table>

				<p>
				<?php
					printf(
						__( 'Please check the <a target="_blank" href="%1$s">server requirements</a> recommended by WordPress. You can find more informations <a href="%2$s" target="_blank">here</a>.', 'slikk' ),
						'https://wordpress.org/about/requirements/',
						'https://wolfthemes.ticksy.com/article/11651/'
					)
				?>
				</p>
			</div><!-- .slikk-system-status -->

			<?php
		}

		/**
		 * Output the last new feature if set in the changelog XML
		 */
		private function changelog() {

			$xml = slikk_get_theme_changelog();

			if ( $xml ) {
				?>
				<div id="slikk-notifications">

					<?php
					if ( '' !== (string) $xml->warning ) {
						$warning = (string) $xml->warning;
						?>
						<div class="slikk-changelog-notice slikk-notice-warning" id="slikk-changelog-warning"><?php echo slikk_kses( $warning ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped,Generic.Files.EndFileNewline.NotFound ?></div>
					<?php } ?>
					<?php
					if ( '' !== (string) $xml->info ) {
						$info = (string) $xml->info;
						?>
						<div class="slikk-changelog-notice slikk-notice-info" id="slikk-changelog-info"><?php echo slikk_kses( $info ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped,Generic.Files.EndFileNewline.NotFound ?></div>
					<?php } ?>
					<?php
					if ( '' !== (string) $xml->new ) {
						$new = (string) $xml->new;
						?>
						<div class="slikk-changelog-notice slikk-notice-news" id="slikk-changelog-news"><?php echo slikk_kses( $new ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped,Generic.Files.EndFileNewline.NotFound ?></div>
					<?php } ?>
				</div><!-- #slikk-notifications -->

				<div id="slikk-changelog">
					<?php echo slikk_kses( $xml->changelog ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped,Generic.Files.EndFileNewline.NotFound ?>
				</div><!-- #slikk-changelog -->
				<hr>
				<?php
			}
		}

		/**
		 * Sends user to the welcome page on first activation
		 */
		public function welcome() {
			if ( isset( $_GET['activated'] ) && 'true' === $_GET['activated'] ) { // phpcs:ignore WordPress.Security.NonceVerification.Recommended
				flush_rewrite_rules();
				wp_redirect( admin_url( 'admin.php?page=' . $this->theme_slug . '-about&slikk-activated' ) );
				exit;
			}
		}
	}

	new Slikk_Admin_About_Page();
} // end class exists check
