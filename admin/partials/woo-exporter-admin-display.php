<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       https://www.alexghirelli.it
 * @since      1.0.0
 *
 * @package    Woo_Exporter
 * @subpackage Woo_Exporter/admin/partials
 */

function adminPageContent() {
    if ( !current_user_can( 'manage_options' ) )  {
        wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
    }
	?>
		<div class="woo-exporter-container">
            <div class="date-select">

            </div>
            <button id="export">Export</button>
        </div>
	<?php
}