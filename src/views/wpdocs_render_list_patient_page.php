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
        <a href="<?php echo admin_url('admin.php?page=ebakim-new-patient'); ?>" class="page-title-action" style="position:static"><?php _e('Add New', 'ebakim'); ?></a>
    </div>
    <table class="wp-list-table widefat plugins this_datatable">
        <thead>
            <tr>
                <th scope="col" class="manage-column column-first_name">First Name</th>
                <th scope="col" class="manage-column column-last_name">Last Name</th>
                <th scope="col" class="manage-column column-email">Email</th>
                <th scope="col" class="manage-column column-phone">Phone</th>
                <th scope="col" class="manage-column column-address">Address</th>
                <th scope="col" class="manage-column column-city">City</th>
                <th scope="col" class="manage-column column-province">Province</th>
                <th scope="col" class="manage-column column-zipcode">Zipcode</th>
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
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>

<?php include(__DIR__ . '/../templates/footer.php'); ?>