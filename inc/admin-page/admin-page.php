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
		add_action( 'admin_enqueue_scripts', array( $this, 'load_assets' ) );
		add_action( 'wp_ajax_nopriv_wpc_mbai_get_plugins_list', array( $this, 'get_list_ajax_callback' ) );
		add_action( 'wp_ajax_wpc_mbai_get_plugins_list', array( $this, 'get_list_ajax_callback' ) );
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
				'menu_icon'      => 'dashicons-image-flip-horizontal',
				'top_level_menu' => true,
			)
		);

		$obj->set_quick_links(
			array(
				array(
					'text' => 'View Details',
					'url'  => 'https://wpconcern.com/plugins/majestic-before-after-image/',
					'type' => 'primary',
				),
				array(
					'text' => 'View Demo',
					'url'  => 'https://wpconcern.net/demo/majestic-before-after-image/',
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
						'button_url'  => 'https://wpconcern.net/demo/majestic-before-after-image/',
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
						'button_url'  => 'https://wpconcern.com/documentation/majestic-before-after-image/',
						'button_type' => 'secondary',
						'is_new_tab'  => true,
					),
				),
			)
		);

		$obj->add_tab(
			array(
				'id'              => 'features',
				'title'           => 'Features',
				'type'            => 'custom',
				'render_callback' => array( $this, 'render_features_list' ),

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
	 * Render features.
	 *
	 * @since 1.0.2
	 */
	public function render_features_list() {
		echo '<ul>
				<li>Horizontal / Vertical Orientation</li>
				<li>Handle movement control - Swipe or Hover</li>
				<li>Customizable before and after labels</li>
				<li>Labels visibility - On Hover, Always or Never</li>
				<li>Enable / disable overlay</li>
				<li>Default handle offset position</li>
				<li>Multiple handle styles</li>
				<li>Handle types - Arrows or Text</li>
				<li>Image size option</li>
				<li>Typography and color options</li>
			</ul>';
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
				'title'   => 'Our Plugins',
				'content' => '<div class="wpc-plugins-list"></div>',
			),
			$welcome_object
		);
	}

	/**
	 * Load admin page assets.
	 *
	 * @since 1.0.0
	 *
	 * @param string $hook Hook name.
	 */
	public function load_assets( $hook ) {
		if ( 'toplevel_page_majestic-before-after-image' !== $hook ) {
			return;
		}

		wp_enqueue_script( 'mbai-plugins-list', MBAI_URL . '/assets/js/plugins-list.js', array( 'jquery' ), MBAI_VERSION, true );
	}

	/**
	 * AJAX callback for plugins list.
	 *
	 * @since 1.0.0
	 */
	public function get_list_ajax_callback() {
		$output = array();

		$posts = $this->get_plugins_list();

		if ( ! empty( $posts ) ) {
			$output = $posts;
		}

		if ( ! empty( $output ) ) {
			wp_send_json_success( $output, 200 );
		} else {
			wp_send_json_error( $output, 404 );
		}
	}

	/**
	 * Return plugins list.
	 *
	 * @since 1.0.0
	 *
	 * @return array Plugins list array.
	 */
	private function get_plugins_list() {
		$transient_key = 'wpc_mbai_plugins_list';

		$transient_period = 7 * DAY_IN_SECONDS;

		$output = get_transient( $transient_key );

		if ( false === $output ) {
			$output = array();

			$request = wp_safe_remote_get( 'https://wpconcern.com/wpc-api/plugins-list' );

			if ( is_wp_error( $request ) ) {
					return $output;
			}

			$body = wp_remote_retrieve_body( $request );
			$json = json_decode( $body, true );

			if ( isset( $json['plugins'] ) && ! empty( $json['plugins'] ) ) {
				$output = $json['plugins'];
			}

			set_transient( $transient_key, $output, $transient_period );
		}

		return $output;
	}
}

new MBAI_Admin_Page();
