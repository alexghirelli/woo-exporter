=== WooExporter ===
Contributors:
Donate link: https://www.alexghirelli.it
Tags: comments, spam
Requires at least: 3.0.1
Tested up to: 3.4
Stable tag: 4.3
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

== Description ==

This plugin is useful to cache orders data into DynamoDB and export them from it. This approach increase export speed and reduce WooCommerce server load time.

== Installation ==

Please add this rule to wp_config.php

`define('AWS_KEY', AWS_KEY );`
`define('AWS_SECRET', AWS_SECRET);`


== Changelog ==

= 0.7 =
Fix: DynamoDB was retrieving a limited set of data. Now we get all data given two dates.
= 0.6 =
Improvement: new order data mapping
Fix: order data save to DynamoDB
= 0.5 =
This version is a first beta. It can sync orders from WooCommerce, from JSON structure and export into XLSX.