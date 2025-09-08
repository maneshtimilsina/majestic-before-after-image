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
					'text' => 'Plugin Homepage',
					'url'  => 'https://maneshtimilsina.com/plugins/majestic-before-after-image/',
					'type' => 'primary',
				),
				array(
					'text' => 'View Demo',
					'url'  => 'https://demo.maneshtimilsina.com/majestic-before-after-image/',
					'type' => 'secondary',
				),
				array(
					'text' => 'Get Support',
					'url'  => 'https://wordpress.org/support/plugin/majestic-before-after-image/#new-post',
					'type' => 'secondary',
				),
				array(
					'text' => 'Buy Me a Coffee',
					'url'  => 'https://ko-fi.com/maneshtimilsina',
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
				'title' => '',
				'type'  => 'grid',
				'items' => array(
					array(
						'title'       => 'Documentation',
						'icon'        => 'dashicons dashicons-admin-page',
						'description' => 'For setup and configuration, please refer to the documentation.',
						'button_text' => 'View Documentation',
						'button_url'  => 'https://doc.maneshtimilsina.com/majestic-before-after-image/',
						'button_type' => 'secondary',
						'is_new_tab'  => true,
					),
					array(
						'title'        => 'Leave a Review',
						'icon'         => 'dashicons dashicons-star-filled',
						'description'  => 'Enjoying the plugin? Please leave a review!',
						'button_text'  => 'Submit Review',
						'button_url'   => 'https://wordpress.org/support/plugin/majestic-before-after-image/reviews/#new-post',
						'button_class' => 'button',
						'button_type'  => 'secondary',
						'is_new_tab'   => true,
					),
				),
			)
		);



		$obj->run();
	}
}

new MBAI_Admin_Page();
