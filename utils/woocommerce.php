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

        $orders = wc_get_orders(array(
            'limit'=>-1,
            'type'=> 'shop_order',
            'status'=> array('wc-processing', 'wc-on-hold'),
            'date_created'=> $startDate .'...'. $endDate 
            )
        );

        foreach($orders as $order) {
            $data = $order->get_data();
            array_push($ordersData, $data['id']);
        }
        
        return $ordersData;
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