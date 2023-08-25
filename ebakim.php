<?php

/**
 * Plugin Name: eBakim
 * Plugin URI: https://eBakim.nl
 * Description: eBakim healthcare project
 * Author: TR Consultancy
 * Version: 0.1
 * Author URI: https://eBakim.nl
 * Text Domain: ebakim-wp
 */

if (!defined('WPINC')) {
    exit; // direct access
}


require_once __DIR__ . '/src/vendor/autoload.php';
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


function wpdocs_render_list_patient()
{
    $template_path = plugin_dir_path(__FILE__) . 'src/views/wpdocs_render_list_patient.php';
    if (file_exists($template_path)) {
        include_once($template_path);
    } else {
        echo 'Template file not found.';
    }
}

function my_plugin_load_textdomain()
{
    $translation_file = dirname(plugin_basename(__FILE__)) . '/languages/';
    $loaded = load_plugin_textdomain('ebakim-wp', false, $translation_file);

    if ($loaded) {
        // dd('Translation domain loaded successfully.');
    } else {
        // dd('Translation domain failed to load. File: ' . $translation_file);
    }
}

function wpdocs_render_import_patient()
{
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $file_tmp_name = $_FILES['excel_file']['tmp_name'];
        $excel = fopen($file_tmp_name, 'r');
        $data = [];

        // Generate an array of alphabet characters
        $alphabet = range('A', 'Z');

        while (($row = fgetcsv($excel)) !== false) {
            $rowData = [];
            $dynamic_key_index = 0;

            foreach ($row as $cell) {
                // Generate dynamic key based on the current index
                $dynamic_key = '';
                if ($dynamic_key_index < 26) {
                    $dynamic_key = $alphabet[$dynamic_key_index];
                } else {
                    $dynamic_key = $alphabet[(int)($dynamic_key_index / 26) - 1] . $alphabet[$dynamic_key_index % 26];
                }

                $rowData[$dynamic_key] = $cell;
                $dynamic_key_index++;
            }

            $data[] = $rowData;
        }

        fclose($excel);
        $has_error = 0;
        foreach ($data as $key => $value) {
            if (!$key)
                continue;
            foreach ($_POST['patient'] as $inner_key => $inner_value) {
                $data_to_insert[$inner_key] = $value[$inner_value];
            }
            global $wpdb;
            $table_name = $wpdb->prefix . 'eb_patients';
            $wpdb->insert($table_name, $data_to_insert);

            if ($wpdb->last_error !== '') {
                $has_error = 1;
            }
        }

        $redirect_url = admin_url('admin.php?page=ebakim-list-patient');
        wp_redirect($redirect_url);
        exit;
    }

    $template_path = plugin_dir_path(__FILE__) . 'src/views/wpdocs_render_import_patient.php';
    if (file_exists($template_path)) {
        include_once($template_path);
    } else {
        echo 'Template file not found.';
    }
}

