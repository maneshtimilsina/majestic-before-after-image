<?php
/**
 * Admin page
 *
 * @package MBAI
 */

use Nilambar\Welcome\Welcome;

/**
 * MBAI admin page class.
 *
 * @since 1.0.0
 */
class MBAI_Admin_Page {

	/**
	 * Constructor.
	 *
	 * @since 1.0.0
	 */
	public function __construct() {
		add_action( 'wp_welcome_init', array( $this, 'add_admin_page' ) );
	}

	/**
	 * Register admin page.
	 *
	 * @since 1.0.0
	 */
	public function add_admin_page() {
		$obj = new Welcome( 'plugin', 'majestic-before-after-image' );

		$obj->set_page(
			array(
				'page_title'     => esc_html__( 'Majestic Before After Image', 'majestic-before-after-image' ),
				/* translators: %s: version. */
				'page_subtitle'  => sprintf( esc_html__( 'Version: %s', 'majestic-before-after-image' ), MBAI_VERSION ),
				'menu_title'     => esc_html__( 'Majestic Before After Image', 'majestic-before-after-image' ),
				'menu_slug'      => 'majestic-before-after-image',
				'capability'     => 'manage_options',
				'top_level_menu' => false,
			)
		);

		$obj->set_quick_links(
			array(
				array(
					'text' => 'View Details',
					'url'  => 'https://maneshtimilsina.com/plugins/majestic-before-after-image/',
					'type' => 'primary',
				),
				array(
					'text' => 'View Demo',
					'url'  => 'https://mbai.wpmanesh.com/',
					'type' => 'secondary',
				),
				array(
					'text' => 'Get Support',
					'url'  => 'https://wordpress.org/support/plugin/majestic-before-after-image/#new-post',
					'type' => 'secondary',
				),
			)
		);

		$obj->set_admin_notice(
			array(
				'screens' => array( 'dashboard' ),
			)
		);

		$obj->add_tab(
			array(
				'id'    => 'welcome',
				'title' => 'Welcome',
				'type'  => 'grid',
				'items' => array(
					array(
						'title'       => 'Elementor Widget',
						'icon'        => 'dashicons dashicons-image-flip-horizontal',
						'description' => "Edit page with Elementor, drag and drop the 'Majestic Before After Image' element to the section you want. And start customizing the widget.",
					),
					array(
						'title'       => 'View Demo',
						'icon'        => 'dashicons dashicons-desktop',
						'description' => 'You can check out the plugin demo for reference to find out what you can achieve using the plugin and how it can be customized.',
						'button_text' => 'Visit Demo',
						'button_url'  => 'https://mbai.wpmanesh.com/',
						'button_type' => 'secondary',
						'is_new_tab'  => true,
					),
					array(
						'title'       => 'Get Support',
						'icon'        => 'dashicons dashicons-editor-help',
						'description' => 'Got theme support question or found bug or got some feedbacks? Please visit support forum in the WordPress.org directory.',
						'button_text' => 'Visit Support',
						'button_url'  => 'https://wordpress.org/support/plugin/majestic-before-after-image/#new-post',
						'button_type' => 'secondary',
						'is_new_tab'  => true,
					),
					array(
						'title'       => 'Documentation',
						'icon'        => 'dashicons dashicons-admin-page',
						'description' => 'Please check the plugin documentation for detailed information on how to setup and customize it.',
						'button_text' => 'View Documentation',
						'button_url'  => 'https://doc.wpmanesh.com/majestic-before-after-image/',
						'button_type' => 'secondary',
						'is_new_tab'  => true,
					),
				),
			)
		);

		$obj->set_sidebar(
			array(
				'render_callback' => array( $this, 'render_welcome_page_sidebar' ),
			)
		);

		$obj->run();
	}

	/**
	 * Render welcome page sidebar.
	 *
	 * @since 1.0.2
	 *
	 * @param Welcome $welcome_object Instance of Welcome class.
	 */
	public function render_welcome_page_sidebar( $welcome_object ) {
		$welcome_object->render_sidebar_box(
			array(
				'title'        => 'Leave a Review',
				'content'      => $welcome_object->get_stars() . sprintf( 'Are you enjoying %1$s? We would appreciate a review.', $welcome_object->get_name() ),
				'button_text'  => 'Submit Review',
				'button_url'   => 'https://wordpress.org/support/plugin/majestic-before-after-image/reviews/#new-post',
				'button_class' => 'button',
			),
			$welcome_object
		);

		$welcome_object->render_sidebar_box(
			array(
				'title'        => 'Buy Me A Coffee',
				'content'      => 'Would you like to support the advancement of this plugin?',
				'button_text'  => 'Buy Me A Coffee',
				'button_url'   => 'https://ko-fi.com/maneshtimilsina',
				'button_class' => 'button',
			),
			$welcome_object
		);
	}
}

new MBAI_Admin_Page();
