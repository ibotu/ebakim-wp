<?php defined('WPINC') || exit; ?>
<?php
include(__DIR__ . '/../templates/header.php');
global $wpdb;
$eb_patients = $wpdb->prefix . 'eb_patients';
$patient_data = $wpdb->get_results("SELECT * FROM $eb_patients");

// wp_redirect($redirect_url);

?>
<style>
    .column-actions {
        display: flex;
        gap: 5px;
    }
   
</style>

<div class="wrap">
    <div style="display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;margin-bottom:.55rem">
        <h1 style="padding:9px 9px 9px 0"><?php _e('eBakim &lsaquo; Patients', 'ebakim-wp'); ?></h1>
        <div class="">
            <a href="<?php echo admin_url('admin.php?page=ebakim-import-patient') ?>" class="page-title-action" style="position:static"><?php _e('Import Excel', 'ebakim-wp'); ?></a>
            <a href="<?php echo admin_url('admin.php?page=ebakim-add-patient'); ?>" class="page-title-action" style="position:static"><?php _e('Add New', 'ebakim-wp'); ?></a>
        </div>
    </div>
    <table class="wp-list-table widefat plugins this_datatable">
        <thead class="dark">
            <tr>
                <th scope="col" class="manage-column column-patientID"><?php _e('Patient ID', 'ebakim-wp'); ?></th>
                <th scope="col" class="manage-column column-patientFullName"><?php _e('Patient Full Name', 'ebakim-wp'); ?></th>
                <th scope="col" class="manage-column column-patientBirthDate"><?php _e('Patient Birth Date', 'ebakim-wp'); ?></th>
                <th scope="col" class="manage-column column-patientTcNumber"><?php _e('Patient T.C. Number', 'ebakim-wp'); ?></th>
                <th scope="col" class="manage-column column-clinicAcceptanceDate"><?php _e('Clinic Acceptance Date', 'ebakim-wp'); ?></th>
                <th scope="col" class="manage-column column-actions"><?php _e('Actions', 'ebakim-wp'); ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($patient_data as $k => $v) { ?>
                <tr>
                    <td class="name column-<?= $v->patientID ?>"><strong><?= $v->patientID ?></strong></td>
                    <td class="name column-<?= $v->patientFullName ?>"><strong><?= $v->patientFullName ?></strong></td>
                    <td class="name column-<?= $v->patientBirthDate ?>"><strong><?= ($v->patientBirthDate == '0000-00-00 00:00:00') ? '-' : $v->patientBirthDate ?></strong></td>
                    <td class="name column-<?= $v->patientTcNumber ?>"><strong><?= $v->patientTcNumber ?></strong></td>
                    <td class="name column-<?= $v->clinicAcceptanceDate ?>"><strong><?= ($v->clinicAcceptanceDate == '0000-00-00 00:00:00') ? '-' : $v->clinicAcceptanceDate ?></strong></td>
                    <td class="name column-actions">
                        <a href="<?php echo admin_url('admin.php?page=ebakim-add-patient&id=' . $v->id); ?>" class="button"><?php _e('Edit', 'ebakim-wp'); ?></a>
                        <a href="<?php echo admin_url('admin-post.php?action=delete_patient&id=' . $v->id); ?>" class="button button-danger" onclick="return confirm('Are you sure you want to delete this patient?');">
                            <?php _e('Delete', 'ebakim-wp'); ?>
                        </a>
                        <a href="<?php echo admin_url('admin.php?page=ebakim-add-sso&id=' . $v->id); ?>" class="button button-success"><?php _e('SSO', 'ebakim-wp'); ?></a>
                        <a href="<?php echo admin_url('admin.php?page=ebakim-add-healthcare&id=' . $v->id); ?>" class="button button-success"><?php _e('Healthcare', 'ebakim-wp'); ?></a>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>
<script>
    function confirmAndDelete(event, deleteUrl) {
        event.preventDefault();
        const confirmDelete = confirm('<?php _e('Are you sure you want to delete this patient?', 'ebakim-wp'); ?>');
        if (confirmDelete) {
            window.location.href = deleteUrl;
        }
    }
</script>
<?php include(__DIR__ . '/../templates/footer.php'); ?>