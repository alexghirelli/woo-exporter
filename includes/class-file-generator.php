<?php

/**
 * File Generator
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    Woo_Exporter
 * @subpackage Woo_Exporter/includes
 * @author     Alex Ghirelli <info@alexghirelli.it>
 */

require plugin_dir_path( dirname( __FILE__ ) ) . '/vendor/autoload.php';

use SimpleXLSXGen as SimpleXLSXGen;

class Woo_File_Generator {
    private $xlsx;
    private $fileType;

    public function __construct($fileType = 'xlsx') {
        $this->fileType = $fileType;
        $this->xlsx = new SimpleXLSXGen();
    }

    public function save($orders) {
        switch($this->fileType) {
            case 'xlsx':
                $this->xlsx->addSheet( $orders, 'orders' );
                $this->xlsx->saveAs("export-orders-". date('Y-m-d:h:i:s') .".xlsx");
                break;
        }
    }

    public function download($orders) {
        switch($this->fileType) {
            case 'xlsx':
                $this->xlsx->addSheet( $orders, 'orders' );
                $this->xlsx->downloadAs("export-orders-". date('Y-m-d:h:i:s') .".xlsx");
                break;
        }
    }
}
