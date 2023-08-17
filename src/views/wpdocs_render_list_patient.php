<?php defined('WPINC') || exit; ?>
<?php
include(__DIR__ . '/../templates/header.php');
global $wpdb;
$eb_patients = $wpdb->prefix . 'eb_patients';
$patient_data = $wpdb->get_results("SELECT * FROM $eb_patients");
?>

<div class="wrap">
    <div style="display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;margin-bottom:.55rem">
        <h1 style="padding:9px 9px 9px 0"><?php _e('eBakim &lsaquo; Patients', 'ebakim'); ?></h1>
        <a href="<?php echo admin_url('admin.php?page=ebakim-patient'); ?>" class="page-title-action" style="position:static"><?php _e('Add New', 'ebakim'); ?></a>
    </div>
    <table class="wp-list-table widefat plugins this_datatable">
        <thead class="dark">
            <tr>
                <th scope="col" class="manage-column column-first_name"><?php _e('First Name', 'ebakim'); ?></th>
                <th scope="col" class="manage-column column-last_name"><?php _e('Last Name', 'ebakim'); ?></th>
                <th scope="col" class="manage-column column-email"><?php _e('Email', 'ebakim'); ?></th>
                <th scope="col" class="manage-column column-phone"><?php _e('Phone', 'ebakim'); ?></th>
                <th scope="col" class="manage-column column-address"><?php _e('Address', 'ebakim'); ?></th>
                <th scope="col" class="manage-column column-city"><?php _e('City', 'ebakim'); ?></th>
                <th scope="col" class="manage-column column-province"><?php _e('Province', 'ebakim'); ?></th>
                <th scope="col" class="manage-column column-zipcode"><?php _e('Zipcode', 'ebakim'); ?></th>
                <th scope="col" class="manage-column column-zipcode"><?php _e('Actions', 'ebakim'); ?></th>
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
                        <a href="<?php echo admin_url('admin.php?page=ebakim-patient&id=' . $v->id); ?>" class="button"><?php _e('Edit', 'ebakim'); ?></a>
                        <a href="<?php echo admin_url('admin-post.php?action=delete_patient&id=' . $v->id); ?>" class="button button-danger" onclick="return confirm('Are you sure you want to delete this patient?');">
                            <?php _e('Delete', 'ebakim'); ?>
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
        const confirmDelete = confirm('<?php _e('Are you sure you want to delete this patient?', 'ebakim'); ?>');
        if (confirmDelete) {
            window.location.href = deleteUrl;
        }
    }
</script>
<?php include(__DIR__ . '/../templates/footer.php'); ?>