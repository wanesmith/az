<?php
/**
 * Slikk Customizer library class
 *
 * Create customizer inputs from array
 *
 * @package WordPress
 * @subpackage Slikk
 * @version 1.4.2
 */

defined( 'ABSPATH' ) || exit;

if ( ! class_exists( 'Slikk_Customizer_Library' ) ) {
	/**
	 * Slikk Customizer library class
	 *
	 * Create customizer inputs from array
	 *
	 * @package WordPress
	 * @subpackage Slikk
	 * @version 1.4.2
	 */
	class Slikk_Customizer_Library {

		var $sections = array();

		public function __construct( $sections = array() ) {
			$this->sections = $sections + $this->sections;
			add_action( 'customize_register', array( $this, 'register_sections' ) );
		}

		/**
		 *  Set priority depending on array order
		 */
		public function set_priority() {

			$priority = 34;

			foreach ( $this->sections as $key => $value ) {

				$priority++;

				$this->sections[ $key ]['priority'] = $priority;

				if ( isset( $value['options'] ) ) {

					$options_priority = 0;

					foreach ( $value['options'] as $k => $v ) {

						$options_priority++;

						if ( 'background' == $this->sections[ $key ]['options'][ $k ]['type'] ) {
							$options_priority = $options_priority + 9;
						}

						if ( ! isset( $this->sections[ $key ]['options'][ $k ]['priority'] ) ) {
							$this->sections[ $key ]['options'][ $k ]['priority'] = $options_priority;
						}
					}
				}
			}
		}

		/**
		 * Register sections
		 *
		 * @param object $wp_customize
		 */
		public function register_sections( $wp_customize ) {

			$default_priority = 35;

			foreach ( $this->sections as $section ) {
				$default_priority++;
				$section_id    = $section['id'];
				$title         = isset( $section['title'] ) ? $section['title'] : esc_html__( 'Section Title', 'slikk' );
				$description   = isset( $section['description'] ) ? $section['description'] : '';
				$priority      = isset( $section['priority'] ) ? $section['priority'] : $default_priority;
				$is_background = isset( $section['background'] ) ? $section['background'] : false;
				$font_color    = $is_background && isset( $section['font_color'] ) ? $section['font_color'] : true;
				$parallax      = $is_background && isset( $section['parallax'] ) ? $section['parallax'] : false;
				$is_bg_img     = $is_background && isset( $section['img'] ) ? $section['img'] : true;
				$is_no_bg      = $is_background && isset( $section['no_bg'] ) ? $section['no_bg'] : true;
				$opacity       = $is_background && isset( $section['opacity'] ) ? $section['opacity'] : true;
				$transport     = isset( $section['transport'] ) ? $section['transport'] : 'postMessage';

				if ( $is_background ) {
					$this->background_setting( $section, $section_id, $wp_customize, true, $priority );

				} else {

					$wp_customize->add_section(
						$section_id,
						array(
							'title'       => $title,
							'description' => $description,
							'priority'    => $priority,
						)
					);

					$options = $section['options'];

					foreach ( $options as $option ) {

						$label         = $option['label'];
						$option_id     = $option['id'];
						$type          = isset( $option['type'] ) ? $option['type'] : 'text';
						$default       = isset( $option['default'] ) ? $option['default'] : '';
						$priority      = isset( $option['priority'] ) ? $option['priority'] : 1;
						$transport     = isset( $option['transport'] ) ? $option['transport'] : 'refresh';
						$description   = isset( $option['description'] ) ? $option['description'] : '';
						$radio_columns = isset( $option['radio_columns'] ) ? $option['radio_columns'] : 2;

						/*
						 Text
						---------------*/
						if ( 'text' == $type ) {
							$wp_customize->add_setting(
								$option_id,
								array(
									'default'           => $default,
									'transport'         => $transport,
									'sanitize_callback' => array( $this, 'sanitize_text' ),
								)
							);

							$wp_customize->add_control(
								$option_id,
								array(
									'label'       => $label,
									'section'     => $section_id,
									'type'        => 'text',
									'description' => $description,
								)
							);

							/*
							 Integer
							---------------*/
						} elseif ( 'int' == $type ) {

							$wp_customize->add_setting(
								$option_id,
								array(
									'default'           => $default,
									'sanitize_callback' => array( $this, 'sanitize_int' ),
									'transport'         => $transport,
								)
							);

							$wp_customize->add_control(
								$option_id,
								array(
									'label'   => $label,
									'section' => $section_id,
									'type'    => 'text',
								)
							);

							/*
							 Color
							---------------*/
						} elseif ( 'color' == $type ) {

							$wp_customize->add_setting(
								$option_id,
								array(
									'default'           => $default,
									'sanitize_callback' => 'sanitize_hex_color',
									'transport'         => $transport,
								)
							);

							$wp_customize->add_control(
								$slikk_wp_customize_color_control = new WP_Customize_Color_Control(
									$wp_customize,
									$option_id,
									array(
										'label'       => $label,
										'section'     => $section_id,
										'settings'    => $option_id,
										'description' => $description,
									)
								)
							);

							/*
							 Image
							---------------*/
						} elseif ( 'image' == $type ) {

							$wp_customize->add_setting(
								$option_id,
								array(
									'sanitize_callback' => array( $this, 'sanitize_url' ),
								)
							);

							$wp_customize->add_control(
								$slikk_wp_customize_image_control = new WP_Customize_Image_Control(
									$wp_customize,
									$option_id,
									array(
										'label'       => $label,
										'section'     => $section_id,
										'settings'    => $option_id,
										'description' => $description,
									)
								)
							);

						} elseif ( 'media' == $type ) {

							$wp_customize->add_setting(
								$option_id,
								array(
									'sanitize_callback' => array( $this, 'sanitize_int' ),
								)
							);

							$wp_customize->add_control(
								$slikk_wp_customize_image_control = new WP_Customize_Media_Control(
									$wp_customize,
									$option_id,
									array(
										'label'       => $label,
										'section'     => $section_id,
										'settings'    => $option_id,
										'description' => $description,
									)
								)
							);

							/*
							 Select
							---------------*/
						} elseif ( 'select' == $type ) {

							$wp_customize->add_setting(
								$option_id,
								array(
									'default'           => $default,
									'transport'         => $transport,
									'sanitize_callback' => array( $this, 'sanitize_text' ),
								)
							);

							$wp_customize->add_control(
								$option_id,
								array(
									'type'        => 'select',
									'label'       => $label,
									'section'     => $section_id,
									'choices'     => $option['choices'],
									'description' => $description,
								)
							);

							/*
							 Select
							---------------*/
						} elseif ( 'radio' == $type ) {

							$wp_customize->add_setting(
								$option_id,
								array(
									'default'           => $default,
									'transport'         => $transport,
									'sanitize_callback' => array( $this, 'sanitize_text' ),
								)
							);

							$wp_customize->add_control(
								$option_id,
								array(
									'type'    => 'radio',
									'label'   => $label,
									'section' => $section_id,
									'choices' => $option['choices'],
								)
							);

							/*
							 Checkbox
							--------------------*/
						} elseif ( 'checkbox' == $type ) {

							$wp_customize->add_setting(
								$option_id,
								array(
									'default'           => $default,
									'transport'         => $transport,
									'sanitize_callback' => array( $this, 'sanitize_checkbox' ),
								)
							);

							$wp_customize->add_control(
								$option_id,
								array(
									'type'        => 'checkbox',
									'label'       => $label,
									'section'     => $section_id,
									'description' => $description,
								)
							);

							/*
							 Textarea
							--------------------*/
						} elseif ( 'textarea' == $type ) {

							$wp_customize->add_setting(
								$option_id,
								array(
									'sanitize_callback' => array( $this, 'sanitize_text' ),
								)
							);

							$wp_customize->add_control(
								$slikk_customize_textarea_control = new Wolftheme_Customize_Textarea_Control(
									$wp_customize,
									$option_id,
									array(
										'label'    => $label,
										'section'  => $section_id,
										'settings' => $option_id,
									)
								)
							);

						} elseif ( 'radio_images' == $type ) {

							$wp_customize->add_setting(
								$option_id,
								array(
									'transport'         => $transport,
									'sanitize_callback' => array( $this, 'sanitize_text' ),
								)
							);

							$wp_customize->add_control(
								$slikk_customize_textarea_control = new WP_Customize_Radio_Images_Control(
									$wp_customize,
									$option_id,
									array(
										'label'    => $label,
										'section'  => $section_id,
										'settings' => $option_id,
										'choices'  => $option['choices'],
									)
								)
							);

						} elseif ( 'text_helper' == $type ) {

							$wp_customize->add_setting(
								$option_id,
								array(
									'transport'         => $transport,
									'sanitize_callback' => array( $this, 'sanitize_text' ),
								)
							);

							$wp_customize->add_control(
								$slikk_customize_textarea_control = new WP_Customize_Text_Helper_Control(
									$wp_customize,
									$option_id,
									array(
										'label'       => $label,
										'section'     => $section_id,
										'settings'    => $option_id,
										'description' => $description,
									)
								)
							);

						} elseif ( 'group_checkbox' == $type ) {

							$wp_customize->add_setting(
								$option_id,
								array(
									'transport'         => $transport,
									'sanitize_callback' => array( $this, 'sanitize_group_checkbox' ),
								)
							);

							$wp_customize->add_control(
								$slikk_customize_textarea_control = new WP_Customize_Group_Checkbox_Control(
									$wp_customize,
									$option_id,
									array(
										'label'    => $label,
										'section'  => $section_id,
										'settings' => $option_id,
										'choices'  => $option['choices'],
									)
								)
							);
						}

						/*----------------------------- Background option --------------------------------*/

						elseif ( 'background' == $type ) {

							$this->background_setting( $option, $section_id, $wp_customize, false );
						}
					} // end foreach options
				} // end not background
			}
		}

		/**
		 *  Register a background section
		 */
		public function background_setting( $option, $section_id, $wp_customize, $section = true, $priority = 35 ) {

			$label              = isset( $option['label'] ) ? $option['label'] : '';
			$background_id      = true == $section ? $section_id : $option['id'];
			$bg_attachment      = isset( $option['bg_attachment'] ) ? $option['bg_attachment'] : false;
			$font_color         = isset( $option['font_color'] ) ? $option['font_color'] : false;
			$default_font_color = isset( $option['default_font_color'] ) ? $option['default_font_color'] : 'dark';
			$parallax           = isset( $option['parallax'] ) ? $option['parallax'] : false;
			$is_bg_img          = isset( $option['img'] ) ? $option['img'] : true;
			$is_no_bg           = isset( $option['no_bg'] ) ? $option['no_bg'] : false;
			$opacity            = isset( $option['opacity'] ) ? $option['opacity'] : false;
			$transport          = isset( $option['transport'] ) ? $option['transport'] : 'postMessage';

			if ( $section ) {

				$desc = isset( $option['desc'] ) ? $option['desc'] : '';

				$wp_customize->add_section(
					$section_id,
					array(
						'title'       => $label,
						'description' => $desc,
						'priority'    => $priority,
					)
				);
			}

			if ( $font_color ) {

				/*
				 Font Color
				--------------------*/
				$wp_customize->add_setting(
					$background_id . '_font_color',
					array(
						'default'           => '',
						'sanitize_callback' => 'sanitize_hex_color',
					)
				);

				$wp_customize->add_control(
					$slikk_wp_customize_color_control = new WP_Customize_Color_Control(
						$wp_customize,
						$background_id . '_font_color',
						array(
							'label'    => esc_html__( 'Font Color', 'slikk' ),
							'section'  => $section_id,
							'settings' => $background_id . '_font_color',
						)
					)
				);
			} // endif font color option

			if ( $is_no_bg ) {

				/*
				 None
				--------------------*/
				$wp_customize->add_setting(
					$background_id . '_none',
					array(
						'transport'         => 'refresh',
						'sanitize_callback' => array( $this, 'sanitize_text' ),
					)
				);

				$wp_customize->add_control(
					$background_id . '_none',
					array(
						'type'     => 'checkbox',
						'label'    => esc_html__( 'No Background', 'slikk' ),
						'section'  => $section_id,
						'priority' => 1,
					)
				);

			} // endif no bg option

			/*
			 Color
			---------------*/
			$wp_customize->add_setting(
				$background_id . '_color',
				array(
					'default'           => '',
					'sanitize_callback' => 'sanitize_hex_color',
				)
			);

			$wp_customize->add_control(
				$slikk_wp_customize_color_control = new WP_Customize_Color_Control(
					$wp_customize,
					$background_id . '_color',
					array(
						'label'    => esc_html__( 'Background Color', 'slikk' ),
						'section'  => $section_id,
						'settings' => $background_id . '_color',
						'priority' => 2,
					)
				)
			);

			if ( $opacity ) :

				/*
				 Opacity
				---------------*/
				$wp_customize->add_setting(
					$background_id . '_opacity',
					array(
						'default'           => 100,
						'sanitize_callback' => array( $this, 'sanitize_text' ),
					)
				);

				$wp_customize->add_control(
					$background_id . '_opacity',
					array(
						'label'    => esc_html__( 'Background Color Opacity (in percent)', 'slikk' ),
						'section'  => $section_id,
						'type'     => 'text',
						'priority' => 3,
					)
				);
			endif;

			if ( $is_bg_img ) :

				/*
				 Image
				---------------*/
				$wp_customize->add_setting(
					$background_id . '_img',
					array(
						'sanitize_callback' => array( $this, 'sanitize_url' ),
					)
				);

				$wp_customize->add_control(
					$slikk_wp_customize_image_control = new WP_Customize_Image_Control(
						$wp_customize,
						$background_id . '_img',
						array(
							'label'             => esc_html__( 'Background Image', 'slikk' ),
							'section'           => $section_id,
							'settings'          => $background_id . '_img',
							'priority'          => 4,
							'sanitize_callback' => array( $this, 'sanitize_image' ),
						)
					)
				);

				/*
				 Repeat
				---------------*/
				$wp_customize->add_setting(
					$background_id . '_repeat',
					array(
						'default'           => 'repeat',
						'transport'         => $transport,
						'sanitize_callback' => array( $this, 'sanitize_text' ),
					)
				);

				$wp_customize->add_control(
					$background_id . '_repeat',
					array(
						'type'     => 'select',
						'label'    => esc_html__( 'Background Repeat', 'slikk' ),
						'section'  => $section_id,
						'choices'  => array(
							'no-repeat' => 'no-repeat',
							'repeat'    => 'repeat',
							'repeat-x'  => 'repeat-x',
							'repeat-y'  => 'repeat-y',
						),
						'priority' => 5,
					)
				);

				/*
				 Position
				---------------*/
				$wp_customize->add_setting(
					$background_id . '_position',
					array(
						'default'           => 'center top',
						'transport'         => $transport,
						'sanitize_callback' => array( $this, 'sanitize_text' ),
					)
				);

				$wp_customize->add_control(
					$background_id . '_position',
					array(
						'type'     => 'select',
						'label'    => esc_html__( 'Background Position', 'slikk' ),
						'section'  => $section_id,
						'choices'  => array(
							'center center' => 'center center',
							'center top'    => 'center top',
							'left top'      => 'left top',
							'right top'     => 'right top',
							'center bottom' => 'center bottom',
							'left bottom'   => 'left bottom',
							'right bottom'  => 'right bottom',
							'left center'   => 'left center',
							'right center'  => 'right center',
						),
						'priority' => 6,
					)
				);

				if ( $bg_attachment ) {
					/*
					 Attachment
					----------------------*/
					$wp_customize->add_setting(
						$background_id . '_attachment',
						array(
							'default'           => 'scroll',
							'transport'         => $transport,
							'sanitize_callback' => array( $this, 'sanitize_text' ),
						)
					);
				}

				$wp_customize->add_control(
					$background_id . '_attachment',
					array(
						'type'     => 'select',
						'label'    => esc_html__( 'Background Attachment', 'slikk' ),
						'section'  => $section_id,
						'choices'  => array(
							'scroll' => 'scroll',
							'fixed'  => 'fixed',
						),
						'priority' => 7,
					)
				);

				/*
				 Size
				---------------*/
				$wp_customize->add_setting(
					$background_id . '_size',
					array(
						'default'           => 'cover',
						'transport'         => $transport,
						'sanitize_callback' => array( $this, 'sanitize_text' ),
					)
				);

				$wp_customize->add_control(
					$background_id . '_size',
					array(
						'type'     => 'select',
						'label'    => esc_html__( 'Background Size', 'slikk' ),
						'section'  => $section_id,
						'choices'  => array(
							'cover'     => esc_html__( 'Cover', 'slikk' ),
							'contain'   => esc_html__( 'Contain', 'slikk' ),
							'100% auto' => esc_html__( '100% width', 'slikk' ),
							'auto 100%' => esc_html__( '100% height', 'slikk' ),
							'inherit'   => esc_html__( 'Inherit', 'slikk' ),
						),
						'priority' => 8,
					)
				);

				if ( $parallax ) {

					/*
					 Parallax
					--------------------*/
					$wp_customize->add_setting(
						$background_id . '_parallax',
						array(
							'sanitize_callback' => array( $this, 'sanitize_text' ),
						)
					);

					$wp_customize->add_control(
						$background_id . '_parallax',
						array(
							'type'     => 'checkbox',
							'label'    => esc_html__( 'Parallax', 'slikk' ),
							'section'  => $section_id,
							'priority' => 9,
						)
					);

				}

			endif; // end if bg image

		}

		/**
		 *  Sanitize group checkbox
		 *
		 * @param string $input
		 * @return int
		 */
		public function sanitize_group_checkbox( $input ) {

			return slikk_clean_spaces( $input );
		}

		/**
		 *  Sanitize integer
		 *
		 * @param string $input
		 * @return int
		 */
		public function sanitize_int( $input ) {

			return intval( $input );
		}

		/**
		 *  Sanitize checkbox
		 *
		 * @param string $input
		 * @return int
		 */
		public function sanitize_checkbox( $input ) {

			return esc_attr( $input );
		}

		/**
		 *  Sanitize text
		 *
		 * @param string $input
		 * @return int
		 */
		public function sanitize_text( $input ) {

			return sanitize_text_field( $input );
		}

		/**
		 *  Sanitize image
		 *
		 * @param string $input
		 * @return int
		 */
		public function sanitize_url( $input ) {

			return esc_url( $input );
		}
	} // end class
}

