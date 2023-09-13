<div class="wrap">
    <h2 style="display:none"></h2>
    <div style="display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;margin-bottom:.55rem">
    <h1 style="padding:9px 9px 9px 0"><?php _e('Medication List', 'ebakim-wp'); ?></h1>
    <a href="admin.php?page=add_new_medication" class="page-title-action" style="position:static"><?php _e('Add New Medication', 'ebakim-wp'); ?></a>
    <?php
    
    ?>
     <form method="post" action="/" data-action="<?php echo remove_query_arg('bulk'); ?>" id="zportal-items" data-confirm="<?php esc_attr_e('Are you sure?', 'zorgportal'); ?>">
    <?php if ($records) { ?>
    <table class="wp-list-table widefat striped posts xfixed" style="table-layout: fixed;">
    <?php } else {  ?>
        <table class="wp-list-table widefat striped posts xfixed">
        <?php } ?>
            <thead>
            <tr>
                <td id="cb" class="manage-column column-cb check-column">
                    <label class="screen-reader-text" for="cb-select-all-1"><?php esc_attr_e('Select All'); ?></label>
                    <input id="cb-select-all-1" type="checkbox">
                </td>

                <th scope="col" class="manage-column column-title column-primary">
                  
                        <span><?php esc_attr_e('Medication Name', 'ebakim-wp'); ?></span>
                  
                </th>
                <th scope="col"
                    class="manage-column column-title column-primary">
                
                        <span><?php esc_attr_e('Barcode', 'ebakim-wp'); ?></span>
                    
                </th>

            
                <th scope="col"
                    class="manage-column column-title column-primary ">
                  
                        <span><?php esc_attr_e('Medication Dose', 'ebakim-wp'); ?></span>
                  
                </th>

                <th scope="col" class="manage-column column-title column-primary">
                        <span><?php esc_attr_e('Medication Box Quantity', 'ebakim-wp'); ?></span>
                </th>

                <th scope="col" class="manage-column column-title column-primary">
                        <span><?php esc_attr_e('Medication Image', 'ebakim-wp'); ?></span>
                </th>

                <th scope="col" class="manage-column column-title column-primary">
                        <span><?php esc_attr_e('Medication Prospectus', 'ebakim-wp'); ?></span>
                </th>
                
                <th scope="col" class="manage-column column-title column-primary">
                        <span><?php esc_attr_e('Medication Usage', 'ebakim-wp'); ?></span>
                </th>

                <th scope="col"
                    class="manage-column column-title column-primary">
                   
                        <span><?php esc_attr_e('Manage', 'ebakim-wp'); ?></span>
                  
                 
                </th>

             
            </tr>
            </thead>

        
            <tbody id="the-list">
            <?php if ($records) : ?>
                <?php foreach ($records as $entry) : ?>
                    <tr id="post-<?php echo $entry->mid; ?>"
                        class="iedit author-self level-0 post-<?php echo $entry->mid; ?> type-post status-publish format-standard hentry category-uncategorized entry">
                        <th scope="row" class="check-column">
                            <input id="cb-select-<?php echo $entry->mid; ?>" type="checkbox" name="items[]" value="<?php echo $entry->mid; ?>">
                        </th>

                        <td class="author column-author"><?php echo esc_attr($entry->medicationName) ?: '-'; ?></td>
                       
                        <td class="author column-author"><?php echo esc_attr($entry->barcode) ?: '-'; ?></td>
                       
                        <td class="author column-author"><?php echo esc_attr($entry->medicationDose) ?: '-'; ?></td>
                        
                        <td class="author column-author"><?php echo esc_attr($entry->medicationBoxQuantity) ?: '-'; ?></td>

                        <td class="author column-author">
                        <?php 
                            $patientImage = esc_attr($entry->image);
                             if ($patientImage) {
                               $upload_dir = wp_upload_dir();
                               $target_dir = $upload_dir['baseurl'] . '/2023/09/images/';
                               echo '<img src="' . ($target_dir.$patientImage) . '" style="max-width: 100px;" alt="Patient Image">';
                             }
                        ?>
                       </td>

                        <td class="author column-author">
                            
                        <?php 
                        $prospectus = esc_attr($entry->prospectus);
                        if ($prospectus) {
                            $upload_dir = wp_upload_dir();
                            $target_dir = $upload_dir['baseurl'] . '/2023/09/images/';
                             echo '<a href="'.$target_dir.$prospectus.'">'.$prospectus.'</a>';
                          }
                        ?></td>

                        <td class="author column-author"><?php echo esc_attr($entry->medicationUsage) ?: '-'; ?></td>

                        <td class="author column-author">
                        <a href="admin.php?page=edit_medication&mid=<?php echo $entry->mid; ?>">Edit</a>
                        <a href="admin.php?page=delete_medication&mid=<?php echo $entry->mid; ?>" onclick="return confirm('Are you sure?')" class="button-link-delete zportal-inline-delete"><?php _e('Delete', 'ebakim-wp'); ?></a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else : ?>
                <tr id="post-0" class="iedit author-self level-0 post-0 type-post status-publish format-standard hentry category-uncategorized entry">
                    <td class="author column-author" colspan="15" style="text-align:center;padding:1rem">
                        <em><?php count($_GET) > 1 ? _e('Nothing found for your current filters.', 'ebakim-wp') : _e('Nothing to show yet.', 'zorgportal'); ?></em>
                    </td>
                </tr>
            <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>  