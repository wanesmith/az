<?php
/**
 * Slikk sidebars
 *
 * Register default sidebar for the theme with the slikk_sidebars_init function
 * This function can be overwritten in a child theme
 *
 * @package WordPress
 * @subpackage Slikk
 * @since 1.0.0
 * @version 1.4.2
 */

defined( 'ABSPATH' ) || exit;

/**
 * Register blog and page sidebar and footer widget area.
 */
function slikk_sidebars_init() {

	/* Blog Sidebar */
	register_sidebar(
		array(
			'name'          => esc_html__( 'Blog Sidebar', 'slikk' ),
			'id'            => 'sidebar-main',
			'description'   => esc_html__( 'Add widgets here to appear in your blog sidebar.', 'slikk' ),
			'before_widget' => '<aside id="%1$s" class="widget %2$s"><div class="widget-content">',
			'after_widget'  => '</div></aside>',
			'before_title'  => '<h3 class="widget-title">',
			'after_title'   => '</h3>',
		)
	);

	if ( class_exists( 'Wolf_Visual_Composer' ) && defined( 'WPB_VC_VERSION' ) ) {
		/* Page Sidebar */
		register_sidebar(
			array(
				'name'          => esc_html__( 'Page Sidebar', 'slikk' ),
				'id'            => 'sidebar-page',
				'description'   => esc_html__( 'Add widgets here to appear in your page sidebar.', 'slikk' ),
				'before_widget' => '<aside id="%1$s" class="clearfix widget %2$s"><div class="widget-content">',
				'after_widget'  => '</div></aside>',
				'before_title'  => '<h3 class="widget-title">',
				'after_title'   => '</h3>',
			)
		);
	}

	if ( apply_filters( 'slikk_allow_side_panel', true ) ) {
		/* Side Panel Sidebar */
		register_sidebar(
			array(
				'name'          => esc_html__( 'Side Panel Sidebar', 'slikk' ),
				'id'            => 'sidebar-side-panel',
				'description'   => esc_html__( 'Add widgets here to appear in your side panel if enabled.', 'slikk' ),
				'before_widget' => '<aside id="%1$s" class="widget %2$s"><div class="widget-content">',
				'after_widget'  => '</div></aside>',
				'before_title'  => '<h3 class="widget-title">',
				'after_title'   => '</h3>',
			)
		);
	}

	/* Footer Sidebar */
	register_sidebar(
		array(
			'name'          => esc_html__( 'Footer Widget Area', 'slikk' ),
			'id'            => 'sidebar-footer',
			'description'   => esc_html__( 'Add widgets here to appear in your footer.', 'slikk' ),
			'before_widget' => '<aside id="%1$s" class="widget %2$s"><div class="widget-content">',
			'after_widget'  => '</div></aside>',
			'before_title'  => '<h3 class="widget-title">',
			'after_title'   => '</h3>',
		)
	);

	/* Discography sidebar */
	if ( class_exists( 'Wolf_Discography' ) ) {
		register_sidebar(
			array(
				'name'          => esc_html__( 'Discography Sidebar', 'slikk' ),
				'id'            => 'sidebar-discography',
				'description'   => esc_html__( 'Appears on the discography pages if a layout with sidebar is set', 'slikk' ),
				'before_widget' => '<aside id="%1$s" class="widget %2$s"><div class="widget-content">',
				'after_widget'  => '</div></aside>',
				'before_title'  => '<h3 class="widget-title">',
				'after_title'   => '</h3>',
			)
		);
	}

	/* Videos sidebar */
	if ( class_exists( 'Wolf_Videos' ) ) {
		register_sidebar(
			array(
				'name'          => esc_html__( 'Videos Sidebar', 'slikk' ),
				'id'            => 'sidebar-videos',
				'description'   => esc_html__( 'Appears on the videos pages if a layout with sidebar is set', 'slikk' ),
				'before_widget' => '<aside id="%1$s" class="widget %2$s"><div class="widget-content">',
				'after_widget'  => '</div></aside>',
				'before_title'  => '<h3 class="widget-title">',
				'after_title'   => '</h3>',
			)
		);
	}

	/* Albums sidebar */
	if ( class_exists( 'Wolf_Albums' ) ) {
		register_sidebar(
			array(
				'name'          => esc_html__( 'Albums Sidebar', 'slikk' ),
				'id'            => 'sidebar-albums',
				'description'   => esc_html__( 'Appears on the albums pages if a layout with sidebar is set', 'slikk' ),
				'before_widget' => '<aside id="%1$s" class="widget %2$s"><div class="widget-content">',
				'after_widget'  => '</div></aside>',
				'before_title'  => '<h3 class="widget-title">',
				'after_title'   => '</h3>',
			)
		);
	}

	/* Photos sidebar */
	if ( class_exists( 'Wolf_Photos' ) ) {
		register_sidebar(
			array(
				'name'          => esc_html__( 'Photo Sidebar', 'slikk' ),
				'id'            => 'sidebar-attachment',
				'description'   => esc_html__( 'Appears before the image details on single photo pages', 'slikk' ),
				'before_widget' => '<aside id="%1$s" class="widget %2$s"><div class="widget-content">',
				'after_widget'  => '</div></aside>',
				'before_title'  => '<h3 class="widget-title">',
				'after_title'   => '</h3>',
			)
		);

		register_sidebar(
			array(
				'name'          => esc_html__( 'Photo Sidebar Secondary', 'slikk' ),
				'id'            => 'sidebar-attachment-secondary',
				'description'   => esc_html__( 'Appears after the image details on single photo pages', 'slikk' ),
				'before_widget' => '<aside id="%1$s" class="widget %2$s"><div class="widget-content">',
				'after_widget'  => '</div></aside>',
				'before_title'  => '<h3 class="widget-title">',
				'after_title'   => '</h3>',
			)
		);
	}

	/* Events sidebar */
	if ( class_exists( 'Wolf_Events' ) ) {
		register_sidebar(
			array(
				'name'          => esc_html__( 'Events Sidebar', 'slikk' ),
				'id'            => 'sidebar-events',
				'description'   => esc_html__( 'Appears on the events pages if a layout with sidebar is set', 'slikk' ),
				'before_widget' => '<aside id="%1$s" class="widget %2$s"><div class="widget-content">',
				'after_widget'  => '</div></aside>',
				'before_title'  => '<h3 class="widget-title">',
				'after_title'   => '</h3>',
			)
		);
	}

	/* MP Timetable sidebar */
	if ( class_exists( 'Mp_Time_Table' ) ) {
		register_sidebar(
			array(
				'name'          => esc_html__( 'Timetable Event Sidebar', 'slikk' ),
				'id'            => 'sidebar-mp-event',
				'description'   => esc_html__( 'Appears on the single event pages if a layout with sidebar is set', 'slikk' ),
				'before_widget' => '<aside id="%1$s" class="widget %2$s"><div class="widget-content">',
				'after_widget'  => '</div></aside>',
				'before_title'  => '<h3 class="widget-title">',
				'after_title'   => '</h3>',
			)
		);

		register_sidebar(
			array(
				'name'          => esc_html__( 'Timetable Column Sidebar', 'slikk' ),
				'id'            => 'sidebar-mp-column',
				'description'   => esc_html__( 'Appears on the single column pages if a layout with sidebar is set', 'slikk' ),
				'before_widget' => '<aside id="%1$s" class="widget %2$s"><div class="widget-content">',
				'after_widget'  => '</div></aside>',
				'before_title'  => '<h3 class="widget-title">',
				'after_title'   => '</h3>',
			)
		);
	}

	/* Artists sidebar */
	if ( class_exists( 'Wolf_Artists' ) ) {
		register_sidebar(
			array(
				'name'          => esc_html__( 'Artists Sidebar', 'slikk' ),
				'id'            => 'sidebar-artists',
				'description'   => esc_html__( 'Appears on the artists pages if a layout with sidebar is set', 'slikk' ),
				'before_widget' => '<aside id="%1$s" class="widget %2$s"><div class="widget-content">',
				'after_widget'  => '</div></aside>',
				'before_title'  => '<h3 class="widget-title">',
				'after_title'   => '</h3>',
			)
		);
	}

	/* Woocommerce sidebar */
	if ( class_exists( 'Woocommerce' ) ) {
		register_sidebar(
			array(
				'name'          => esc_html__( 'Shop Sidebar', 'slikk' ),
				'id'            => 'sidebar-shop',
				'description'   => esc_html__( 'Add widgets here to appear in your shop page if a sidebar is visible.', 'slikk' ),
				'before_widget' => '<aside id="%1$s" class="widget %2$s"><div class="widget-content">',
				'after_widget'  => '</div></aside>',
				'before_title'  => '<h3 class="widget-title">',
				'after_title'   => '</h3>',
			)
		);
	}
}
add_action( 'widgets_init', 'slikk_sidebars_init' );
