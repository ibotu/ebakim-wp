<?php

/**
 * Plugin Name: eBakim
 * Plugin URI: https://eBakim.nl
 * Description: eBakim healthcare project test
 * Author: TR Consultancy
 * Version: 0.1
 * Author URI: https://eBakim.nl
 * Text Domain: ebakim-wp
 */

if (!defined('WPINC')) {
    exit; // direct access
}


require_once __DIR__ . '/src/vendor/autoload.php';
require_once __DIR__ . '/src/scrape/autoload.php';
require_once plugin_dir_path(__FILE__) . 'src/utils/helpers/helper.php';
require_once plugin_dir_path(__FILE__) . 'src/utils/PHPGangsta/GoogleAuthenticator.php';

use Endroid\QrCode\Color\Color;
use Endroid\QrCode\Encoding\Encoding;
use Endroid\QrCode\ErrorCorrectionLevel\ErrorCorrectionLevelLow;
use Endroid\QrCode\Label\Label;
use Endroid\QrCode\Logo\Logo;
use Endroid\QrCode\QrCode;
use Endroid\QrCode\RoundBlockSizeMode\RoundBlockSizeModeMargin;
use Endroid\QrCode\Writer\PngWriter;


(new \eBakim\App(__FILE__))->setup();

/*add_action('rest_api_init', function() {
    register_rest_route('scraping/v1', '/endpoint', array(
        'methods' => 'POST',
        'callback' => array(new ScrapePatientProfile(), 'init'),
        //'callback'=>[$controller, 'handle_request'],
    ));
});*/

?>