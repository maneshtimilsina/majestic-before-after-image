<?php
/**
 * Plugin Name: Majestic Before After Image
 * Plugin URI: https://maneshtimilsina.com/plugins/majestic-before-after-image/
 * Description: Majestic Before After Image is an Elementor addon to show the comparison of two images with a draggable handle.
 * Version: 2.0.0
 * Requires PHP: 7.4
 * Requires at least: 6.0
 * Author: Manesh Timilsina
 * Author URI: https://maneshtimilsina.com/
 * Text Domain: majestic-before-after-image
 * Domain Path: /languages
 * License: GPLv3
 * License URI: https://www.gnu.org/licenses/gpl-3.0.html
 * Requires Plugins: elementor
 *
 * @package MBAI
 */

defined( 'ABSPATH' ) || exit;

define( 'MBAI_VERSION', '2.0.0' );
define( 'MBAI_SLUG', 'majestic-before-after-image' );
define( 'MBAI_BASE_NAME', basename( __DIR__ ) );
define( 'MBAI_BASE_FILEPATH', __FILE__ );
define( 'MBAI_BASE_FILENAME', plugin_basename( __FILE__ ) );
define( 'MBAI_DIR', rtrim( plugin_dir_path( __FILE__ ), '/' ) );
define( 'MBAI_URL', rtrim( plugin_dir_url( __FILE__ ), '/' ) );

if ( ! defined( 'WP_WELCOME_DIR' ) ) {
	define( 'WP_WELCOME_DIR', MBAI_DIR . '/vendor/ernilambar/wp-welcome' );
}

if ( ! defined( 'WP_WELCOME_URL' ) ) {
	define( 'WP_WELCOME_URL', MBAI_URL . '/vendor/ernilambar/wp-welcome' );
}

// Init autoload.
if ( file_exists( MBAI_DIR . '/vendor/autoload.php' ) ) {
	require_once MBAI_DIR . '/vendor/autoload.php';
	require_once MBAI_DIR . '/vendor/ernilambar/wp-welcome/init.php';
}

// Init plugin.
require_once MBAI_DIR . '/inc/mbai.php';
