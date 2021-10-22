<?php

/**
 * WooCommerce utils functions
 *
 * @link       https://www.alexghirelli.it
 * @since      0.6.0
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
	 * @since    0.6.0
	 */
	public function getOrder($orderId) {
        $order = wc_get_order( $orderId );
        return $this->_mapOrderData($order, $orderId);
    }

    /**
	 * Get all Orders data
	 *
	 * Get all data of orders given start and end date
	 *
	 * @since    0.6.0
	 */
	public function getOrdersIds($startDate, $endDate) {
        $ordersData = [];

        $orders = wc_get_orders(
            [
                'limit'=>-1,
                'type'=> 'shop_order',
                'status'=> ['wc-processing', 'wc-on-hold'],
                'date_created'=> $startDate .'...'. $endDate 
            ]
        );

        foreach($orders as $order) {
            $data = $order->get_data();
            array_push($ordersData, $data['id']);
        }
        
        return $ordersData;
    }

    /**
	 * Translate order status
	 *
	 * @since    0.7.1
	 */
	public function translateOrderStatus($wcOrderStatus) {
        switch ($wcOrderStatus) {
            case 'pending':
                return __( 'Pending', 'woo-exporter' );
                break;

            case 'processing':
                return __( 'Processing', 'woo-exporter' );
                break;

            case 'on-hold':
                return __( 'On hold', 'woo-exporter' );
                break;

            case 'completed':
                return __( 'Completed', 'woo-exporter' );
                break;

            case 'cancelled':
                return __( 'Cancelled', 'woo-exporter' );
                break;

            case 'refunded':
                return __( 'Refunded', 'woo-exporter' );
                break;

            case 'failed':
                return __( 'Failed', 'woo-exporter' );
                break;
        }
    }

    /**
	 * Map order data
	 *
	 * Map all order data 
	 *
	 * @since    0.6.0
	 */
	private function _mapOrderData($order, $orderId) {
        $order_data = $order->get_data();
        $order_meta = get_post_meta($orderId);

        foreach ($order->get_items() as $item ) {
            $item_data    = $item->get_data();

            $order_data['line_items'] = [];
            $order_data['line_items'][] = [
                'name' => $item_data['name'],
                'quantity' => $item_data['quantity'],
                'subtotal' => $item_data['subtotal'],
                'total' => $item_data['total']
            ];
        }

        $order_data['meta_data'] = $order_meta;
        $order_data['orderDate'] = date("Ymd", strtotime($order_data['date_created']));
        
        return $order_data;
    }

}