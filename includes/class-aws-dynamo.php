<?php

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    Woo_Exporter
 * @subpackage Woo_Exporter/includes
 * @author     Alex Ghirelli <info@alexghirelli.it>
 */

require plugin_dir_path( dirname( __FILE__ ) ) . '/vendor/autoload.php';

use Aws\DynamoDb\Exception\DynamoDbException;
use Aws\DynamoDb\Marshaler;

class Woo_Aws_DynamoDB {
    private $dynamodb;
    private $marshaler;
    private $wooUtils;

    public function __construct($key, $secret, $region) {
        $sdk = new Aws\Sdk([
            'version'     => 'latest',
            'region'      => $region,
            'credentials' => [
                'key'    => $key,
                'secret' => $secret,
            ],
        ]);

        $this->dynamodb = $sdk->createDynamoDb();

        $this->marshaler = new Marshaler();
        $this->wooUtils = new WooCommerceUtils();
    }
    
	public function insert($orderId) {
        $orderData = $this->wooUtils->getOrder($orderId);

        $params = [
            'TableName' => 'wc-orders',
            'Item' => $this->marshaler->marshalJson(json_encode($orderData))
        ];


        try {
            $result = $this->dynamodb->putItem($params);
            echo "result: $result";

        } catch (DynamoDbException $e) {
            echo "Unable to add item:\n";
            echo $e->getMessage() . "\n";
        }
	}

    public function fetch($dateFrom, $dateTo) {
        $orders = [];

        $jsonData = json_encode([
            ":dateFrom" => date("Ymd", strtotime($dateFrom)),
            ":dateTo" => date("Ymd", strtotime($dateTo))
        ]);

        $eav = $this->marshaler->marshalJson($jsonData);

        $params = [
            'TableName' => 'wc-orders',
            'FilterExpression' => 'orderDate BETWEEN :dateFrom and :dateTo',
            'ExpressionAttributeValues'=> $eav
        ];

        try {
            $result = $this->dynamodb->scan($params);

            foreach ($result['Items'] as $item) {
                array_push($orders, $this->_beautify($item));
            }

        } catch (DynamoDbException $e) {
            echo "Unable to query:\n";
            echo $e->getMessage() . "\n";
        }

        return $orders;
    }

    public function update($orderId) {
        $this->_remove($orderId);
        $this->insert($orderId);
    }

    private function _remove($orderId) {
        
        $params = [
            'TableName' => 'wc-orders',
            'Key' => $this->marshaler->marshalJson('
                {
                    "id": ' . $orderId . '
                }
            ')
        ];


        try {
            $this->dynamodb->deleteItem($params);
            echo "Deleted item.\n";

        } catch (DynamoDbException $e) {
            echo "Unable to delete item:\n";
            echo $e->getMessage() . "\n";
        }
    }

    private function _beautify($orderData) {
        return $this->marshaler->unmarshalItem($orderData);
    }
}
