<div class="wrap">
    <h2><?php echo 'Edit Locker' ?></h2>
    <div style="display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;margin-bottom:.55rem">
    <form method="post" action="admin.php?page=update_locker" name="addlocker">
        <input type="hidden" name="lid" value="<?php echo $records[0]->lid;?>">
          <p>
            <strong style="display: table; margin-bottom: 5px"><?php echo __('Locker Number', 'ebakim-wp'); ?></strong>
            <input type="text" class="widefat" id="lockerNumber" required placeholder="lockerNumber" value="<?php if(isset($records[0]->lockerNumber)) { echo $records[0]->lockerNumber; }?>" name="lockerNumber" aria-describedby="lockerNumber">
         </p>
         <p>
            <strong style="display: table; margin-bottom: 5px"><?php echo __('Patient Id', 'ebakim-wp'); ?></strong>
            <input type="text" class="widefat" id="patientId" required placeholder="patientId" value="<?php if(isset($records[0]->patientId)) { echo $records[0]->patientId; }?>" name="patientId" aria-describedby="patientId">
         </p>
         <p>
        <strong style="display: table; margin-bottom: 5px"><?php echo __('Locker Note', 'ebakim-wp'); ?></strong>
        <textarea id="lockerNote" name="lockerNote" required class="widefat" rows="3" cols="50" ><?php if(isset($records[0]->lockerNote)) { echo $records[0]->lockerNote; }?></textarea>
        </p>
        <p>
            <strong style="display: table; margin-bottom: 5px"><?php echo __('Locker Note Personel', 'ebakim-wp'); ?></strong>
            <input type="text" class="widefat" id="lockerNotePersonnel" required placeholder="lockerNotePersonnel" value="<?php if(isset($records[0]->lockerNotePersonnel)) { echo $records[0]->lockerNotePersonnel; }?>" name="lockerNotePersonnel" aria-describedby="lockerNotePersonnel">
         </p>
         <p>
            <strong style="display: table; margin-bottom: 5px"><?php echo __('Locker Note Date', 'ebakim-wp'); ?></strong>
            <input type="date" class="widefat" id="patientId" required placeholder="lockerNoteDate" value="<?php if(isset($records[0]->lockerNoteDate)) { echo $records[0]->lockerNoteDate; }?>" name="lockerNoteDate" aria-describedby="lockerNoteDate">
         </p>
         <p>
            <input type="submit" id="updatelocker" name="updatelocker" class="button button-primary" value="Update">
         </p>
    </form>
    </div>
</div>      