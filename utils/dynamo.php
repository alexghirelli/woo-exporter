<?php

/**
 * DynamoDB utils functions
 *
 * @link       https://www.alexghirelli.it
 * @since      0.6.1
 *
 * @package    Woo_Exporter
 * @subpackage Woo_Exporter/includes
 */

require plugin_dir_path( dirname( __FILE__ ) ) . '/vendor/autoload.php';

use Aws\DynamoDb\Marshaler;

class DynamoUtils {
    private $marshaler;

    public function __construct() {
        $this->marshaler = new Marshaler();
    }

	/**
	 * Beautify JSON from DynamoDB format
	 *
	 * @since    0.6.1
	 */
	public function beautify($order) {
        return $this->marshaler->unmarshalItem($order);
    }

}