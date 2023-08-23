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
        <h1 style="padding:9px 9px 9px 0"><?php _e('eBakim &lsaquo; Import Patients', 'ebakim'); ?></h1>
    </div>
    <form id="column-map-form" enctype="multipart/form-data" method="POST" action="<?php echo admin_url('admin-post.php'); ?>">

        <div style="width: 200px;">
            <p>
                <strong style="display: table; margin-bottom: 5px"><?php echo __('Upload Excel File', 'ebakim'); ?></strong>
                <input required accept=".csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel" type="file" class="widefat" name="excel_file">
            </p>
            <p>
                <input type="button" id="upload_file" class="button button-primary" value="<?php esc_attr_e('Upload File', 'ebakim'); ?>">
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
                        // echo '<option value="">Select Column</option>'; // Add an empty option
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
                let main_header = [];
                const reader = new FileReader();

                reader.onload = function(e) {
                    const data = new Uint8Array(e.target.result);
                    const workbook = XLSX.read(data, {
                        type: 'array'
                    });
                    const sheetName = workbook.SheetNames[0];
                    const worksheet = workbook.Sheets[sheetName];

                    /*  @TODO The CellNames of Row 2 Are the Names for the SelectLists
                        The SelectOptions are automatically generated from the second row of the excel file
                        The SelectOptions are automatically mapped to the options on the screen

                    */ 

                    const firstRowData = {}; // Object to store the first row data


                    for (const cellAddress in worksheet) {
                        // if (cellAddress[0] === '!') continue; // Skip non-cell keys

                        const col = cellAddress.replace(/[0-9]/g, '');
                        const row = parseInt(cellAddress.replace(/[A-Z]/gi, ''), 10);

                        if (!columns[col]) columns[col] = [];

                        const cellValue = worksheet[cellAddress].v;


                        if (cellValue) {
                            if (row == 1) {
                                // columns[col].push(cellValue); // Store headers in the array
                                main_header.push(cellValue); // Store headers in the array
                            } else {
                                columns[col].push(cellValue); // Store data in the array

                                if (!firstRowData[col]) {
                                    firstRowData[col] = cellValue; // Store first row data
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
    
    // Set the selected option based on the index
    select.children('option').eq(index).prop('selected', true);
});


                    columnMappingDiv.style.display = "block";
                };

                reader.readAsArrayBuffer(file);
            }
        });
    });
</script>