<div class="wrap">
    <h2><?php echo 'Add Medication' ?></h2>
    <div style="display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;margin-bottom:.55rem">
    <form method="post" action="admin.php?page=update_medication" name="editmedication" enctype="multipart/form-data">
    <input type="hidden" name="mid" value="<?php echo $records[0]->mid;?>">
    <input type="hidden" name="editmedicationimage" value="<?php if(isset($records[0]->image)) { echo $records[0]->image; }?>">
    <input type="hidden" name="editmedicationprospectus" value="<?php if(isset($records[0]->prospectus)) { echo $records[0]->prospectus; }?>">
          <p>
            <strong style="display: table; margin-bottom: 5px"><?php echo __('Medication Name', 'ebakim-wp'); ?></strong>
            <input type="text" class="widefat" value="<?php if(isset($records[0]->medicationName)) { echo $records[0]->medicationName; }?>" id="medicationName" required placeholder="medicationName" name="medicationName" aria-describedby="medicationName">
         </p>
         <p>
            <strong style="display: table; margin-bottom: 5px"><?php echo __('Barcode', 'ebakim-wp'); ?></strong>
            <input type="text" class="widefat" value="<?php if(isset($records[0]->barcode)) { echo $records[0]->barcode; }?>" id="barcode" required placeholder="barcode" name="barcode" aria-describedby="barcode">
         </p>
         <p>
            <strong style="display: table; margin-bottom: 5px"><?php echo __('Medication Dose', 'ebakim-wp'); ?></strong>
            <input type="text" class="widefat" value="<?php if(isset($records[0]->medicationDose)) { echo $records[0]->medicationDose; }?>" id="medicationDose" required placeholder="medicationDose" name="medicationDose" aria-describedby="medicationDose">
         </p>
         <p>
            <strong style="display: table; margin-bottom: 5px"><?php echo __('Medication Box Quantity', 'ebakim-wp'); ?></strong>
            <input type="text" class="widefat" value="<?php if(isset($records[0]->medicationBoxQuantity)) { echo $records[0]->medicationBoxQuantity; }?>" id="medicationBoxQuantity" required placeholder="medicationBoxQuantity" name="medicationBoxQuantity" aria-describedby="medicationBoxQuantity">
         </p>
         <p>
            <strong style="display: table; margin-bottom: 5px"><?php echo __('Image', 'ebakim-wp'); ?></strong>
            <input type="file" accept="image/*" name="medicationimage">
            <?php 
            $patientImage = esc_attr($records[0]->image);
            if ($patientImage) {
            $upload_dir = wp_upload_dir();
            $target_dir = $upload_dir['baseurl'] . '/2023/09/images/';
            echo '<img src="' . ($target_dir.$patientImage) . '" style="max-width: 50px;" alt="Patient Image">';
            }
            ?>
        </p> 
         <p>
            <strong style="display: table; margin-bottom: 5px"><?php echo __('prospectus', 'ebakim-wp'); ?></strong>
            <input type="file" accept="image/*,application/pdf" name="medicationprospectus">
            <?php 
                        $prospectus = esc_attr($records[0]->prospectus);
                        if ($prospectus) {
                            $upload_dir = wp_upload_dir();
                            $target_dir = $upload_dir['baseurl'] . '/2023/09/images/';
                             echo '<a href="'.$target_dir.$prospectus.'">'.$prospectus.'</a>';
                          }
                        ?> 
        </p> 
        <p>
            <strong style="display: table; margin-bottom: 5px"><?php echo __('Medication Usage', 'ebakim-wp'); ?></strong>
            <input type="text" class="widefat" value="<?php if(isset($records[0]->medicationUsage)) { echo $records[0]->medicationUsage; }?>" id="medicationUsage" required placeholder="medicationUsage" name="medicationUsage" aria-describedby="medicationUsage">
         </p>
        
         <p>
            <input type="submit" id="editmedication" name="editmedication" class="button button-primary" value="Update">
         </p>
    </form>
    </div>
</div>      