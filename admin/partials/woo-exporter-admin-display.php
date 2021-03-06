<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       https://www.alexghirelli.it
 * @since      0.6.0
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
            <h1>WooExporter</h1>
            <h3>Esporta gli ordini di WooCommerce da DynamoDB con un click.</h3>

            <div class="date-select">
                <form action="<?php echo admin_url( 'admin-post.php' ); ?>">
                    <input type="hidden" name="action" value="export">
                    <input type="date" id="dateFrom" name="dateFrom">
                    <input type="date" id="dateTo" name="dateTo">
                    <?php submit_button( 'Export' ); ?>
                </form>
            </div>

            <br />
            <br />
            <br />

            <h3>Sincronizza gli ordini di WooCommerce su DynamoDB con un click.</h3>
            <div class="date-select">
                <h4>
                    Da date specifiche
                </h4>
                <form action="<?php echo admin_url( 'admin-post.php' ); ?>">
                    <input type="hidden" name="action" value="sync">
                    <input type="date" id="dateFrom" name="dateFrom">
                    <input type="date" id="dateTo" name="dateTo">
                    <?php submit_button( 'Sync' ); ?>
                </form>

                <h4>
                    Da JSON
                </h4>
                <form action="<?php echo admin_url( 'admin-post.php' ); ?>" method="POST">
                    <input type="hidden" name="action" value="syncjson">
                    <textarea name="json" id="json" cols="50" rows="30"></textarea>
                    <?php submit_button( 'Sync da JSON' ); ?>
                </form>
            </div>
        </div>
	<?php
}