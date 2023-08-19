<?php defined('WPINC') || exit; ?>
<?php
include(__DIR__ . '/../templates/header.php');
?>
<style>
    .wp-justify {
        display: flex;
        align-items: center;
        justify-content: space-between;
    }
</style>
<div class="wrap">
    <div style="display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;margin-bottom:.55rem">
        <h1 style="padding:9px 9px 9px 0"><?php _e('eBakim &lsaquo; Import Patients', 'ebakim-wp'); ?></h1>
    </div>
    <form id="column-map-form" enctype="multipart/form-data" method="POST" action="<?php echo admin_url('admin-post.php'); ?>">

        <div style="width: 200px;background: #e4e4e4;padding: 1px 10px;">
            <p>
                <strong style="display: table; margin-bottom: 5px"><?php echo __('Upload Excel File', 'ebakim-wp'); ?></strong>
                <input required accept=".csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel" type="file" class="widefat" name="excel_file">
            </p>
            <p>
                <input type="button" id="upload_file" class="button button-primary" value="<?php esc_attr_e('Upload File', 'ebakim-wp'); ?>">
            </p>
        </div>

        <div id="column-mapping" style="display: none;">
            <h2><?php echo __('Map Columns', 'ebakim-wp'); ?></h2>
            <div class="row" style="width: 60%;">
                <div class="col-sm-6 col-md-12">
                    <input type="hidden" name="action" value="import_patients" />
                    <?php

                    foreach (patient_fields() as $sample_column) {
                        $formatted_column_name = ucwords(str_replace('_', ' ', $sample_column));
                        echo '<p class="wp-justify">';
                        echo '<strong>' . esc_html($formatted_column_name) . '</strong>';
                        echo '<select required class="widefat column-dropdown" name="patient[' . esc_attr($sample_column) . ']">';
                        echo '<option value="">Select Column</option>'; // Add an empty option
                        echo '</select>';
                        echo '</p>';
                    }
                    ?>
                    <p>
                        <input type="submit" class="button button-primary" value="<?php esc_attr_e('Save Mapping', 'ebakim-wp'); ?>">
                    </p>

                </div>
            </div>
        </div>
    </form>
</div>
<?php include(__DIR__ . '/../templates/footer.php'); ?>
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
                const reader = new FileReader();

                reader.onload = function(e) {
                    const data = new Uint8Array(e.target.result);
                    const workbook = XLSX.read(data, {
                        type: 'array'
                    });
                    const sheetName = workbook.SheetNames[0];
                    const worksheet = workbook.Sheets[sheetName];


                    const firstRowData = {}; // Object to store the first row data

                    let isHeaderRow = true; // Flag to identify header row

                    for (const cellAddress in worksheet) {
                        if (cellAddress[0] === '!') continue; // Skip non-cell keys

                        const col = cellAddress.replace(/[0-9]/g, '');
                        const row = parseInt(cellAddress.replace(/[A-Z]/gi, ''), 10);

                        if (!columns[col]) columns[col] = [];

                        const cellValue = worksheet[cellAddress].v;

                        if (isHeaderRow) {
                            columns[col].push(cellValue); // Store headers in the array
                        } else {
                            columns[col].push(cellValue); // Store data in the array

                            if (!firstRowData[col]) {
                                firstRowData[col] = cellValue; // Store first row data
                            }
                        }

                        if (row === 1) {
                            isHeaderRow = false; // Header row has been processed
                        }
                    }

                    let all_options = '';
                    for (let col in firstRowData) {
                        let columnLabel = firstRowData[col];
                        all_options += '<option name="' + col + '">' + col + '</option>';
                    }

                    columnDropdowns.forEach((dropdown) => {
                        let select = $(dropdown);
                        select.append(all_options);

                    });
                    columnMappingDiv.style.display = "block";
                };

                reader.readAsArrayBuffer(file);
            }
        });
    });
</script>