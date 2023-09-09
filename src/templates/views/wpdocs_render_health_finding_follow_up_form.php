<?php defined('WPINC') || exit; ?>
<?php include((dirname(__FILE__) . '/../') . 'header.php'); 
    global $wpdb;
    $health_finding = $wpdb->prefix . 'eb_health_finding';
    $data = $wpdb->get_results("SELECT * FROM $health_finding");









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


    <table class="wp-list-table widefat plugins this_datatable">
        <thead class="dark">
            <tr>
                <th scope="col" class="manage-column column-patientID"><?php _e('History', 'ebakim-wp'); ?></th>
                <th scope="col" class="manage-column column-patientFullName"><?php _e('Moment', 'ebakim-wp'); ?></th>
                <th scope="col" class="manage-column column-patientBirthDate"><?php _e('Fever °C', 'ebakim-wp'); ?></th>
                <th scope="col" class="manage-column column-patientTcNumber"><?php _e('Nabiz', 'ebakim-wp'); ?></th>
                <th scope="col" class="manage-column column-clinicAcceptanceDate"><?php _e('High/Low Blood Pressure', 'ebakim-wp'); ?></th>
                <th scope="col" class="manage-column column-actions"><?php _e('SPO2%', 'ebakim-wp'); ?></th>
                <th scope="col" class="manage-column column-actions"><?php _e('Health personnel', 'ebakim-wp'); ?></th>
            </tr>
        </thead>
        <tbody>
        <?php
        // Assuming $data is an array of rows from your database query
        foreach ($data as $row) {
            echo '<tr>';
            echo '<td>' . esc_html($row->history) . '</td>';
            echo '<td>' . esc_html($row->moment) . '</td>';
            echo '<td>' . esc_html($row->fever) . '</td>';
            echo '<td>' . esc_html($row->nabiz) . '</td>';
            echo '<td>' . esc_html($row->blood_pressure) . '</td>';
            echo '<td>' . esc_html($row->spo2) . '</td>';
            echo '<td>' . esc_html($row->health_personnel) . '</td>';
            echo '</tr>';
        }
        ?>

        </tbody>
    </table>
    <div class="main-head" style="display: flex;flex-direction: column;gap: 10px;width: 300px;">
        <a href=""><button class="button">Download PDF</button></a>
        <a href=""><button class="button">Download all as PDF</button></a>



        <form enctype="multipart/form-data" method="POST" action="<?php echo admin_url('admin-post.php'); ?>">
            <input type="hidden" name="action" value="ebakim_add_health_finding_follow_up_form">

            <p>
                <strong style="display: table; margin-bottom: 5px"><?php echo __('History', 'ebakim-wp'); ?></strong>
                <input required type="text" class="widefat" placeholder="GG/AA/YYYY" name="history" value="">
                <span class="error-message"></span>
            </p>
            <p>
                <strong style="display: table; margin-bottom: 5px"><?php echo __('Moment', 'ebakim-wp'); ?></strong>
                <input required type="text" class="widefat" placeholder="00:00" name="moment" value="">
                <span class="error-message"></span>
            </p>
            <p>
                <strong style="display: table; margin-bottom: 5px"><?php echo __('Fever °C', 'ebakim-wp'); ?></strong>
                <input required type="text" class="widefat" name="fever" placeholder="36,5" value="">
                <span class="error-message"></span>
            </p>
            <p>
                <strong style="display: table; margin-bottom: 5px"><?php echo __('Nabiz', 'ebakim-wp'); ?></strong>
                <input required type="text" class="widefat" name="nabiz" placeholder="100" value="">
                <span class="error-message"></span>
            </p>
            <p>
                <strong style="display: table; margin-bottom: 5px"><?php echo __('High/Low Blood Pressure', 'ebakim-wp'); ?></strong>
                <input required type="text" class="widefat" name="blood_pressure" placeholder="120/80" value="">
                <span class="error-message"></span>
            </p>
            <p>
                <strong style="display: table; margin-bottom: 5px"><?php echo __('SPO2%', 'ebakim-wp'); ?></strong>
                <input required type="text" class="widefat" name="spo2" placeholder="97" value="">
                <span class="error-message"></span>
            </p>
            <p>
                <strong style="display: table; margin-bottom: 5px"><?php echo __('Health personnel', 'ebakim-wp'); ?></strong>
                <select class="widefat" name="health_personnel">
                    <option value="John Doe (Healthcare personnel)">John Doe (Healthcare personnel)</option>
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