function wpdocs_render_add_patient()
{
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $data = [
            "first_name" => is_array($_POST['first_name']) ? json_encode($_POST['first_name']) : $_POST['first_name'],
            "last_name" => is_array($_POST['last_name']) ? json_encode($_POST['last_name']) : $_POST['last_name'],
            "tc_number" => is_array($_POST['tc_number']) ? json_encode($_POST['tc_number']) : $_POST['tc_number'],
            "gender" => is_array($_POST['gender']) ? json_encode($_POST['gender']) : $_POST['gender'],
            "date_of_birth" => is_array($_POST['date_of_birth']) ? json_encode($_POST['date_of_birth']) : $_POST['date_of_birth'],
            "email" => is_array($_POST['email']) ? json_encode($_POST['email']) : $_POST['email'],
            "phone" => is_array($_POST['phone']) ? json_encode($_POST['phone']) : $_POST['phone'],
            "address" => is_array($_POST['address']) ? json_encode($_POST['address']) : $_POST['address'],
            "street" => is_array($_POST['street']) ? json_encode($_POST['street']) : $_POST['street'],
            "province" => is_array($_POST['province']) ? json_encode($_POST['province']) : $_POST['province'],
            "city" => is_array($_POST['city']) ? json_encode($_POST['city']) : $_POST['city'],
            "health_insurance" => is_array($_POST['health_insurance']) ? json_encode($_POST['health_insurance']) : $_POST['health_insurance'],
            "arrival_date" => is_array($_POST['arrival_date']) ? json_encode($_POST['arrival_date']) : $_POST['arrival_date'],
            "has_guardian" => is_array($_POST['has_guardian']) ? json_encode($_POST['has_guardian']) : $_POST['has_guardian'],
            "guardian_name" => is_array($_POST['guardian_name']) ? json_encode($_POST['guardian_name']) : $_POST['guardian_name'],
            "guardian_email" => is_array($_POST['guardian_email']) ? json_encode($_POST['guardian_email']) : $_POST['guardian_email'],
            "guardian_number" => is_array($_POST['guardian_number']) ? json_encode($_POST['guardian_number']) : $_POST['guardian_number'],
            "identification_sign" => is_array($_POST['identification_sign']) ? json_encode($_POST['identification_sign']) : $_POST['identification_sign'],
            "suicide_risk" => is_array($_POST['suicide_risk']) ? json_encode($_POST['suicide_risk']) : $_POST['suicide_risk'],
        ];
        $picture_filename = '';
        if (isset($_FILES['picture']) && $_FILES['picture']['error'] === UPLOAD_ERR_OK) {
            $upload_dir = wp_upload_dir();
            $target_dir = $upload_dir['path'] . '/images/';
            $picture_filename = $target_dir . basename($_FILES['picture']['name']);
            if (move_uploaded_file($_FILES['picture']['tmp_name'], $picture_filename)) {
                $data['picture'] = basename($_FILES['picture']['name']);
            }
        }
        global $wpdb;
        $table_name = $wpdb->prefix . 'eb_patients';
        $wpdb->insert($table_name, $data);

        $redirect_url = admin_url('admin.php?page=ebakim-list-patient');
        wp_redirect($redirect_url);
        exit;
    }
    $template_path = plugin_dir_path(__FILE__) . 'src/views/wpdocs_render_add_edit_patient.php';
    if (file_exists($template_path)) {
        include_once($template_path);
    } else {
        echo 'Template file not found.';
    }
}

