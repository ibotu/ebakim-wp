<?php defined('WPINC') || exit; ?>
<?php
include(__DIR__ . '/../templates/header.php');

if (isset($_GET['id'])) {
    global $wpdb;
    $eb_patients = $wpdb->prefix . 'eb_patients';
    $patient_id = intval($_GET['id']); // Sanitize and convert to integer

    // Retrieve patient data for the specified ID
    $patient_data = $wpdb->get_row(
        $wpdb->prepare("SELECT * FROM $eb_patients WHERE id = %d", $patient_id)
    );
    $already_fields = maybe_unserialize($patient_data->sso_details) ?? [];
}

?>

<style>
    .custom-field {
        margin-bottom: 15px;
    }

    input {
        width: 100%;
    }

    .flowers {
        width: 35px;
        height: 35px;
    }

    .flex-div {
        display: flex;
        align-items: center;
        gap: 10px;
        margin-bottom: 10px;
    }

    .add-field-container {
        display: flex;
        gap: 10px;
        align-items: center;
        margin-top: 10px;
    }
</style>
<div class="wrap">
    <h2><?php _e('Add SSO', 'ebakim-wp'); ?></h2>
    <form method="POST" action="<?php echo admin_url('admin-post.php'); ?>" style="max-width: 600px">
        <input type="hidden" name="action" value="ebakim_add_sso">
        <input type="hidden" name="id" value="<?php echo intval($_GET['id']); ?>">

        <?php
        function render_custom_field($title, $type, $value = '')
        {
        ?>
            <p class="custom-field">
                <strong style="display: table; margin-bottom: 5px"><?php echo esc_html($title); ?></strong>
                <input required type="<?php echo esc_attr($type); ?>" name="additional_fields[]" value="<?php echo esc_attr($value); ?>">
                <span class="error-message"></span>
            </p>
        <?php
        }
        ?>

        <?php foreach ($already_fields as $k => $v) { ?>
            <div class="parent" style="display: flex;align-items: center;justify-content: space-between;gap: 5px;">
                <div class="custom-field" style="width:100%;">
                    <strong style="display: table; margin-bottom: 5px"><?= ucwords(str_replace('_', ' ', $k));  ?></strong>
                    <input required="" type="text" name="<?= $k ?>" value="<?= $v ?>">
                    <span class="error-message"></span>
                </div>
                <div class="">
                    <a href="#" onclick="console.log($(this).closest('.parent').remove());">Delete</a>
                </div>
            </div>
        <?php } ?>


        <div id="additional-fields" class="custom-field-container">

        </div>


        <div class="add-field-container">
            <button type="button" id="add-field-button">Add Field</button>
        </div>


        <?php submit_button(__('Add SSO', 'ebakim-wp')); ?>
    </form>
</div>
<script>
    $(document).ready(function() {
        const inputTypes = ['text', 'number', 'date'];

        const validationRegex = {
            // sso_field_1: '/^[A-Za-z0-9_-]+$/',

            // Add more validation rules here
        };

        const validationMessages = {
            // sso_field_1: 'Invalid format for SSO Field 1. Use letters, numbers, underscores, and hyphens.',

            // Add more validation messages here
        };

        $('input[name^="sso"]').keyup(function() {
            const fieldName = $(this).attr('name');
            const value = $(this).val();
            const regex = validationRegex[fieldName];
            const errorMessage = value === '' ? 'Field is required' : (regex.test(value) ? '' : validationMessages[fieldName]);
            $(this).siblings('.error-message').text(errorMessage);
        });

        $('#add-field-button').on('click', function() {
            const fieldTitle = prompt('Enter field title:');
            if (fieldTitle) {
                const fieldName = fieldTitle
                    .toLowerCase() // Convert to lowercase
                    .replace(/[^\w\s]/g, '') // Remove special characters
                    .replace(/\s+/g, '_'); // Replace spaces with underscores

                const fieldType = prompt('Enter field type (text, number, date):').toLowerCase();
                if (inputTypes.includes(fieldType)) {
                    const newField = `
                    <div class="custom-field">
                        <strong style="display: table; margin-bottom: 5px">${fieldTitle}</strong>
                        <input required type="${fieldType}" name="${fieldName}" value="">
                        <span class="error-message"></span>
                    </div>
                `;
                    $('#additional-fields').append(newField);
                } else {
                    alert('Invalid field type. Please use "text", "number", or "date".');
                }
            }
        });
    });
</script>
<?php include(__DIR__ . '/../templates/footer.php'); ?>