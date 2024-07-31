<?php
/**
 * Init
 *
 * @package MBAI
 */

use Nilambar\AdminNotice\Notice;

/**
 * Main MBAI class.
 *
 * @since 1.0.0
 */
final class MBAI {

	/**
	 * Constructor.
	 *
	 * @since 1.0.0
	 */
	public function __construct() {
		// Load translation.
		add_action( 'init', array( $this, 'i18n' ) );

		// Init plugin.
		add_action( 'plugins_loaded', array( $this, 'init_elementor' ) );

		// Admin notice.
		add_action( 'admin_init', array( $this, 'nifty_cs_admin_notice' ) );

		// Update action links in plugins page.
		add_filter( 'plugin_action_links_' . MBAI_BASE_FILENAME, array( $this, 'customize_plugin_action_links' ) );
	}

	/**
	 * Load textdomain.
	 *
	 * @since 1.0.0
	 */
	public function i18n() {
		load_plugin_textdomain( 'majestic-before-after-image' );
	}

	/**
	 * Initialize the plugin.
	 *
	 * @since 1.0.0
	 */
	public function init_elementor() {
		// Load admin page.
		require_once MBAI_DIR . '/inc/admin-page/admin-page.php';

		// Check if Elementor installed and activated.
		if ( ! did_action( 'elementor/loaded' ) ) {
			add_action( 'admin_notices', array( $this, 'admin_notice_missing_elementor' ) );
			return;
		}

		// Init Elementor.
		require_once MBAI_DIR . '/inc/elementor/elementor.php';
	}

	/**
	 * Missing Elementor admin notice.
	 *
	 * @since 1.0.0
	 */
	public function admin_notice_missing_elementor() {
		if ( isset( $_GET['activate'] ) ) {
			unset( $_GET['activate'] );
		}

		$message = sprintf(
			/* translators: 1: Plugin name 2: Elementor */
			esc_html__( '"%1$s" requires "%2$s" to be installed and activated.', 'majestic-before-after-image' ),
			'<strong>' . esc_html__( 'Majestic Before After Image', 'majestic-before-after-image' ) . '</strong>',
			'<strong>' . esc_html__( 'Elementor', 'majestic-before-after-image' ) . '</strong>'
		);

		printf( '<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	}

	/**
	 * Customize plugin action links.
	 *
	 * @since 1.0.0
	 *
	 * @param array $actions Action links.
	 * @return array Modified action links.
	 */
	public function customize_plugin_action_links( $actions ) {
		$url = add_query_arg(
			array(
				'page' => 'majestic-before-after-image',
			),
			admin_url( 'options-general.php' )
		);

		$actions = array_merge(
			array(
				'welcome' => '<a href="' . esc_url( $url ) . '">' . esc_html__( 'Welcome', 'majestic-before-after-image' ) . '</a>',
			),
			$actions
		);

		return $actions;
	}

	/**
	 * Add admin notice.
	 *
	 * @since 1.0.0
	 */
	public function nifty_cs_admin_notice() {
		Notice::init(
			array(
				'slug' => MBAI_SLUG,
				'name' => esc_html__( 'Majestic Before After Image', 'majestic-before-after-image' ),
			)
		);
	}
}

new MBAI();
