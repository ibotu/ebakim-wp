<?php defined('WPINC') || exit; ?>
<?php
include(__DIR__ . '/../templates/header.php');
global $wpdb;
$eb_patients = $wpdb->prefix . 'eb_patients';
$patient_data = $wpdb->get_results("SELECT * FROM $eb_patients");



// wp_redirect($redirect_url);

?>

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
                <th scope="col" class="manage-column column-first_name"><?php _e('First Name', 'ebakim-wp'); ?></th>
                <th scope="col" class="manage-column column-last_name"><?php _e('Last Name', 'ebakim-wp'); ?></th>
                <th scope="col" class="manage-column column-email"><?php _e('Email', 'ebakim-wp'); ?></th>
                <th scope="col" class="manage-column column-phone"><?php _e('Phone', 'ebakim-wp'); ?></th>
                <th scope="col" class="manage-column column-address"><?php _e('Address', 'ebakim-wp'); ?></th>
                <th scope="col" class="manage-column column-city"><?php _e('City', 'ebakim-wp'); ?></th>
                <th scope="col" class="manage-column column-province"><?php _e('Province', 'ebakim-wp'); ?></th>
                <th scope="col" class="manage-column column-zipcode"><?php _e('Zipcode', 'ebakim-wp'); ?></th>
                <th scope="col" class="manage-column column-zipcode"><?php _e('Actions', 'ebakim-wp'); ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($patient_data as $k => $v) { ?>
                <tr>
                    <td class="name column-<?= $v->first_name ?>"><strong><?= $v->first_name ?></strong></td>
                    <td class="name column-<?= $v->last_name ?>"><strong><?= $v->last_name ?></strong></td>
                    <td class="name column-<?= $v->email ?>"><strong><?= $v->email ?></strong></td>
                    <td class="name column-<?= $v->phone ?>"><strong><?= $v->phone ?></strong></td>
                    <td class="name column-<?= $v->address ?>"><strong><?= $v->address ?></strong></td>
                    <td class="name column-<?= $v->city ?>"><strong><?= $v->city ?></strong></td>
                    <td class="name column-<?= $v->province ?>"><strong><?= $v->province ?></strong></td>
                    <td class="name column-<?= $v->zipcode ?>"><strong><?= $v->zipcode ?></strong></td>
                    <td class="name column-actions">
                        <a href="<?php echo admin_url('admin.php?page=ebakim-add-patient&id=' . $v->id); ?>" class="button"><?php _e('Edit', 'ebakim-wp'); ?></a>
                        <a href="<?php echo admin_url('admin-post.php?action=delete_patient&id=' . $v->id); ?>" class="button button-danger" onclick="return confirm('Are you sure you want to delete this patient?');">
                            <?php _e('Delete', 'ebakim-wp'); ?>
                        </a>
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