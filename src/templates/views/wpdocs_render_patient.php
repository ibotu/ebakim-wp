<?php defined('WPINC') || exit; ?>
<?php
include((dirname(__FILE__) . '/../') . 'header.php');
?>
<div class="wrap">
    <h1>Patients</h1>

    <h2>What do you want to do?</h2>
    <div class="container" style="max-width:400px;background: #e1e1e1;padding: 10px 20px 30px 20px;">
        <h3>Patients Management</h3>
        <p><a href="<?php echo admin_url('admin.php?page=ebakim-list-patient'); ?>">List Patients</a></p>
        <p><a href="<?php echo admin_url('admin.php?page=ebakim-health-finding-follow-up-form'); ?>">Health Finding Follow Up Form</a></p>
        <a href="<?php echo admin_url('admin.php?page=ebakim-add-patient'); ?>"><input type="button" class="button button-primary button-large" value="Add New Patient"></a>
    </div>
    <br>
    <div class="container" style="max-width:400px;background: #e1e1e1;padding: 10px 20px 30px 20px;">
        <h3>Logbook</h3>
        <input type="button" class="button button-primary button-large" value="See Patients">
    </div>

</div>
<?php include((dirname(__FILE__) . '/../') . 'footer.php'); ?>