function wpdocs_render_edit_patient()
{
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $data = [
            "first_name" => is_array($_POST['first_name']) ? json_encode($_POST['first_name']) : $_POST['first_name'],
            "last_name" => is_array($_POST['last_name']) ? json_encode($_POST['last_name']) : $_POST['last_name'],
            "tc_number" => is_array($_POST['tc_number']) ? json_encode($_POST['tc_number']) : $_POST['tc_number'],
            "gender" => is_array($_POST['gender']) ? json_encode($_POST['gender']) : $_POST['gender'],
            "date_of_birth" => is_array($_POST['date_of_birth']) ? json_encode($_POST['date_of_birth']) : $_POST['date_of_birth'],
            "email" => is_array($_POST['email']) ? json_encode($_POST['email']) : $_POST['email'],
            "phone" => is_array($_POST['phone']) ? json_encode($_POST['phone']) : $_POST['phone'],
            "address" => is_array($_POST['address']) ? json_encode($_POST['address']) : $_POST['address'],
            "street" => is_array($_POST['street']) ? json_encode($_POST['street']) : $_POST['street'],
            "province" => is_array($_POST['province']) ? json_encode($_POST['province']) : $_POST['province'],
            "city" => is_array($_POST['city']) ? json_encode($_POST['city']) : $_POST['city'],
            "health_insurance" => is_array($_POST['health_insurance']) ? json_encode($_POST['health_insurance']) : $_POST['health_insurance'],
            "arrival_date" => is_array($_POST['arrival_date']) ? json_encode($_POST['arrival_date']) : $_POST['arrival_date'],
            "has_guardian" => is_array($_POST['has_guardian']) ? json_encode($_POST['has_guardian']) : $_POST['has_guardian'],
            "guardian_name" => is_array($_POST['guardian_name']) ? json_encode($_POST['guardian_name']) : $_POST['guardian_name'],
            "guardian_email" => is_array($_POST['guardian_email']) ? json_encode($_POST['guardian_email']) : $_POST['guardian_email'],
            "guardian_number" => is_array($_POST['guardian_number']) ? json_encode($_POST['guardian_number']) : $_POST['guardian_number'],
            "identification_sign" => is_array($_POST['identification_sign']) ? json_encode($_POST['identification_sign']) : $_POST['identification_sign'],
            "suicide_risk" => is_array($_POST['suicide_risk']) ? json_encode($_POST['suicide_risk']) : $_POST['suicide_risk'],
        ];
        $picture_filename = '';
        if (isset($_FILES['picture']) && $_FILES['picture']['error'] === UPLOAD_ERR_OK) {
            $upload_dir = wp_upload_dir();
            $target_dir = $upload_dir['path'] . '/images/';
            $picture_filename = $target_dir . basename($_FILES['picture']['name']);
            if (move_uploaded_file($_FILES['picture']['tmp_name'], $picture_filename)) {
                $data['picture'] = basename($_FILES['picture']['name']);
            }
        }
        global $wpdb;
        $patient_id = intval($_POST['id']); // Sanitize and convert to integer
        // Update data in the database
        global $wpdb;
        $table_name = $wpdb->prefix . 'eb_patients';
        $wpdb->update($table_name, $data, ['id' => $patient_id]);
    }

    // Redirect back to the list patient page after deletion
    $redirect_url = admin_url('admin.php?page=ebakim-list-patient');
    wp_redirect($redirect_url);
    exit; // Always exit after a redirect
}

function wpdocs_render_delete_patient()
{
    if (isset($_GET['id']) && is_numeric($_GET['id'])) {
        $patient_id = intval($_GET['id']);

        // Perform the deletion operation
        global $wpdb;
        $table_name = $wpdb->prefix . 'eb_patients';
        $wpdb->delete($table_name, array('id' => $patient_id));

        // Redirect back to the list patient page after deletion
        $redirect_url = admin_url('admin.php?page=ebakim-list-patient');
        wp_redirect($redirect_url);
        exit; // Always exit after a redirect
    }
}

function main()
{
    add_menu_page(
        __('eBakim ', 'ebakim-wp'),        // Sidebar menu title
        __('eBakim', 'ebakim-wp'),          // Actual page title
        'manage_options',               // Required capability to access the menu
        'ebakim',                       // Menu slug
        'wpdocs_render_list_patient',   // Callback function to render the page
        'dashicons-admin-plugins',      // Dashicon for the menu
        6                               // Menu position
    );

    add_submenu_page(
        'ebakim',                        // Parent menu slug
        __('List Patient', 'ebakim-wp'),    // Submenu page title
        __('List Patient', 'ebakim-wp'),    // Submenu menu title
        'manage_options',                // Required capability to access the submenu
        'ebakim-list-patient',           // Submenu slug
        'wpdocs_render_list_patient'     // Callback function to render the submenu page
    );

    add_submenu_page(
        'ebakim',                        // Parent menu slug
        __('New Patient', 'ebakim-wp'),     // Submenu page title
        __('New Patient', 'ebakim-wp'),     // Submenu menu title
        'manage_options',                // Required capability to access the submenu
        'ebakim-add-patient',            // Submenu slug
        'wpdocs_render_add_patient' // Callback function to render the submenu page
    );

    add_submenu_page(
        'ebakim',                        // Parent menu slug
        __('Import Patient', 'ebakim-wp'),     // Submenu page title
        __('Import Patient', 'ebakim-wp'),     // Submenu menu title
        'manage_options',                // Required capability to access the submenu
        'ebakim-import-patient',            // Submenu slug
        'wpdocs_render_import_patient' // Callback function to render the submenu page
    );

    remove_submenu_page('ebakim', 'ebakim');
}




