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
        $this->fileGenerator = new Woo_File_Generator([
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
        ]);
    }

    public function exportOrders() {
        $data = $this->dynamoDb->fetch($_GET['dateFrom'], $_GET['dateTo']);

        // $this->fileGenerator->
        print_r(json_encode($data));
    }

    public function syncOrders() {
    }
}
