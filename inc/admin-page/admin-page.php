<?php
/**
 * Admin page
 *
 * @package MBAI
 */

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
		add_action( 'admin_menu', array( $this, 'add_admin_page' ) );
		add_action( 'admin_enqueue_scripts', array( $this, 'load_assets' ) );
	}

	/**
	 * Register admin page.
	 *
	 * @since 1.0.0
	 */
	public function add_admin_page() {
		add_menu_page( esc_html__( 'Majestic Before After Image', 'majestic-before-after-image' ), esc_html__( 'Majestic Before After Image', 'majestic-before-after-image' ), 'manage_options', 'majestic-before-after-image', array( $this, 'render_admin_page' ), 'dashicons-image-flip-horizontal' );
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

		wp_enqueue_style( 'mbai-admin-page', MBAI_URL . '/assets/css/admin-page.css', array(), MBAI_VERSION );
		wp_enqueue_script( 'mbai-admin-page', MBAI_URL . '/assets/js/admin-page.js', array( 'jquery' ), MBAI_VERSION, true );

		$localized_array = array(
			'storage_key' => 'mbai-activetab',
		);

		wp_localize_script( 'mbai-admin-page', 'mbaiAdmin', $localized_array );
	}


	/**
	 * Render admin page.
	 *
	 * @since 1.0.0
	 */
	public function render_admin_page() {
		if ( ! current_user_can( 'manage_options' ) ) {
			return;
		}
		?>

		<div class="wrap wpc-wrap" id="wpc-wrapper">
			<div class="wpc-header">
				<h1><?php echo esc_html( get_admin_page_title() ); ?></h1>

				<?php /* translators: %s: version. */ ?>
				<p class="about-text"><?php echo sprintf( esc_html__( 'Version: %s', 'majestic-before-after-image' ), MBAI_VERSION ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></p>
			</div>

			<p>
				<a href="https://wordpress.org/support/plugin/majestic-before-after-image/#new-post" class="button button-primary" target="_blank"><?php echo esc_html__( 'Get Support', 'majestic-before-after-image' ); ?></a>
				<a href="https://wordpress.org/support/plugin/majestic-before-after-image/reviews/#new-post" class="button" target="_blank"><?php echo esc_html__( 'Leave a Review', 'majestic-before-after-image' ); ?></a>
				<a href="https://wpconcern.com/documentation/majestic-before-after-image/" class="button" target="_blank"><?php echo esc_html__( 'Documentation', 'majestic-before-after-image' ); ?></a>
			</p>

			<div class="wpc-main-content">
				<div class="wpc-content-left">

					<nav class="nav-tab-wrapper">
						<a href="#tab-welcome" class="nav-tab nav-tab-active">Welcome</a>
						<a href="#tab-features" class="nav-tab">Features</a>
					</nav>

					<div class="wpc-tab-contents">
						<div class="wpc-tab-content" id="tab-welcome">
							<div class="wpc-grid">
								<div class="wpc-card">
									<h3><span class="dashicons dashicons-image-flip-horizontal"></span>Elementor Widget</h3>
									<p>Edit page with Elementor, drag and drop the 'Majestic Before After Image' element to the section you want. And start customizing the widget.</p>
								</div><!-- .wpc-card -->

								<div class="wpc-card">

									<h3><span class="dashicons dashicons-editor-help"></span>Get Support</h3>
									<p>Please visit the support forum if you have any queries or support request.</p>
									<p><a href="https://wordpress.org/support/plugin/majestic-before-after-image/#new-post" class="button button-secondary" target="_blank">Visit Support</a></p>

								</div><!-- .wpc-card -->

								<div class="wpc-card">

									<h3><span class="dashicons dashicons-admin-page"></span>Plugin Documentation</h3>
									<p>Please check the plugin documentation for detailed information on how to setup and customize it.</p>
									<p><a href="https://wpconcern.com/documentation/majestic-before-after-image/" class="button button-secondary" target="_blank">Documentation</a></p>

								</div><!-- .wpc-card -->

							</div><!-- .wpc-grid -->
						</div><!-- .wpc-tab-content -->

						<div class="wpc-tab-content" id="tab-features">

							<ul class="features-list">
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
							</ul>

						</div><!-- .wpc-tab-content -->


					</div><!-- .wpc-tab-contents -->

				</div><!-- .wpc-content-left -->

				<div class="wpc-content-right">

					<div class="wpc-box">
						<h3><span>Our Plugins</span></h3>
						<div class="wpc-box-content">
							<ol>
								<li><a href="https://wpconcern.com/plugins/woocommerce-product-tabs/" target="_blank">WooCommerce Product Tabs</a></li>
								<li><a href="https://wpconcern.com/plugins/post-grid-elementor-addon/" target="_blank">Post Grid Elementor Addon</a></li>
								<li><a href="https://wpconcern.com/plugins/advanced-google-recaptcha/" target="_blank">Advanced Google reCAPTCHA</a></li>
								<li><a href="https://wordpress.org/plugins/nifty-coming-soon-and-under-construction-page/" target="_blank">Coming Soon & Maintenance Mode Page</a></li>
								<li><a href="https://wordpress.org/plugins/admin-customizer/" target="_blank">Admin Customizer</a></li>
								<li><a href="https://wordpress.org/plugins/prime-addons-for-elementor/" target="_blank">Prime Addons for Elementor</a></li>
							</ol>
						</div> <!-- .wpc-box-content -->
					</div><!-- .wpc-box -->

				</div><!-- .wpc-content-right -->

			</div><!-- .wpc-main-content -->

		</div>
		<?php
	}
}

new MBAI_Admin_Page();
