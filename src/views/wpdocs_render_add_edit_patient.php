<?php defined('ABSPATH') || exit; ?>
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
}


?>
<style>
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
</style>
<div class="wrap">
    <h2><?= (isset($patient_data)) ? __('Edit Patient', 'ebakim-wp') : __('Add Patient', 'ebakim-wp') ?></h2>
    <form method="post" action="<?php echo admin_url('admin-post.php'); ?>" enctype="multipart/form-data" style="max-width: 600px">
        <input type="hidden" name="action" value="<?= ((isset($patient_data)) ? 'edit_patient' : 'add_patient') ?>" />
        <?php
        if (isset($_GET['id'])) {
        ?>
            <input type="hidden" name="id" value="<?= $_GET['id'] ?>" />
        <?php } ?>




        <p>
            <strong style="display: table; margin-bottom: 5px"><?php echo __('Patient ID', 'ebakim-wp'); ?></strong>
            <input required type="text" class="widefat" name="patientID" value="<?php echo esc_attr($patient_data->patientID ?? ''); ?>">
            <span class="error-message"></span>

        </p>
        <p>
            <strong style="display: table; margin-bottom: 5px"><?php echo __('Patient Image', 'ebakim-wp'); ?></strong>
            <input type="file" accept="image/*" name="patientImage">
            <span class="error-message"></span>
            <?php
            // $patientImage = $patient_data->picture;
            // if ($patientImage) {
            //     $upload_dir = wp_upload_dir();
            //     $target_dir = $upload_dir['path'] . '/images/';

            //     $imagePath = $target_dir . $patientImage;
            //     if (file_exists($imagePath)) {
            //         echo '<p><strong>' . __('Current Image:', 'ebakim-wp') . '</strong></p>';
            //         echo '<img src="' . ($imagePath) . '" style="max-width: 100px;" alt="Patient Image">';
            //     }
            // }
            ?>
        </p>
        <p>
            <strong style="display: table; margin-bottom: 5px"><?php echo __('Patient Fullname', 'ebakim-wp'); ?></strong>
            <input required type="text" class="widefat" name="patientFullName" value="<?php echo esc_attr($patient_data->patientFullName ?? ''); ?>">
            <span class="error-message"></span>

        </p>
        <p>
            <strong style="display: table; margin-bottom: 5px"><?php echo __('Patient Birthdate', 'ebakim-wp'); ?></strong>
            <input type="date" name="patientBirthDate" value="<?php echo esc_attr($patient_data->patientBirthDate ?? ''); ?>">
            <span class="error-message"></span>

        </p>
        <p>
            <strong style="display: table; margin-bottom: 5px"><?php echo __('Patient T.C. Number', 'ebakim-wp'); ?></strong>
            <input type="number" name="patientTcNumber" value="<?php echo esc_attr($patient_data->patientTcNumber ?? ''); ?>">
            <span class="error-message"></span>

        </p>
        <p>
            <strong style="display: table; margin-bottom: 5px"><?php echo __('Clinic Acceptance Date', 'ebakim-wp'); ?></strong>
            <input type="date" name="clinicAcceptanceDate" value="<?php echo esc_attr($patient_data->clinicAcceptanceDate ?? ''); ?>">
            <span class="error-message"></span>

        </p>
        <p>
            <strong style="display: table; margin-bottom: 5px"><?php echo __('Clinic Placement Type', 'ebakim-wp'); ?></strong>
            <input type="text" class="widefat" name="clinicPlacementType" value="<?php echo esc_attr($patient_data->clinicPlacementType ?? ''); ?>">
            <span class="error-message"></span>

        </p>
        <p>
            <strong style="display: table; margin-bottom: 5px"><?php echo __('Clinic Placement Status', 'ebakim-wp'); ?></strong>
            <input type="text" class="widefat" name="clinicPlacementStatus" value="<?php echo esc_attr($patient_data->clinicPlacementStatus ?? ''); ?>">
            <span class="error-message"></span>

        </p>
        <p>
            <strong style="display: table; margin-bottom: 5px"><?php echo __('Clinic End Date', 'ebakim-wp'); ?></strong>
            <input type="date" name="clinicEndDate" value="<?php echo esc_attr($patient_data->clinicEndDate ?? ''); ?>">
            <span class="error-message"></span>

        </p>
        <p>
            <strong style="display: table; margin-bottom: 5px"><?php echo __('Clinic Life Plan Date', 'ebakim-wp'); ?></strong>
            <input type="date" name="clinicLifePlanDate" value="<?php echo esc_attr($patient_data->clinicLifePlanDate ?? ''); ?>">
            <span class="error-message"></span>

        </p>
        <p>
            <strong style="display: table; margin-bottom: 5px"><?php echo __('Clinic ESKR Date', 'ebakim-wp'); ?></strong>
            <input type="date" name="clinicEskrDate" value="<?php echo esc_attr($patient_data->clinicEskrDate ?? ''); ?>">
            <span class="error-message"></span>

        </p>
        <p>
            <strong style="display: table; margin-bottom: 5px"><?php echo __('Clinic Guardian Date', 'ebakim-wp'); ?></strong>
            <input type="date" name="clinicGuardianDate" value="<?php echo esc_attr($patient_data->clinicGuardianDate ?? ''); ?>">
            <span class="error-message"></span>

        </p>
        <p>
            <strong style="display: table; margin-bottom: 5px"><?php echo __('Clinic Allowance Status', 'ebakim-wp'); ?></strong>
            <input type="text" class="widefat" name="clinicAllowanceStatus" value="<?php echo esc_attr($patient_data->clinicAllowanceStatus ?? ''); ?>">
            <span class="error-message"></span>

        </p>

        <p>
            <input type="submit" class="button button-primary" value="<?php esc_attr_e('Save Changes', 'ebakim-wp'); ?>">
            <span class="error-message"></span>

        </p>
    </form>
