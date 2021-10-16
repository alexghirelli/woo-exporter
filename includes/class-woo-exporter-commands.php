<?php

/**
 * Exporter Commands
 *
 *
 * @since      1.0.0
 * @package    Woo_Exporter
 * @subpackage Woo_Exporter/includes
 * @author     Alex Ghirelli <info@alexghirelli.it>
 */

class Woo_Exporter_Commands {
    public function __construct($dynamoDb) {
        $this->dynamoDb = $dynamoDb;
        $this->wooUtils = new WooCommerceUtils();
        $this->fileGenerator = new Woo_File_Generator();
    }

    public function exportOrders() {
        $orders = $this->dynamoDb->fetch($_GET['dateFrom'], $_GET['dateTo']);
        $dataToExport = [
            [
                "Order ID",
                "Order Total",
                "Payment Gateway",
                "Order Status",
                "Order Date",
                "Customer Message",
                "Total Quantity",
                "Total Order Items",
                "Billing: Full Name",
                "Billing: Phone Number",
                "Billing: E-mail Address",
                "Shipping: Full Name",
                "Shipping: Company",
                "Shipping: Street Address (Full)",
                "Shipping: City",
                "Shipping: ZIP Code",
                "Shipping: State (prefix)",
                "Shipping: State Billing: Desideri Fattura? (G.A.S., Mini Market, etc.)",
                "Order Item #1: Product Name",
                "Order Item #1: Quantity",
                "Order Item #2: Product Name",
                "Order Item #2: Quantity",
                "Order Item #3: Product Name",
                "Order Item #3: Quantity",
                "Order Item #4: Product Name",
                "Order Item #4: Quantity",
                "Order Item #5: Product Name",
                "Order Item #5: Quantity"
            ]
        ];

        foreach($orders as $order) {
            $totalQuantity = 0;
            foreach ($order['line_items'] as $item) {
                $totalQuantity += $item['quantity'];
            }

            $dataToExport[] = [
                $order['id'],
                $order['total'],
                $order['payment_method_title'],
                $order['status'],
                $order['date_created'],
                $order['customer_note'],
                $totalQuantity,
                count($order['line_items']),
                $order['billing']['first_name'] . " " . $order['billing']['last_name'],
                $order['billing']['phone'],
                $order['billing']['email'],
                $order['shipping']['first_name'] . " " . $order['shipping']['last_name'],                
                $order['shipping']['company'],
                $order['shipping']['address_1'],
                $order['shipping']['city'],
                $order['shipping']['postcode'],
                $order['shipping']['state'],
                $order['meta_data'][0]['value'],
                count($order['line_items']) > 0 ? $order['line_items'][0]['name'] : '',
                count($order['line_items']) > 0 ? $order['line_items'][0]['quantity'] : '',
                count($order['line_items']) > 1 ? $order['line_items'][1]['name'] : '',
                count($order['line_items']) > 1 ? $order['line_items'][1]['quantity'] : '',
                count($order['line_items']) > 2 ? $order['line_items'][2]['name'] : '',
                count($order['line_items']) > 2 ? $order['line_items'][2]['quantity'] : '',
                count($order['line_items']) > 3 ? $order['line_items'][3]['name'] : '',
                count($order['line_items']) > 3 ? $order['line_items'][3]['quantity'] : '',
                count($order['line_items']) > 4 ? $order['line_items'][4]['name'] : '',
                count($order['line_items']) > 4 ? $order['line_items'][4]['quantity'] : '',
            ];
        }

        $this->fileGenerator->download($dataToExport);

        // $this->fileGenerator->
    }

    public function syncOrders() {
        $wooOrders = $this->wooUtils->getOrdersIds($_GET['dateFrom'], $_GET['dateTo']);

        var_dump($wooOrders);

        foreach($wooOrders as $order) {
            $this->dynamoDb->insert($order);
        }
    }

    public function syncOrdersFromJson() {
        if ( isset ( $_POST ) ) {
            $jsonOrders = json_decode(stripslashes($_POST['json']));

            foreach($jsonOrders as $order) {
                $this->dynamoDb->insert($order, 'json');
            }
        }   
    }
}
