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

            $data_to_insert = [
                'status' => $value['A'],
                'patientID' => $value['B'],
                'patientFullName' => $value['C'],
                'patientBirthDate' => $value['D'],
                'patientTcNumber' => $value['E'],
                'clinicAcceptanceDate' => $value['F'],
                'clinicPlacementType' => $value['G'],
                'clinicPlacementStatus' => $value['H'],
                'clinicEndDate' => $value['I'],
                'clinicLifePlanDate' => $value['J'],
                'clinicEskrDate' => $value['K'],
                'clinicGuardianDate' => $value['L'],
                'clinicAllowanceStatus' => $value['M']
                // ... add more fields here as needed
            ];

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
            "patientID" => $_POST['patientID'],
            "patientFullName" => $_POST['patientFullName'],
            "patientBirthDate" => $_POST['patientBirthDate'],
            "patientTcNumber" => $_POST['patientTcNumber'],
            "clinicAcceptanceDate" => $_POST['clinicAcceptanceDate'],
            "clinicPlacementType" => $_POST['clinicPlacementType'],
            "clinicPlacementStatus" => $_POST['clinicPlacementStatus'],
            "clinicEndDate" => $_POST['clinicEndDate'],
            "clinicLifePlanDate" => $_POST['clinicLifePlanDate'],
            "clinicEskrDate" => $_POST['clinicEskrDate'],
            "clinicGuardianDate" => $_POST['clinicGuardianDate'],
            "clinicAllowanceStatus" => $_POST['clinicAllowanceStatus'],
            // Add other field names here
        ];

        // Process the picture file if uploaded
        $picture_filename = '';
        if (isset($_FILES['patientImage']) && $_FILES['patientImage']['error'] === UPLOAD_ERR_OK) {

            $upload_dir = wp_upload_dir();
            $target_dir = $upload_dir['path'] . '/images/';
            $picture_filename = $target_dir . basename($_FILES['patientImage']['name']);
            if (move_uploaded_file($_FILES['patientImage']['tmp_name'], $picture_filename)) {
                $data['picture'] = basename($_FILES['patientImage']['name']);
            }
        }

        // Insert data into the database
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
            "patientID" => $_POST['patientID'],
            "patientFullName" => $_POST['patientFullName'],
            "patientBirthDate" => $_POST['patientBirthDate'],
            "patientTcNumber" => $_POST['patientTcNumber'],
            "clinicAcceptanceDate" => $_POST['clinicAcceptanceDate'],
            "clinicPlacementType" => $_POST['clinicPlacementType'],
            "clinicPlacementStatus" => $_POST['clinicPlacementStatus'],
            "clinicEndDate" => $_POST['clinicEndDate'],
            "clinicLifePlanDate" => $_POST['clinicLifePlanDate'],
            "clinicEskrDate" => $_POST['clinicEskrDate'],
            "clinicGuardianDate" => $_POST['clinicGuardianDate'],
            "clinicAllowanceStatus" => $_POST['clinicAllowanceStatus'],
            // Add other field names here
        ];

        // Handle picture upload
        $picture_filename = '';
        if (isset($_FILES['patientImage']) && $_FILES['patientImage']['error'] === UPLOAD_ERR_OK) {
            $upload_dir = wp_upload_dir();
            $target_dir = $upload_dir['path'] . '/images/';
            $picture_filename = $target_dir . basename($_FILES['patientImage']['name']);
            if (move_uploaded_file($_FILES['patientImage']['tmp_name'], $picture_filename)) {
                $data['patientImage'] = basename($_FILES['patientImage']['name']);
            }
        }

        // Update data in the database
        $patient_id = intval($_POST['id']); // Sanitize and convert to integer
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


    add_submenu_page(
        'ebakim',                        // Parent menu slug
        __('Add SSO', 'ebakim-wp'),      // Submenu page title
        __('Add SSO', 'ebakim-wp'),      // Submenu menu title
        'manage_options',                // Required capability to access the submenu
        'ebakim-add-sso',                // Submenu slug
        'wpdocs_render_ebakim_add_sso'         // Callback function to render the submenu page
    );

    add_submenu_page(
        'ebakim',                        // Parent menu slug
        __('Add Healthcare', 'ebakim-wp'), // Submenu page title
        __('Add Healthcare', 'ebakim-wp'), // Submenu menu title
        'manage_options',                // Required capability to access the submenu
        'ebakim-add-healthcare',         // Submenu slug
        'wpdocs_render_ebakim_add_healthcare'  // Callback function to render the submenu page
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
        set_flash_error_cookie(__('2FA is not enabled for this user.', 'ebakim-wp'));
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



function custom_logout_action($user_id)
{
    if ($user_id) {
        delete_user_meta($user_id, 'allow_user_to_dashboard');
        // Other custom actions for logout
    }
}
add_action('wp_logout', 'custom_logout_action');









function wpdocs_render_ebakim_add_sso()
{
    global $wpdb;

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        $patient_id = isset($_POST['id']) ? intval($_POST['id']) : 0;
        unset($_POST['id']);
        unset($_POST['action']);
        unset($_POST['submit']);

        $table_name = $wpdb->prefix . 'eb_patients';

        // Serialize the data to store in the sso_details column
        $serialized_data = maybe_serialize(($_POST));
        // Update the database
        $updated = $wpdb->update(
            $table_name,
            array('sso_details' => $serialized_data),
            array('id' => $patient_id),
            array('%s'),
            array('%d')
        );

        if ($updated !== false) {
            // Redirect after successful update
            $redirect_url = admin_url('admin.php?page=ebakim-list-patient');
            wp_redirect($redirect_url);
            exit;
        } else {
            echo "Database update failed."; // For debugging purposes
        }
    }


    // Render your SSO form HTML here
    $template_path = plugin_dir_path(__FILE__) . 'src/views/wpdocs_render_add_sso.php';
    if (file_exists($template_path)) {
        include_once($template_path);
    } else {
        echo 'SSO Form template file not found.';
    }
}

function wpdocs_render_ebakim_add_healthcare()
{
    global $wpdb;

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        $patient_id = isset($_POST['id']) ? intval($_POST['id']) : 0;
        unset($_POST['id']);
        unset($_POST['action']);
        unset($_POST['submit']);

        $table_name = $wpdb->prefix . 'eb_patients';

        // Serialize the data to store in the healthcare_details column
        $serialized_data = maybe_serialize(($_POST));
        // Update the database
        $updated = $wpdb->update(
            $table_name,
            array('healthcare_details' => $serialized_data),
            array('id' => $patient_id),
            array('%s'),
            array('%d')
        );

        if ($updated !== false) {
            // Redirect after successful update
            $redirect_url = admin_url('admin.php?page=ebakim-list-patient');
            wp_redirect($redirect_url);
            exit;
        } else {
            echo "Database update failed."; // For debugging purposes
        }
    }


    // Render your SSO form HTML here
    $template_path = plugin_dir_path(__FILE__) . 'src/views/wpdocs_render_add_healthcare.php';
    if (file_exists($template_path)) {
        include_once($template_path);
    } else {
        echo 'SSO Form template file not found.';
    }
}



add_action('admin_post_ebakim_add_sso', 'wpdocs_render_ebakim_add_sso');
add_action('admin_post_ebakim_add_healthcare', 'wpdocs_render_ebakim_add_healthcare');



function enqueue_custom_admin_css() {
    wp_enqueue_style('custom-admin-css', plugin_dir_url(__FILE__) . 'custom-css-file-master.css');
}
add_action('admin_enqueue_scripts', 'enqueue_custom_admin_css');