<div class="wrap">
    <h2><?php echo 'Add Locker' ?></h2>
    <div style="display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;margin-bottom:.55rem">
    <form method="post" action="admin.php?page=insert_locker" name="addlocker">

          <p>
            <strong style="display: table; margin-bottom: 5px"><?php echo __('Locker Number', 'ebakim-wp'); ?></strong>
            <input type="text" class="widefat" id="lockerNumber" required placeholder="lockerNumber" name="lockerNumber" aria-describedby="lockerNumber">
         </p>
         <p>
            <strong style="display: table; margin-bottom: 5px"><?php echo __('Patient Id', 'ebakim-wp'); ?></strong>
            <input type="text" class="widefat" id="patientId" required placeholder="patientId" name="patientId" aria-describedby="patientId">
         </p>
         <p>
        <strong style="display: table; margin-bottom: 5px"><?php echo __('Locker Note', 'ebakim-wp'); ?></strong>
        <textarea id="lockerNote" name="lockerNote" required class="widefat" rows="3" cols="50" ></textarea>
        </p>
        <p>
            <strong style="display: table; margin-bottom: 5px"><?php echo __('Locker Note Personel', 'ebakim-wp'); ?></strong>
            <input type="text" class="widefat" id="lockerNotePersonnel" required placeholder="lockerNotePersonnel" name="lockerNotePersonnel" aria-describedby="lockerNotePersonnel">
         </p>
         <p>
            <strong style="display: table; margin-bottom: 5px"><?php echo __('Locker Note Date', 'ebakim-wp'); ?></strong>
            <input type="date" class="widefat" id="patientId" required placeholder="lockerNoteDate" name="lockerNoteDate" aria-describedby="lockerNoteDate">
         </p>
         <p>
            <input type="submit" id="addlocker" name="addlocker" class="button button-primary" value="Save">
         </p>
    </form>
    </div>
</div>      