<div class="wrap">
    <h2><?php echo 'Add Medication' ?></h2>
    <div style="display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;margin-bottom:.55rem">
    <form method="post" action="admin.php?page=insert_medication" name="addmedication" enctype="multipart/form-data">

          <p>
            <strong style="display: table; margin-bottom: 5px"><?php echo __('Medication Name', 'ebakim-wp'); ?></strong>
            <input type="text" class="widefat" id="medicationName" required placeholder="medicationName" name="medicationName" aria-describedby="medicationName">
         </p>
         <p>
            <strong style="display: table; margin-bottom: 5px"><?php echo __('Barcode', 'ebakim-wp'); ?></strong>
            <input type="text" class="widefat" id="barcode" required placeholder="barcode" name="barcode" aria-describedby="barcode">
         </p>
         <p>
            <strong style="display: table; margin-bottom: 5px"><?php echo __('Medication Dose', 'ebakim-wp'); ?></strong>
            <input type="text" class="widefat" id="medicationDose" required placeholder="medicationDose" name="medicationDose" aria-describedby="medicationDose">
         </p>
         <p>
            <strong style="display: table; margin-bottom: 5px"><?php echo __('Medication Box Quantity', 'ebakim-wp'); ?></strong>
            <input type="text" class="widefat" id="medicationBoxQuantity" required placeholder="medicationBoxQuantity" name="medicationBoxQuantity" aria-describedby="medicationBoxQuantity">
         </p>
         <p>
            <strong style="display: table; margin-bottom: 5px"><?php echo __('Image', 'ebakim-wp'); ?></strong>
            <input type="file" accept="image/*" name="medicationimage">
         </p> 
         <p>
            <strong style="display: table; margin-bottom: 5px"><?php echo __('prospectus', 'ebakim-wp'); ?></strong>
            <input type="file" accept="image/*,application/pdf" name="medicationprospectus">
         </p> 
        <p>
            <strong style="display: table; margin-bottom: 5px"><?php echo __('Medication Usage', 'ebakim-wp'); ?></strong>
            <input type="text" class="widefat" id="medicationUsage" required placeholder="medicationUsage" name="medicationUsage" aria-describedby="medicationUsage">
         </p>
        
         <p>
            <input type="submit" id="addmedication" name="addmedication" class="button button-primary" value="Save">
         </p>
    </form>
    </div>
</div>      