<?php
/**
 * Plugin Name: Majestic Before After Image
 * Plugin URI: https://wpconcern.com/plugins/majestic-before-after-image/
 * Description: Majestic Before After Image is an Elementor addon to show the comparison of two images with a draggable handle.
 * Version: 1.0.4
 * Author: WP Concern
 * Author URI: https://wpconcern.com/
 * Text Domain: majestic-before-after-image
 * License: GPLv3
 * License URI: https://www.gnu.org/licenses/gpl-3.0.html
 *
 * @package MBAI
 */

defined( 'ABSPATH' ) || exit;

define( 'MBAI_VERSION', '1.0.4' );
define( 'MBAI_SLUG', 'majestic-before-after-image' );
define( 'MBAI_BASE_NAME', basename( dirname( __FILE__ ) ) );
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
