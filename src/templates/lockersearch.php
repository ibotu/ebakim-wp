
<div class="wrap">
    <?php if ($records) { ?>
    <table class="wp-list-table widefat striped posts xfixed" style="table-layout: fixed;" id="default">
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
                  
                        <span><?php esc_attr_e('Locker Number', 'ebakim-wp'); ?></span>
                  
                </th>
                <th scope="col"
                    class="manage-column column-title column-primary">
                
                        <span><?php esc_attr_e('Patient id', 'ebakim-wp'); ?></span>
                    
                </th>

            
               

                <th scope="col" class="manage-column column-title column-primary">
                    
                        <span><?php esc_attr_e('Stauts', 'ebakim-wp'); ?></span>
                        
                
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
                    <tr id="post-<?php echo $entry->lid; ?>"
                        class="iedit author-self level-0 post-<?php echo $entry->lid; ?> type-post status-publish format-standard hentry category-uncategorized entry">
                        <th scope="row" class="check-column">
                            <input id="cb-select-<?php echo $entry->lid; ?>" type="checkbox" name="items[]" value="<?php echo $entry->lid; ?>">
                        </th>

                        <td class="author column-author"><?php echo esc_attr($entry->lockerNumber) ?: '-'; ?></td>
                        <td class="author column-author"><?php echo esc_attr($entry->patientId) ?: '-'; ?></td>
                        <td class="author column-author"></td>
                        
                        <td class="author column-author">
                        <a href="admin.php?page=edit_locker&lid=<?php echo $entry->lid; ?>">Edit</a>
                        <a href="admin.php?page=delete_locker&lid=<?php echo $entry->lid; ?>" onclick="return confirm('Are you sure?')" class="button-link-delete zportal-inline-delete"><?php _e('Delete', 'ebakim-wp'); ?></a>
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