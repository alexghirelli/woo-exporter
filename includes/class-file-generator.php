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

use SimpleXLSXGen;

class Woo_File_Generator {
    private $xlsx;
    private $headers;
    private $fileType;

    public function __construct($headers = [], $fileType = 'xlsx') {
        $this->headers = $headers ?? [];
        $this->fileType = $fileType;
    }

    public function dataMap($orders) {
        return [
            $this->headers,
            $orders
        ];
    }
    
	public function create($data)
    {
        switch($this->fileType) {
            case 'xlsx':
                $this->xlsx = SimpleXLSXGen::fromArray($data);
                break;
        }
    }

    public function save() {
        switch($this->fileType) {
            case 'xlsx':
                $this->xlsx->saveAs("export-orders-". date('Y-m-d:h:i:s') .".xlsx");
                break;
        }
    }

    public function download() {
        switch($this->fileType) {
            case 'xlsx':
                $this->xlsx->downloadAs("export-orders-". date('Y-m-d:h:i:s') .".xlsx");
                break;
        }
    }
}
