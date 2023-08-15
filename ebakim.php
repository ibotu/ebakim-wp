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


function wpdocs_render_patient_page() {
    // Get the absolute path to the template file
    $template_path = plugin_dir_path( __FILE__ ) . 'src/templates/edit-patient.php';

    // print_r($template_path);

    if ( file_exists( $template_path ) ) {
        include_once( $template_path );
    } else {
        echo 'Template file not found.';
    }
}

function wpdocs_register_my_custom_menu_page() {
    add_menu_page(
        __( 'eBakim Patient', 'textdomain' ),
        'eBakim Patient',
        'manage_options',
        'ebakim-patient', // Change to a valid menu slug
        'wpdocs_render_patient_page', // Callback function to render the page
        'dashicons-admin-plugins',
        6
    );
}
add_action( 'admin_menu', 'wpdocs_register_my_custom_menu_page' );
