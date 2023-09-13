<div class="wrap">
    <h2 style="display:none"></h2>
    <div style="display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;margin-bottom:.55rem">
    <h1 style="padding:9px 9px 9px 0"><?php _e('Medication List', 'ebakim-wp'); ?></h1>
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
                  
                        <span><?php esc_attr_e('Prescription Code', 'ebakim-wp'); ?></span>
                  
                </th>
                <th scope="col"
                    class="manage-column column-title column-primary">
                
                        <span><?php esc_attr_e('Prescription Date', 'ebakim-wp'); ?></span>
                    
                </th>

            
                <th scope="col"
                    class="manage-column column-title column-primary ">
                  
                        <span><?php esc_attr_e('Purchase Date', 'ebakim-wp'); ?></span>
                  
                </th>

                <th scope="col" class="manage-column column-title column-primary">
                        <span><?php esc_attr_e('Usage StartDate', 'ebakim-wp'); ?></span>
                </th>

                <th scope="col" class="manage-column column-title column-primary">
                        <span><?php esc_attr_e('Hospital Name', 'ebakim-wp'); ?></span>
                </th>

                <th scope="col" class="manage-column column-title column-primary">
                        <span><?php esc_attr_e('Clinic Name', 'ebakim-wp'); ?></span>
                </th>
                
                <th scope="col" class="manage-column column-title column-primary">
                        <span><?php esc_attr_e('Medication Amount Remaining', 'ebakim-wp'); ?></span>
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
                    <tr id="post-<?php echo $entry->pmid; ?>"
                        class="iedit author-self level-0 post-<?php echo $entry->pmid; ?> type-post status-publish format-standard hentry category-uncategorized entry">
                        <th scope="row" class="check-column">
                            <input id="cb-select-<?php echo $entry->pmid; ?>" type="checkbox" name="items[]" value="<?php echo $entry->pmid; ?>">
                        </th>

                        <td class="author column-author"><?php echo esc_attr($entry->prescriptionCode) ?: '-'; ?></td>
                       
                        <td class="author column-author"><?php echo esc_attr($entry->prescriptionDate) ?: '-'; ?></td>
                       
                        <td class="author column-author"><?php echo esc_attr($entry->purchaseDate) ?: '-'; ?></td>
                        
                        <td class="author column-author"><?php echo esc_attr($entry->usageStartDate) ?: '-'; ?></td>

                        <td class="author column-author"><?php echo esc_attr($entry->hospitalName) ?: '-'; ?></td>

                        <td class="author column-author"><?php echo esc_attr($entry->clinicName) ?: '-'; ?></td>

                        <td class="author column-author"><?php echo esc_attr($entry->medicationAmountRemaining) ?: '-'; ?></td>

                        <td class="author column-author">
                           
                            <a href="javascript:" class="button-link-delete zportal-inline-delete"><?php _e('Delete', 'ebakim-wp'); ?></a>
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