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
require plugin_dir_path( dirname( __FILE__ ) ) . '/utils/woocommerce.php';

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

        var_dump($orderData);

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

    public function fetch() {
        $orders = [];
        $eav = $this->marshaler->marshalJson('
            {
                ":yyyy-mm-dd": 2021-10-11,
                ":status": on-hold
            }
        ');

        $params = [
            'TableName' => 'wc-orders',
            'KeyConditionExpression' => '#dt = :yyyy-mm-dd and status = :status ',
            'ExpressionAttributeNames'=> [ '#dt' => 'date' ],
            'ExpressionAttributeValues'=> $eav
        ];

        try {
            $result = $this->dynamodb->query($params);

            foreach ($result['Items'] as $item) {
                array_push($orders, $item);
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

    public function _remove($orderId) {
        
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
}