if ( class_exists( 'WP_Customize_Control' ) ) :
	class WP_Customize_Group_Checkbox_Control extends WP_Customize_Control {

		public $type = 'group_checkbox';

		/**
		 * Enqueue scripts/styles.
		 */
		public function enqueue() {

			$version = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? time() : slikk_get_theme_version();

			wp_enqueue_script( 'slikk-customize-controls', get_template_directory_uri() . '/inc/customizer/js/customize-controls.js', array( 'jquery' ), $version, true );
		}

		/**
		 * Render content
		 */
		public function render_content() {

			$multi_values = slikk_list_to_array( $this->value() );
			?>
			<span class="customize-control-title"><?php echo esc_attr( $this->label ); ?></span>
				<ul>
				<?php foreach ( $this->choices as $choice => $label ) : ?>
					<li>
						<label>
							<input type="checkbox" value="<?php echo esc_attr( $choice ); ?>" <?php checked( in_array( $choice, $multi_values, true ) ); ?> />
						<?php echo esc_attr( $label ); ?>
						</label>
					</li>
				<?php endforeach; ?>
				</ul>
				<input type="hidden" <?php $this->link(); ?> value="<?php echo esc_attr( $this->value() ); ?>">
			<?php
		}
	}

	class WP_Customize_Radio_Images_Control extends WP_Customize_Control { // phpcs:ignore

		/**
		 * Input type
		 *
		 * @var string
		 */
		public $type = 'radio_images';

		/**
		 * Render content
		 */
		public function render_content() {
			$cols = count( $this->choices );

			if ( 6 == $cols ) {

				$cols = 3;

			} elseif ( 7 == $cols ) {
				$cols = 3;

			} elseif ( 8 == $cols ) {
				$cols = 3;

			} elseif ( 9 == $cols ) {
				$cols = 3;
			}

			$itemwidth = $cols > 0 ? round( 100 / $cols, 2, PHP_ROUND_HALF_DOWN ) - 1 : 100;
			?>
			<span class="customize-control-title"><?php echo esc_attr( $this->label ); ?></span>
			<?php foreach ( $this->choices as $choice ) : ?>
				<label class="slikk-radio-image-label" style="width:<?php echo absint( $itemwidth ); ?>%;">
					<input data-customize-setting-link="<?php echo esc_attr( $this->id ); ?>" type="radio" name="_customize-radio-<?php echo esc_attr( $this->id ); ?>" value="<?php echo esc_attr( $choice['key'] ); ?>">
					<img class="slikk-radio-image" src="<?php echo esc_url( $choice['image'] ); ?>">
					<span class="slikk-radio-image-text"><?php echo esc_attr( $choice['text'] ); ?></span>
				</label>
			<?php endforeach; ?>
			<?php
		}
	}

	class WP_Customize_Text_Helper_Control extends WP_Customize_Control { // phpcs:ignore

		/**
		 * Input type
		 *
		 * @var string
		 */
		public $type = 'text_helper';

		/**
		 * Render content
		 */
		public function render_content() {
			?>
			<span class="customize-control-title"><?php echo esc_attr( $this->label ); ?></span>
			<span class="description customize-control-description"><?php echo slikk_kses( $this->description ); ?> </span>
			<?php
		}
	}
endif;
