<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://www.alexghirelli.it
 * @since             0.5.0
 * @package           Woo_Exporter
 *
 * @wordpress-plugin
 * Plugin Name:       Woo Exporter (with AWS)
 * Plugin URI:        https://www.alexghirelli.it/woo-exporter
 * Description:       This plugin is useful to cache orders data into DynamoDB and export them from it.
 * Version:           0.7.3
 * Author:            Alex Ghirelli
 * Author URI:        https://www.alexghirelli.it
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       woo-exporter
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 * Start at version 0.6.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'WOO_EXPORTER_VERSION', '0.6.0' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-woo-exporter-activator.php
 */
function activate_woo_exporter() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-woo-exporter-activator.php';
	Woo_Exporter_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-woo-exporter-deactivator.php
 */
function deactivate_woo_exporter() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-woo-exporter-deactivator.php';
	Woo_Exporter_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_woo_exporter' );
register_deactivation_hook( __FILE__, 'deactivate_woo_exporter' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-woo-exporter.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    0.6.0
 */
function run_woo_exporter() {

	$plugin = new Woo_Exporter();
	$plugin->run();

}
run_woo_exporter();
