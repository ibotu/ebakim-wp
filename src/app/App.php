<?php

if (!defined('WPINC')) {
    exit; // direct access
}

require_once dirname(plugin_dir_path(__FILE__)) . '/vendor/autoload.php';
require_once dirname(plugin_dir_path(__FILE__)) . '/utils/helpers/helper.php';
require_once dirname(plugin_dir_path(__FILE__)) . '/utils/PHPGangsta/GoogleAuthenticator.php';





function wpdocs_render_patient()
{
    $template_path = dirname(plugin_dir_path(__FILE__)) . '/templates/views/wpdocs_render_patient.php';
    if (file_exists($template_path)) {
        include_once($template_path);
    } else {
        echo 'Template file not found.';
    }
}
function wpdocs_render_list_patient()
{
    $template_path = dirname(plugin_dir_path(__FILE__)) . '/templates/views/wpdocs_render_list_patient.php';
    if (file_exists($template_path)) {
        include_once($template_path);
    } else {
        echo 'Template file not found.';
    }
}

function my_plugin_load_textdomain()
{
    $translation_file = dirname(dirname(dirname(plugin_basename(__FILE__)))) . '/languages/';
    $loaded = load_plugin_textdomain('ebakim-wp', false, $translation_file);
    if ($loaded) {
        // Translation domain loaded successfully.
        // dd('Translation domain loaded successfully.');
    } else {
        // Translation domain failed to load.
        // $error_message = 'Translation domain failed to load. File: ' . $translation_file;
        // wp_die($error_message, 'Translation Domain Error');
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


    $template_path = dirname(plugin_dir_path(__FILE__)) . '/templates/views/wpdocs_render_import_patient.php';
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

    $template_path = dirname(plugin_dir_path(__FILE__)) . '/templates/views/wpdocs_render_add_edit_patient.php';
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

function wpdocs_render_delete_patient_health_finding()
{
    if (isset($_GET['id']) && is_numeric($_GET['id'])) {
        $id = intval($_GET['id']);

        // Perform the deletion operation
        global $wpdb;
        $table_name = $wpdb->prefix . 'eb_health_finding';

        $wpdb->delete($table_name, array('id' => $id));

        // Redirect back to the list patient page after deletion
        $redirect_url = admin_url('admin.php?page=ebakim-health-finding-follow-up-form');
        wp_redirect($redirect_url);
        exit; // Always exit after a redirect
    }
}
function wpdocs_render_patient_health_finding()
{
    $template_path = dirname(plugin_dir_path(__FILE__)) . '/templates/views/wpdocs_render_patient_health_finding.php';
    if (file_exists($template_path)) {
        include_once($template_path);
    } else {
        echo 'Template file not found.';
    }
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
    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');


    global $wpdb;


    dbDelta("CREATE TABLE IF NOT EXISTS {($wpdb->prefix . 'eb_patients')} (
        `id` bigint(20) unsigned not null auto_increment,
        `_created` datetime,
        `_edited` datetime,
        `status` varchar(250),
        `patientID` varchar(250),
        `patientFullName` varchar(250),
        `patientBirthDate` datetime,
        `patientTcNumber` varchar(250),
        `clinicAcceptanceDate` datetime,
        `clinicPlacementType` varchar(250),
        `clinicPlacementStatus` varchar(250),
        `clinicEndDate` datetime,
        `clinicLifePlanDate` datetime,
        `clinicEskrDate` datetime,
        `clinicGuardianDate` datetime,
        `sso_details` text,
        `healthcare_details` text,
        `clinicAllowanceStatus` varchar(250),
        `picture` text,
        primary key(`id`)
    ) {$wpdb->get_charset_collate()};");


    dbDelta("CREATE TABLE IF NOT EXISTS {$wpdb->prefix}eb_health_finding (
        `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
        `history` varchar(250),             -- History field
        `moment` varchar(250),             -- Moment field
        `fever` varchar(250),              -- Fever °C field
        `nabiz` varchar(250),              -- Nabiz field
        `blood_pressure` varchar(250),     -- High/Low Blood Pressure field
        `spo2` varchar(250),               -- SPO2% field
        `health_personnel` varchar(250),   -- Health personnel field
        PRIMARY KEY (`id`)
    ) {$wpdb->get_charset_collate()};");









    // Create the main "eBakim" menu item
    add_menu_page(
        __('eBakim', 'ebakim-wp'),      // Main menu title
        __('eBakim', 'ebakim-wp'),      // Actual page title
        'manage_options',               // Required capability to access the menu
        'ebakim-main',                  // Menu slug
        'wpdocs_render_main_patients',  // Callback function to render the main page
        'dashicons-admin-plugins',      // Dashicon for the menu
        6                               // Menu position
    );

    // Add modules under "eBakim"
    add_submenu_page(
        'ebakim-main',                   // Parent menu slug
        __('Patients', 'ebakim-wp'),    // Submenu page title
        __('Patients', 'ebakim-wp'),    // Submenu menu title
        'manage_options',                // Required capability to access the submenu
        'ebakim-patients',               // Submenu slug
        'wpdocs_render_patient'     // Callback function to render the submodule
    );

    add_submenu_page(
        'ebakim-main',                   // Parent menu slug
        __('Groups', 'ebakim-wp'),      // Submenu page title
        __('Groups', 'ebakim-wp'),      // Submenu menu title
        'manage_options',                // Required capability to access the submenu
        'ebakim-groups',                 // Submenu slug
        'wpdocs_render_groups'           // Callback function to render the submodule
    );

    add_submenu_page(
        'ebakim-main',                   // Parent menu slug
        __('Employee', 'ebakim-wp'),    // Submenu page title
        __('Employee', 'ebakim-wp'),    // Submenu menu title
        'manage_options',                // Required capability to access the submenu
        'ebakim-employee',               // Submenu slug
        'wpdocs_render_employee'         // Callback function to render the submodule
    );

    add_submenu_page(
        'ebakim-main',                   // Parent menu slug
        __('Payments', 'ebakim-wp'),    // Submenu page title
        __('Payments', 'ebakim-wp'),    // Submenu menu title
        'manage_options',                // Required capability to access the submenu
        'ebakim-payments',               // Submenu slug
        'wpdocs_render_payments'         // Callback function to render the submodule
    );

    add_submenu_page(
        'ebakim-main',                   // Parent menu slug
        __('Transitions', 'ebakim-wp'), // Submenu page title
        __('Transitions', 'ebakim-wp'), // Submenu menu title
        'manage_options',                // Required capability to access the submenu
        'ebakim-transitions',            // Submenu slug
        'wpdocs_render_transitions'      // Callback function to render the submodule
    );

    // Add child submenu items under "Patients"
    add_submenu_page(
        'ebakim-patients',                // Parent menu slug
        __('List Patient', 'ebakim-wp'),  // Submenu page title
        __('List Patient', 'ebakim-wp'),  // Submenu menu title
        'manage_options',                 // Required capability to access the submenu
        'ebakim-list-patient',            // Submenu slug
        'wpdocs_render_list_patient'      // Callback function to render the submenu
    );

    add_submenu_page(
        'ebakim-patients',                // Parent menu slug
        __('New Patient', 'ebakim-wp'),   // Submenu page title
        __('New Patient', 'ebakim-wp'),   // Submenu menu title
        'manage_options',                 // Required capability to access the submenu
        'ebakim-add-patient',            // Submenu slug
        'wpdocs_render_add_patient'       // Callback function to render the submenu
    );

    add_submenu_page(
        'ebakim-patients',                // Parent menu slug
        __('Import Patient', 'ebakim-wp'), // Submenu page title
        __('Import Patient', 'ebakim-wp'), // Submenu menu title
        'manage_options',                 // Required capability to access the submenu
        'ebakim-import-patient',         // Submenu slug
        'wpdocs_render_import_patient'    // Callback function to render the submenu
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

    add_submenu_page(
        'ebakim-patients',                // Parent menu slug
        __('Health Finding Form', 'ebakim-wp'),  // Submenu page title
        __('Health Finding Form', 'ebakim-wp'),  // Submenu menu title
        'manage_options',                 // Required capability to access the submenu
        'ebakim-health-finding-follow-up-form',            // Submenu slug
        'wpdocs_render_health_finding_follow_up_form'      // Callback function to render the submenu
    );
    add_submenu_page(
        'ebakim-patients',                // Parent menu slug
        __('Health Finding Details', 'ebakim-wp'),  // Submenu page title
        __('Health Finding Details', 'ebakim-wp'),  // Submenu menu title
        'manage_options',                 // Required capability to access the submenu
        'ebakim-patient_health_finding',            // Submenu slug
        'wpdocs_render_patient_health_finding'      // Callback function to render the submenu
    );



    remove_submenu_page('ebakim-main', 'ebakim-main');
    remove_submenu_page('ebakim-patients', 'ebakim-patient_health_finding');
}


add_action('show_user_profile', 'my_custom_profile_image_field');
add_action('edit_user_profile', 'my_custom_profile_image_field');
add_action('personal_options_update', 'save_my_custom_profile_image_field');
add_action('edit_user_profile_update', 'save_my_custom_profile_image_field');

add_action('plugins_loaded', 'my_plugin_load_textdomain');
add_action('admin_menu', 'main');
add_action('admin_post_add_patient', 'wpdocs_render_add_patient');
add_action('admin_post_edit_patient', 'wpdocs_render_edit_patient');
add_action('admin_post_delete_patient', 'wpdocs_render_delete_patient');
add_action('admin_post_delete_patient_health_finding', 'wpdocs_render_delete_patient_health_finding');
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
            $auth_url = plugins_url('templates/views/wp-2fa-auth.php', dirname(__FILE__));
            wp_redirect($auth_url);
            exit;
        } else {
            $setup_url = plugins_url('templates/views/wp-2fa-setup.php', dirname(__FILE__));
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






function wpdocs_render_health_finding_follow_up_form()
{
    global $wpdb;

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        unset($_POST['action']);

        // Define the table name
        $table_name = $wpdb->prefix . 'eb_health_finding';

        // Prepare the data to be inserted
        $data_to_insert = array(
            'history' => sanitize_text_field($_POST['history']),
            'moment' => sanitize_text_field($_POST['moment']),
            'fever' => sanitize_text_field($_POST['fever']),
            'nabiz' => sanitize_text_field($_POST['nabiz']),
            'blood_pressure' => sanitize_text_field($_POST['blood_pressure']),
            'spo2' => sanitize_text_field($_POST['spo2']),
            'health_personnel' => sanitize_text_field($_POST['health_personnel']),
        );

        $wpdb->insert($table_name, $data_to_insert);

        // Check if the insertion was successful
        if ($wpdb->last_error) {
            // Handle the error, if any

            dd("Error: " . $wpdb->last_error);
        } else {
            $redirect_url = admin_url('admin.php?page=ebakim-health-finding-follow-up-form');
            wp_redirect($redirect_url);
        }
    }


    $template_path = dirname(plugin_dir_path(__FILE__)) . '/templates/views/wpdocs_render_health_finding_follow_up_form.php';
    if (file_exists($template_path)) {
        include_once($template_path);
    } else {
        echo 'SSO Form template file not found.';
    }
}






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
    $template_path = dirname(plugin_dir_path(__FILE__)) . '/templates/views/wpdocs_render_add_sso.php';
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
        unset($_POST['action']);

        $table_name = $wpdb->prefix . 'eb_health_finding';

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
    $template_path = dirname(plugin_dir_path(__FILE__)) . '/templates/views/wpdocs_render_add_healthcare.php';
    if (file_exists($template_path)) {
        include_once($template_path);
    } else {
        echo 'SSO Form template file not found.';
    }
}



add_action('admin_post_ebakim_add_sso', 'wpdocs_render_ebakim_add_sso');
add_action('admin_post_ebakim_add_healthcare', 'wpdocs_render_ebakim_add_healthcare');
add_action('admin_post_ebakim_add_health_finding_follow_up_form', 'wpdocs_render_health_finding_follow_up_form');



function enqueue_custom_admin_css()
{

    wp_enqueue_style('custom-admin-css', plugins_url('../assets/custom-css-file-master.css', __FILE__));
}
add_action('admin_enqueue_scripts', 'enqueue_custom_admin_css');

function enqueue_custom_admin_scripts()
{
    // Enqueue your JavaScript file
    wp_enqueue_script('hammad-js', plugins_url('../assets/load_js.js', __FILE__), array('jquery'), '1.0', true);
}

add_action('admin_enqueue_scripts', 'enqueue_custom_admin_scripts');












// Function to add the image upload field to the user profile
function my_custom_profile_image_field($user)
{
?>
    <h3><?php esc_html_e('Signature', 'ebakim-wp'); ?></h3>
    <table class="form-table">
        <tr>
            <th><label for="custom_signature"><?php esc_html_e('Health Findings Follow-up Form Signature', 'ebakim-wp'); ?></label></th>
            <td>
                <input type="file" id="custom_signature" name="custom_signature" accept="image/*" />
                <br />
                <?php
                $custom_signature = get_user_meta($user->ID, 'custom_signature', true);
                if ($custom_signature) {
                    echo '<img src="' . esc_url($custom_signature) . '" style="max-width: 100px;" /><br />';
                    echo '<span class="description">' . esc_html_e('Current signature:', 'ebakim-wp') . '</span>';
                }
                ?>
            </td>
        </tr>
    </table>
<?php
}

// Function to save the uploaded image as user_meta
function save_my_custom_profile_image_field($user_id)
{
    if (current_user_can('edit_user', $user_id)) {

        $custom_signature = $_FILES['custom_signature'];

        if (!empty($custom_signature['name'])) {
            $upload_overrides = array('test_form' => false);
            $upload_result = wp_handle_upload($custom_signature, $upload_overrides);

            if (!empty($upload_result['url'])) {
                update_user_meta($user_id, 'custom_signature', $upload_result['url']);
            }
        }
    }
}

// Add actions for displaying and saving the image field
add_action('show_user_profile', 'my_custom_profile_image_field');
add_action('edit_user_profile', 'my_custom_profile_image_field');
add_action('personal_options_update', 'save_my_custom_profile_image_field');
add_action('edit_user_profile_update', 'save_my_custom_profile_image_field');



function enqueue_jquery()
{
    wp_enqueue_script('jquery');
}

add_action('wp_enqueue_scripts', 'enqueue_jquery');


function download_healthcare_all_pdf()
{


    global $wpdb;
    $health_finding = $wpdb->prefix . 'eb_health_finding';
    $data = $wpdb->get_results("
        SELECT {$health_finding}.id AS health_finding_id, wp_users.id AS user_id, {$health_finding}.*, wp_users.*
        FROM {$health_finding}
        INNER JOIN wp_users ON {$health_finding}.health_personnel = wp_users.id
    ", ARRAY_A);



    $html = ' 
<table style="border-collapse:collapse;margin-left:5.57pt; width:100%;" cellspacing="0">
    <tr style="height:14pt ">
        <td style="width:88pt;border-top-style:solid;border-top-width:1pt;border-left-style:solid;border-left-width:1pt;border-bottom-style:solid;border-bottom-width:1pt;border-right-style:solid;border-right-width:1pt"
            rowspan="4"><img style="height:80px; width:120px;" src="'. plugins_url('/ebakim-wp/src/assets/images/logo-head.png') .'"/>              
        </td>
        <td style=" font-family:arial; font-size:24px; text-align:center; width:288pt;border-top-style:solid;border-top-width:1pt;border-left-style:solid;border-left-width:1pt;border-bottom-style:solid;border-bottom-width:1pt;border-right-style:solid;border-right-width:1pt"
            rowspan="4">
            <p class="s1" style="padding-left: 20pt;text-indent: 0pt;text-align: left;"> ' . __(' Health Findings Follow-up Form', 'ebakim-wp') . '
            </p>
        </td>
        <td
            style="width:110pt;border-top-style:solid;border-top-width:1pt;border-left-style:solid;border-left-width:1pt;border-bottom-style:solid;border-bottom-width:1pt;border-right-style:solid;border-right-width:1pt">
            <p class="s2" style="padding-left: 5pt;text-indent: 0pt;line-height: 12pt;text-align: left;">' . __('Document code', 'ebakim-wp') . '</p>
        </td>
        <td
            style="width:64pt;border-top-style:solid;border-top-width:1pt;border-left-style:solid;border-left-width:1pt;border-bottom-style:solid;border-bottom-width:1pt;border-right-style:solid;border-right-width:1pt">
            <p class="s2" style="padding-left: 5pt;text-indent: 0pt;line-height: 12pt;text-align: left;">FRM.27</p>
        </td>
    </tr>
    <tr style="height:14pt">
        <td
            style="width:110pt;border-top-style:solid;border-top-width:1pt;border-left-style:solid;border-left-width:1pt;border-bottom-style:solid;border-bottom-width:1pt;border-right-style:solid;border-right-width:1pt">
            <p class="s2" style="padding-left: 5pt;text-indent: 0pt;line-height: 12pt;text-align: left;">' . __('Release date', 'ebakim-wp') . '</p>
        </td>
        <td
            style="width:64pt;border-top-style:solid;border-top-width:1pt;border-left-style:solid;border-left-width:1pt;border-bottom-style:solid;border-bottom-width:1pt;border-right-style:solid;border-right-width:1pt">
            <p class="s2" style="padding-left: 5pt;text-indent: 0pt;line-height: 12pt;text-align: left;">01.03.2021
            </p>
        </td>
    </tr>
    <tr style="height:14pt">
        <td
            style="width:110pt;border-top-style:solid;border-top-width:1pt;border-left-style:solid;border-left-width:1pt;border-bottom-style:solid;border-bottom-width:1pt;border-right-style:solid;border-right-width:1pt">
            <p class="s2" style="padding-left: 5pt;text-indent: 0pt;line-height: 12pt;text-align: left;">' . __('Revision date', 'ebakim-wp') . '</p>
        </td>
        <td
            style="width:64pt;border-top-style:solid;border-top-width:1pt;border-left-style:solid;border-left-width:1pt;border-bottom-style:solid;border-bottom-width:1pt;border-right-style:solid;border-right-width:1pt">
            <p class="s2" style="padding-left: 5pt;text-indent: 0pt;line-height: 12pt;text-align: left;">--</p>
        </td>
    </tr>
    <tr style="height:14pt">
        <td
            style="width:110pt;border-top-style:solid;border-top-width:1pt;border-left-style:solid;border-left-width:1pt;border-bottom-style:solid;border-bottom-width:1pt;border-right-style:solid;border-right-width:1pt">
            <p class="s2" style="padding-left: 5pt;text-indent: 0pt;line-height: 12pt;text-align: left;">' . __('Revision Number', 'ebakim-wp') . '</p>
        </td>
        <td
            style="width:64pt;border-top-style:solid;border-top-width:1pt;border-left-style:solid;border-left-width:1pt;border-bottom-style:solid;border-bottom-width:1pt;border-right-style:solid;border-right-width:1pt">
            <p class="s2" style="padding-left: 5pt;text-indent: 0pt;line-height: 12pt;text-align: left;">00</p>
        </td>
    </tr>
</table>
<br>
<table style="border-collapse:collapse;margin-left:5.57pt; width:100%;" cellspacing="0">
    <tr style="height:38pt">
        <td style="padding-left:10px; width:40%;border-top-style:solid;border-top-width:1pt;border-left-style:solid;border-left-width:1pt;border-bottom-style:solid;border-bottom-width:1pt;border-right-style:solid;border-right-width:1pt"bgcolor="#C2D69B">
           <b>Name and Surname of Patient</b>
        </td>
        <td style=" text-align:center; padding:5px; width:60%;border-top-style:solid;border-top-width:1pt;border-left-style:solid;border-left-width:1pt;border-bottom-style:solid;border-bottom-width:1pt;border-right-style:solid;border-right-width:1pt">
           <b>Name and Surname of Patient</b>
        </td>
       
    </tr>
    </table>
    <br>

<table style="border-collapse:collapse;margin-left:5.57pt; width:100%;" cellspacing="0">
    <tr style="height:38pt">
        <td style=" text-align:center; padding:5px; width:78pt;border-top-style:solid;border-top-width:1pt;border-left-style:solid;border-left-width:1pt;border-bottom-style:solid;border-bottom-width:1pt;border-right-style:solid;border-right-width:1pt"
            bgcolor="#C2D69B">
            <p style="text-indent: 0pt;text-align: left;"><br /></p>
              <b><p class="s3" style="padding-left: 26pt;padding-right: 25pt;text-indent: 0pt;text-align: center;">' . __('History', 'ebakim-wp') . '</p></b>
        </td>
        <td style=" text-align:center; padding:5px; width:49pt;border-top-style:solid;border-top-width:1pt;border-left-style:solid;border-left-width:1pt;border-bottom-style:solid;border-bottom-width:1pt;border-right-style:solid;border-right-width:1pt"
            bgcolor="#C2D69B">
            <p style="text-indent: 0pt;text-align: left;"><br /></p>
         
             <b><p class="s3" style="padding-left: 14pt;text-indent: 0pt;text-align: left;">' . __('Moment', 'ebakim-wp') . '</p></b>
        </td>
        <td style=" text-align:center; padding:5px; width:56pt;border-top-style:solid;border-top-width:1pt;border-left-style:solid;border-left-width:1pt;border-bottom-style:solid;border-bottom-width:1pt;border-right-style:solid;border-right-width:1pt"
            bgcolor="#C2D69B">
            <p style="text-indent: 0pt;text-align: left;"><br /></p>
              <b><p class="s3" style="padding-left: 18pt;text-indent: 0pt;text-align: left;">' . __('Fever °C', 'ebakim-wp') . '</p></b>
        </td>
        <td style=" text-align:center; padding:5px; width:57pt;border-top-style:solid;border-top-width:1pt;border-left-style:solid;border-left-width:1pt;border-bottom-style:solid;border-bottom-width:1pt;border-right-style:solid;border-right-width:1pt"
            bgcolor="#C2D69B">
            <p style="text-indent: 0pt;text-align: left;"><br /></p>
              <b><p class="s3" style="padding-left: 15pt;text-indent: 0pt;text-align: left;">' . __('Pulse', 'ebakim-wp') . '</p></b>
        </td>
        <td style=" text-align:center; padding:5px; width:106pt;border-top-style:solid;border-top-width:1pt;border-left-style:solid;border-left-width:1pt;border-bottom-style:solid;border-bottom-width:1pt;border-right-style:solid;border-right-width:1pt"
            bgcolor="#C2D69B">
            <p style="text-indent: 0pt;text-align: left;"><br /></p>
              <b><p class="s3" style="padding-left: 32pt;text-indent: 0pt;text-align: left;">' . __('Blood pressure', 'ebakim-wp') . '</p></b>
        </td>
        <td style=" text-align:center; padding:5px; width:49pt;border-top-style:solid;border-top-width:1pt;border-left-style:solid;border-left-width:1pt;border-bottom-style:solid;border-bottom-width:1pt;border-right-style:solid;border-right-width:1pt"
            bgcolor="#C2D69B">
            <p style="text-indent: 0pt;text-align: left;"><br /></p>
              <b><p class="s3" style="padding-left: 12pt;text-indent: 0pt;text-align: left;">' . __('SPO2', 'ebakim-wp') . '</p></b>
        </td>
        <td style=" text-align:center; padding:5px; width:149pt;border-top-style:solid;border-top-width:1pt;border-left-style:solid;border-left-width:1pt;border-bottom-style:solid;border-bottom-width:1pt;border-right-style:solid;border-right-width:1pt"
            bgcolor="#C2D69B">
            <b>   <p class="s3"
            style="padding-top: 5pt;padding-left: 35pt;padding-right: 24pt;text-indent: 2pt;text-align: left;">' . __('Name and Surname of Health Personnel / Signature', 'ebakim-wp') . '</p></b>
        </td>
    </tr>';

    // echo $html; die();

    

    foreach ($data as $k => $v) {
        $custom_signature_url = get_user_meta($v['user_id'], 'custom_signature', true);
        if (!empty($custom_signature_url)) {
            $signature = esc_url($custom_signature_url);
        } else {
            $signature = '';
        }
    
    
        $first_name = get_user_meta($v['user_id'], 'first_name', true);
        if($first_name){
            $last_name = get_user_meta($v['user_id'], 'last_name', true);
            $name_of_health_care_person = $first_name . ' ' . $last_name;
        }else{
            $name_of_health_care_person = get_userdata($v['user_id'])->user_login;
        }



        $html .= '
        <tr style="height:21pt; ">
        <td
            style=" text-align:center; padding:5px; width:78pt;border-top-style:solid;border-top-width:1pt;border-left-style:solid;border-left-width:1pt;border-bottom-style:solid;border-bottom-width:1pt;border-right-style:solid;border-right-width:1pt">
            <p style="text-indent: 0pt;text-align: left;">' . $v['history'] . '</p>
        </td>
        <td
            style=" text-align:center; padding:5px; width:49pt;border-top-style:solid;border-top-width:1pt;border-left-style:solid;border-left-width:1pt;border-bottom-style:solid;border-bottom-width:1pt;border-right-style:solid;border-right-width:1pt">
            <p style="text-indent: 0pt;text-align: left;">' . $v['moment'] . '</p>
        </td>
        <td
            style=" text-align:center; padding:5px; width:56pt;border-top-style:solid;border-top-width:1pt;border-left-style:solid;border-left-width:1pt;border-bottom-style:solid;border-bottom-width:1pt;border-right-style:solid;border-right-width:1pt">
            <p style="text-indent: 0pt;text-align: left;">' . $v['fever'] . '</p>
        </td>
        <td
            style=" text-align:center; padding:5px; width:57pt;border-top-style:solid;border-top-width:1pt;border-left-style:solid;border-left-width:1pt;border-bottom-style:solid;border-bottom-width:1pt;border-right-style:solid;border-right-width:1pt">
            <p style="text-indent: 0pt;text-align: left;">' . $v['nabiz'] . '</p>
        </td>
        <td
            style=" text-align:center; padding:5px; width:106pt;border-top-style:solid;border-top-width:1pt;border-left-style:solid;border-left-width:1pt;border-bottom-style:solid;border-bottom-width:1pt;border-right-style:solid;border-right-width:1pt">
            <p style="text-indent: 0pt;text-align: left;">' . $v['blood_pressure'] . '</p>
        </td>
        <td
            style=" text-align:center; padding:5px; width:49pt;border-top-style:solid;border-top-width:1pt;border-left-style:solid;border-left-width:1pt;border-bottom-style:solid;border-bottom-width:1pt;border-right-style:solid;border-right-width:1pt">
            <p style="text-indent: 0pt;text-align: left;">' . $v['spo2'] . '</p>
        </td>
        <td
            style="text-align:left; padding:5px; width:149pt;border-top-style:solid;border-top-width:1pt;border-left-style:solid;border-left-width:1pt;border-bottom-style:solid;border-bottom-width:1pt;border-right-style:solid;border-right-width:1pt">
            <div style="display: flex;align-items: center;">
            <p style="margin:0px; padding-bottom:10px;">  '. $name_of_health_care_person . '</p>
            '. ($signature ? '<img style="width:50px; height:40px" src="'. $signature .'" />' : '') .'
            </div>
            </td>
    </tr>';
    }

    $html .= '
    </table>';





    // Include mPDF library
    require_once dirname(plugin_dir_path(__FILE__)) . '\..\vendor\autoload.php';

    // Create a new mPDF instance
    $mpdf = new \Mpdf\Mpdf();


    // Convert HTML to PDF
    $mpdf->WriteHTML($html);

// Set the Content-Disposition header to force download
header('Content-Disposition: attachment; filename="healthcare_report.pdf"');

// Add this line to set the Content-Type header for download
header('Content-Type: application/pdf');

// Output the PDF to the browser
$mpdf->Output();
exit; // Make sure to exit after sending the PDF
}



add_action('wp_ajax_download_healthcare_all_pdf', 'download_healthcare_all_pdf');
