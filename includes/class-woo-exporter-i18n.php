<?php

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       https://www.alexghirelli.it
 * @since      0.6.0
 *
 * @package    Woo_Exporter
 * @subpackage Woo_Exporter/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      0.6.0
 * @package    Woo_Exporter
 * @subpackage Woo_Exporter/includes
 * @author     Alex Ghirelli <info@alexghirelli.it>
 */
class Woo_Exporter_i18n {


	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    0.6.0
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'woo-exporter',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);

	}



}
