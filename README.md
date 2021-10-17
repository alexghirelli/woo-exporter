# WooExporter
Contributors:

Donate link: https://www.alexghirelli.it

Tags: comments, spam

Requires at least: 3.0.1

Tested up to: 3.4

Stable tag: 4.3

License: GPLv2 or later

License URI: http://www.gnu.org/licenses/gpl-2.0.html

## Description

This plugin is useful to cache orders data into DynamoDB and export them form it. This approach increase export speed and reduce WooCommerce server load time.

## Installation

Please add this rule to wp_config.php

`define('AWS_KEY', 'AKIATB5RVG2LXO7R6ZBN' );`
`define('AWS_SECRET', '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');`


# Changelog

### 0.6
Improvement: new order data mapping
Fix: order data save to DynamoDB
### 0.5
This version is a first beta. It can sync orders from WooCommerce, from JSON structure and export into XLSX.