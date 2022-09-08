<?php
/**
 * Plugin Name: Majestic Before After Image
 * Plugin URI: https://wpconcern.com/plugins/majestic-before-after-image/
 * Description: Majestic Before After Image is an Elementor addon to show the comparison of two images with a draggable handle.
 * Version: 1.0.1
 * Author: WP Concern
 * Author URI: https://wpconcern.com/
 * Text Domain: majestic-before-after-image
 * License: GPLv3
 * License URI: https://www.gnu.org/licenses/gpl-3.0.html
 *
 * @package MBAI
 */

defined( 'ABSPATH' ) || exit;

define( 'MBAI_VERSION', '1.0.1' );
define( 'MBAI_SLUG', 'majestic-before-after-image' );
define( 'MBAI_BASE_NAME', basename( dirname( __FILE__ ) ) );
define( 'MBAI_BASE_FILEPATH', __FILE__ );
define( 'MBAI_BASE_FILENAME', plugin_basename( __FILE__ ) );
define( 'MBAI_DIR', rtrim( plugin_dir_path( __FILE__ ), '/' ) );
define( 'MBAI_URL', rtrim( plugin_dir_url( __FILE__ ), '/' ) );

// Init autoload.
if ( file_exists( MBAI_DIR . '/vendor/autoload.php' ) ) {
	require_once MBAI_DIR . '/vendor/autoload.php';
}

// Init plugin.
require_once MBAI_DIR . '/inc/mbai.php';
