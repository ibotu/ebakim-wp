<?php
/**
* Plugin Name: eBakim
* Plugin URI: https://eBakim.nl
* Description: eBakim healthcare project
* Author: TR Consultancy
* Version: 0.1
* Author URI: https://eBakim.nl
* Text Domain: eBakim
*/

if ( ! defined ( 'WPINC' ) ) {
    exit; // direct access
}

require_once __DIR__ . '/src/vendor/autoload.php';

(new \eBakim\App(__FILE__))->setup();