<?php
/**
 * Elementor init
 *
 * @package MBAI
 */

/**
 * MBAI Elementor class.
 *
 * @since 1.0.0
 */
class MBAI_Elementor {
	/**
	 * Instance.
	 *
	 * @since 1.0.0
	 * @var MBAI_Elementor
	 */
	private static $_instance = null;

	/**
	 * Return instance.
	 *
	 * @since 1.0.0
	 *
	 * @return Plugin An instance of MBAI_Elementor.
	 */
	public static function instance() {
		if ( is_null( self::$_instance ) ) {
			self::$_instance = new self();
		}
		return self::$_instance;
	}

	/**
	 * Constructor.
	 *
	 * @since 1.0.0
	 */
	public function __construct() {

		// Register widgets
		add_action( 'elementor/widgets/register', array( $this, 'register_widgets' ) );

		add_action( 'elementor/elements/categories_registered', array( $this, 'register_widget_category' ) );
	}

	public function register_widget_category( $elements_manager ) {
		$elements_manager->add_category(
			'mbai-widgets',
			array(
				'title' => esc_html__( 'MBAI Elements', 'majestic-before-after-image' ),
				'icon'  => 'fa fa-plug',
			)
		);
	}

	/**
	 * Include Widgets files
	 *
	 * Load widgets files
	 *
	 * @since 1.2.0
	 * @access private
	 */
	private function include_widgets_files() {
		require_once MBAI_DIR . '/inc/elementor/widget.php';
	}

	/**
	 * Register Widgets.
	 *
	 * Register new Elementor widgets.
	 *
	 * @since 1.2.0
	 * @access public
	 */
	public function register_widgets() {
		$this->include_widgets_files();

		\Elementor\Plugin::instance()->widgets_manager->register( new MBAI_Elementor_Widget() );
	}

}

MBAI_Elementor::instance();