</div>
<script>
    $(document).ready(function() {
        const validationRegex = {
            patientID: /^[A-Za-z0-9_-]+$/,
            patientFullName: /^[A-Za-z\s]+$/,
            patientBirthDate: /^\d{4}-\d{2}-\d{2}$/,
            patientTcNumber: /^\d+$/,
            clinicAcceptanceDate: /^\d{4}-\d{2}-\d{2}$/,
            clinicPlacementType: /^[A-Za-z\s]+$/,
            clinicPlacementStatus: /^[A-Za-z\s]+$/,
            clinicEndDate: /^\d{4}-\d{2}-\d{2}$/,
            clinicLifePlanDate: /^\d{4}-\d{2}-\d{2}$/,
            clinicEskrDate: /^\d{4}-\d{2}-\d{2}$/,
            clinicGuardianDate: /^\d{4}-\d{2}-\d{2}$/,
            clinicAllowanceStatus: /^[A-Za-z\s]+$/,
        };

        const validationMessages = {
            patientID: '<?php echo __('Invalid format for Patient ID. Use letters, numbers, underscores, and hyphens.', 'ebakim-wp'); ?>',
            patientFullName: '<?php echo __('Please enter a valid full name.', 'ebakim-wp'); ?>',
            patientBirthDate: '<?php echo __('Please enter a valid birthdate in the format YYYY-MM-DD.', 'ebakim-wp'); ?>',
            patientTcNumber: '<?php echo __('Please enter a valid T.C. number.', 'ebakim-wp'); ?>',
            clinicAcceptanceDate: '<?php echo __('Please enter a valid clinic acceptance date in the format YYYY-MM-DD.', 'ebakim-wp'); ?>',
            clinicPlacementType: '<?php echo __('Please enter a valid clinic placement type.', 'ebakim-wp'); ?>',
            clinicPlacementStatus: '<?php echo __('Please enter a valid clinic placement status.', 'ebakim-wp'); ?>',
            clinicEndDate: '<?php echo __('Please enter a valid clinic end date in the format YYYY-MM-DD.', 'ebakim-wp'); ?>',
            clinicLifePlanDate: '<?php echo __('Please enter a valid clinic life plan date in the format YYYY-MM-DD.', 'ebakim-wp'); ?>',
            clinicEskrDate: '<?php echo __('Please enter a valid clinic ESKR date in the format YYYY-MM-DD.', 'ebakim-wp'); ?>',
            clinicGuardianDate: '<?php echo __('Please enter a valid clinic guardian date in the format YYYY-MM-DD.', 'ebakim-wp'); ?>',
            clinicAllowanceStatus: '<?php echo __('Please enter a valid clinic allowance status.', 'ebakim-wp'); ?>',
        };

        $('input[name]').keyup(function() {
            const fieldName = $(this).attr('name');
            const value = $(this).val();
            const regex = validationRegex[fieldName];
            const errorMessage = value === '' ? 'Field is required' : (regex.test(value) ? '' : validationMessages[fieldName]);
            $(this).siblings('.error-message').text(errorMessage);
        });
    });
</script>

<?php include(__DIR__ . '/../templates/footer.php'); ?>