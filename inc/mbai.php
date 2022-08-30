<?php
/**
 * Init
 *
 * @package MBAI
 */

final class MBAI {

	/**
	 * Constructor
	 *
	 * @since 1.0.0
	 */
	public function __construct() {

		// Load translation.
		add_action( 'init', array( $this, 'i18n' ) );

		// Init Plugin
		add_action( 'plugins_loaded', array( $this, 'init_elementor' ) );
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

		printf( '<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message );
	}

}

new MBAI();