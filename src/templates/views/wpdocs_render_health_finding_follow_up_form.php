<?php defined('WPINC') || exit; ?>
<?php include((dirname(__FILE__) . '/../') . 'header.php');
global $wpdb;
$health_finding = $wpdb->prefix . 'eb_health_finding';
$data = $wpdb->get_results("
    SELECT {$health_finding}.id AS health_finding_id, wp_users.id AS user_id, {$health_finding}.*, wp_users.*
    FROM {$health_finding}
    INNER JOIN wp_users ON {$health_finding}.health_personnel = wp_users.id
    ", ARRAY_A);






?>
<style>
    .wp-justify {
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .main-head input,
    .main-head button {
        width: 100%;
    }
</style>
<div class="wrap">
    <div style="display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;margin-bottom:.55rem">
        <h1 style="padding:9px 9px 9px 0"><?php _e('Follow up health findings', 'ebakim-wp'); ?></h1>
    </div>


    <table class="wp-list-table widefat plugins this_datatable_30_show">
        <thead class="dark">
            <tr>
                <th scope="col" class="manage-column column-patientID">#</th>
                <th scope="col" class="manage-column column-patientID"><?php _e('Date', 'ebakim-wp'); ?></th>
                <th scope="col" class="manage-column column-patientFullName"><?php _e('Moment', 'ebakim-wp'); ?></th>
                <th scope="col" class="manage-column column-patientBirthDate"><?php _e('Fever °C', 'ebakim-wp'); ?></th>
                <th scope="col" class="manage-column column-patientTcNumber"><?php _e('Pulse', 'ebakim-wp'); ?></th>
                <th scope="col" class="manage-column column-clinicAcceptanceDate"><?php _e('High/Low Blood Pressure', 'ebakim-wp'); ?></th>
                <th scope="col" class="manage-column column-actions"><?php _e('SPO2%', 'ebakim-wp'); ?></th>
                <th scope="col" class="manage-column column-actions"><?php _e('Health personnel', 'ebakim-wp'); ?></th>
                <th scope="col" class="manage-column column-actions"><?php _e('Action', 'ebakim-wp'); ?></th>
            </tr>
        </thead>
        <tbody>
            <?php
            // Assuming $data is an array of rows from your database query
            foreach ($data as $key => $row) {
                $custom_signature_url = get_user_meta($row['user_id'], 'custom_signature', true);
                if (!empty($custom_signature_url)) {
                    $signature = esc_url($custom_signature_url);
                } else {
                    $signature = '';
                }


                $first_name = get_user_meta($row['user_id'], 'first_name', true);
                if ($first_name) {
                    $last_name = get_user_meta($row['user_id'], 'last_name', true);
                    $name_of_health_care_person = $first_name . ' ' . $last_name;
                } else {
                    $name_of_health_care_person = get_userdata($row['user_id'])->user_login;
                }

                echo '<tr>';
                echo '<td>' . esc_html($key + 1) . '</td>';
                echo '<td>' . esc_html($row['history'] ? $row['history'] : '-') . '</td>';
                echo '<td>' . esc_html($row['moment'] ? $row['moment'] : '-') . '</td>';
                echo '<td>' . esc_html($row['fever'] ? $row['fever'] : '-') . '</td>';
                echo '<td>' . esc_html($row['nabiz'] ? $row['nabiz'] : '-') . '</td>';
                echo '<td>' . esc_html($row['blood_pressure'] ? $row['blood_pressure'] : '-') . '</td>';
                echo '<td>' . esc_html($row['spo2'] ? $row['spo2'] : '-') . '</td>';
                echo '<td style="">
                    <div style="gap: 5px;display: flex;align-items: center;">' . $name_of_health_care_person . ' ' . ($signature ? '<img style="width:50px; height:40px" src="' . $signature . '" />' : '') . '</div>
                </td>';
                echo '<td style="display:flex; gap:10px;">
                        <a href="' . admin_url('admin.php?page=ebakim-patient_health_finding&id=' . $row['id']) . '" class="button">' . __('View', 'ebakim-wp') . '</a>
                        <a href="' . admin_url('admin-post.php?action=delete_patient_health_finding&id=' . $row['id']) . '" class="button button-danger delete_health_care">' . __('Delete', 'ebakim-wp') . '</a>
                    </td>';
                echo '</tr>';
            }
            ?>

        </tbody>
    </table>
    <div class="main-head" style="display: flex;flex-direction: column;gap: 10px;width: 300px;">
        <a href=""><button class="button">Download PDF</button></a>
        <a href="<?php echo admin_url('admin-ajax.php?action=download_healthcare_all_pdf') ?>"><button class="button">Download all as PDF</button></a>



        <form enctype="multipart/form-data" method="POST" action="<?php echo admin_url('admin-post.php'); ?>">
            <input type="hidden" name="action" value="ebakim_add_health_finding_follow_up_form">

            <p>
                <strong style="display: table; margin-bottom: 5px"><?php echo __('Date', 'ebakim-wp'); ?></strong>
                <input type="text" class="widefat flatpicker_this" placeholder="<?php echo __('DD/MM/YYYY', 'ebakim-wp'); ?>" name="history" value="">

                <span class="error-message"></span>
            </p>
            <p>
                <strong style="display: table; margin-bottom: 5px"><?php echo __('Moment', 'ebakim-wp'); ?></strong>
                <input type="text" class="widefat" placeholder="00:00" name="moment" value="">
                <span class="error-message"></span>
            </p>
            <p>
                <strong style="display: table; margin-bottom: 5px"><?php echo __('Fever °C', 'ebakim-wp'); ?></strong>
                <input type="text" class="widefat" name="fever" placeholder="36,5" value="">
                <span class="error-message"></span>
            </p>
            <p>
                <strong style="display: table; margin-bottom: 5px"><?php echo __('Pulse', 'ebakim-wp'); ?></strong>
                <input type="text" class="widefat" name="nabiz" placeholder="100" value="">
                <span class="error-message"></span>
            </p>
            <p>
                <strong style="display: table; margin-bottom: 5px"><?php echo __('High/Low Blood Pressure', 'ebakim-wp'); ?></strong>
                <input type="text" class="widefat" name="blood_pressure" placeholder="120/80" value="">
                <span class="error-message"></span>
            </p>
            <p>
                <strong style="display: table; margin-bottom: 5px"><?php echo __('SPO2%', 'ebakim-wp'); ?></strong>
                <input type="text" class="widefat" name="spo2" placeholder="97" value="">
                <span class="error-message"></span>
            </p>
            <p>
                <strong style="display: table; margin-bottom: 5px"><?php echo __('Health personnel', 'ebakim-wp'); ?></strong>
                <select class="widefat" name="health_personnel">
                    <?php
                    $all_patients = get_all_users();
                    $current_user_id = get_current_user_id();

                    foreach ($all_patients as $patient) {
                        $user_id = $patient->ID;
                        $first_name = get_user_meta($user_id, 'first_name', true);
                        $last_name = get_user_meta($user_id, 'last_name', true);

                        if (!empty($first_name)) {
                            $name = $first_name . ' ' . $last_name;
                        } else {
                            $name = get_userdata($user_id)->user_login;
                        }

                        $selected = ($user_id == $current_user_id) ? 'selected' : '';

                        echo '<option value="' . $user_id . '" ' . $selected . '>' . $name . '</option>';
                    }
                    ?>
                </select>

                <span class="error-message"></span>
            </p>
            <button type="submit" class="button button-primary">Add</button>
        </form>
    </div>


</div>
<?php include((dirname(__FILE__) . '/../') . 'footer.php'); ?>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/xlsx@0.17.5/dist/xlsx.full.min.js"></script>

<script>

    $(document).on("click", ".delete_health_care", function(e) {
        e.preventDefault();

        // Show a confirmation dialog
        if (confirm("Are you sure you want to delete this item?")) {
            let href = $(this).attr('href');
            window.location.href = href;
        }
    });


    var columns = {};
    document.addEventListener("DOMContentLoaded", function() {
        const excelUploadForm = document.getElementById("upload_file");
        const columnMappingDiv = document.getElementById("column-mapping");
        const columnMapForm = document.getElementById("column-map-form");
        const columnDropdowns = columnMapForm.querySelectorAll(".column-dropdown");

        excelUploadForm.addEventListener("click", function(event) {
            event.preventDefault();

            const excelFileInput = document.querySelector('input[name="excel_file"]');
            const file = excelFileInput.files[0];

            if (file) {
                let main_header = [];
                const reader = new FileReader();

                reader.onload = function(e) {
                    const data = new Uint8Array(e.target.result);
                    const workbook = XLSX.read(data, {
                        type: 'array'
                    });
                    const sheetName = workbook.SheetNames[0];
                    const worksheet = workbook.Sheets[sheetName];

                    const firstRowData = {};

                    for (const cellAddress in worksheet) {
                        const col = cellAddress.replace(/[0-9]/g, '');
                        const row = parseInt(cellAddress.replace(/[A-Z]/gi, ''), 10);

                        if (!columns[col]) columns[col] = [];

                        const cellValue = worksheet[cellAddress].v;

                        if (cellValue) {
                            if (row == 1) {
                                main_header.push(cellValue);
                            } else {
                                columns[col].push(cellValue);

                                if (!firstRowData[col]) {
                                    firstRowData[col] = cellValue;
                                }
                            }
                        }
                    }

                    let all_options = '';
                    let key_count = 0;

                    for (let col in firstRowData) {
                        let columnLabel = main_header[key_count];
                        key_count++;
                        all_options += '<option value="' + col + '">' + columnLabel + '</option>';
                    }

                    columnDropdowns.forEach((dropdown, index) => {
                        let select = $(dropdown);
                        select.append(all_options);
                        select.children('option').eq(index).prop('selected', true);
                    });

                    columnMappingDiv.style.display = "block";
                };

                reader.readAsArrayBuffer(file);
            }
        });
    });
</script>