<?php

/**
 * WooCommerce utils functions
 *
 * @link       https://www.alexghirelli.it
 * @since      1.0.0
 *
 * @package    Woo_Exporter
 * @subpackage Woo_Exporter/includes
 */

class WooCommerceUtils {

	/**
	 * Get Order data
	 *
	 * Get all data of a specific order given its order ID
	 *
	 * @since    1.0.0
	 */
	public function getOrder($orderId) {
        $order = wc_get_order( $orderId );

        $order_data = $order->get_data();
        $order_data['orderDate'] = date("Ymd", strtotime($order->get_date_created()));

        return $order_data;
    }

    /**
	 * Get all Orders data
	 *
	 * Get all data of orders given start and end date
	 *
	 * @since    1.0.0
	 */
	public function getOrders($startDate, $endDate) {
        // TODO: implement get all orders data
    }

}