add_action('plugins_loaded', 'my_plugin_load_textdomain');
add_action('admin_menu', 'main');
add_action('admin_post_add_patient', 'wpdocs_render_add_patient');
add_action('admin_post_edit_patient', 'wpdocs_render_edit_patient');
add_action('admin_post_delete_patient', 'wpdocs_render_delete_patient');
add_action('admin_post_import_patients', 'wpdocs_render_import_patient');






function custom_login_logo()
{
    $custom_logo_url = plugins_url('/ebakim-wp/src/assets/images/main-logo.png');
    echo '<style type="text/css">
        .login h1 a {
            background-image: url(' . $custom_logo_url . ');
            background-size: contain;
            width: 100%;
            height: 160px   ; /* Adjust this height as needed */
        }
    </style>';
}
add_action('login_header', 'custom_login_logo');





function verify_2fa_during_setup()
{
   
    $authCode = isset($_POST['2fa_code']) ? $_POST['2fa_code'] : '';

    if (empty($authCode)) {
        set_flash_error_cookie(__('Please enter the authentication code.', 'ebakim-wp'));
        redirect_back();
    }

    $key = get_2fa_key();
    $secretKey = base32_encode($key);
    $authenticator = new PHPGangsta_GoogleAuthenticator();
    $isValidCode = $authenticator->verifyCode($secretKey, $authCode, 2);

    if (!$isValidCode) {
        set_flash_error_cookie(__('Authentication code is invalid.', 'ebakim-wp'));
        redirect_back();
    } else {
        update_user_meta(get_current_user_id(), '2fa_verified', 1);
        update_user_meta(get_current_user_id(), 'allow_user_to_dashboard', 1);
        wp_redirect(admin_url());
        exit();
    }
}





add_action('admin_post_setup_2fa', 'verify_2fa_during_setup');





function custom_login_redirect($user_login = '', $user = '')
{
    if ($user->id) {
        // dd($user->id);
        $is_2fa_enabled = get_user_meta($user->id, '2fa_verified', true);

       if ($is_2fa_enabled) {
    $auth_url = plugins_url('wp-2fa-auth.php', __FILE__);
    wp_redirect($auth_url);
    exit;
} else {
    $setup_url = plugins_url('wp-2fa-setup.php', __FILE__);
    wp_redirect($setup_url);
    exit;
}

    }
}
add_action('wp_login', 'custom_login_redirect', 10, 2); // Increased priority value (default is 10)




function verify_2fa()
{

    $authCode = isset($_POST['2fa_code']) ? $_POST['2fa_code'] : '';
 
    if (get_user_meta(get_current_user_id(), '2fa_verified', true)) {

        if (empty($authCode)) {
            set_flash_error_cookie(__('Please enter the authentication code.', 'ebakim-wp'));
            redirect_back();
        }

        $key = get_2fa_key();
        $secretKey = base32_encode($key);
        $authenticator = new PHPGangsta_GoogleAuthenticator();
        $isValidCode = $authenticator->verifyCode($secretKey, $authCode, 2);

        if (!$isValidCode) {
            set_flash_error_cookie(__('Authentication code is invalid.', 'ebakim-wp'));
            redirect_back();
        } else {
            update_user_meta(get_current_user_id(), 'allow_user_to_dashboard', 1);
            wp_redirect(admin_url());
            exit();
        }
    } else {
        set_flash_error_cookie( __('2FA is not enabled for this user.', 'ebakim-wp'));
        redirect_back();
    }
}
add_action('admin_post_verify_2fa', 'verify_2fa');
    


function allow_user_to_dashboard()
{
    if (!get_user_meta(get_current_user_id(), 'allow_user_to_dashboard', true)) {
        
        wp_redirect(site_url('/wp-login.php'));
    }
}



add_action('admin_init', 'allow_user_to_dashboard'); // Increased priority value (default is 10)



function custom_logout_action($user_id) {
    if ($user_id) {
        delete_user_meta($user_id, 'allow_user_to_dashboard');
        // Other custom actions for logout
    }
}
add_action('wp_logout', 'custom_logout_action');
