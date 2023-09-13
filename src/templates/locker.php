<?php defined('ABSPATH') || exit; ?>
<?php
include(__DIR__ . '/../templates/header.php');
?>
<script type="text/javascript">

jQuery(document).ready(function($) {
    $("#data-table").hide();
    $('#searchlocker').on('keyup', function(){
        var condition=$(this).val();
       if(condition.length==0)
       {
        $("#default").show();
    $("#data-table").hide();
return false;
}
        if(condition.length>1)
        {
     console.log($(this).val());
     $.ajax({  
                url: '/wp-json/searchlocker/v1/endpoint',
                type: 'POST',
                data: {
                    condition: condition,
        
                    },   
                
           success: function (response) {
    console.log(response);
    $("#data-table tbody").html("");
    $("#default").hide();
    $("#data-table").show();
    var jsonData = response;

// Reference to the table body
var tableBody = $("#data-table tbody");
// Loop through the JSON data and create rows
$.each(jsonData, function (index, data) {
  var row = $("<tr>");
  row.append("<td class='author column-author'>" + data.lockerNumber + "</td>");
  row.append("<td class='author column-author'>" + data.patientId + "</td>");
  row.append("<td class='author column-author'>Dolu</td>");
  row.append('<td class="author column-author"><a href="admin.php?page=edit_locker&lid='+ data.lid +'">Edit</a><a href="admin.php?page=delete_locker&lid='+ data.lid +'" onclick="return confirm("Are you sure?")" class="button-link-delete zportal-inline-delete">Delete</a></td>');
  tableBody.append(row);
});
        },
        error: function (error) {
                loader.hide();
                $("#success-message").hide();
                $("#error-message").show();
                // Handle any errors
                $("#error-message span").html("An error occurred while logging into e-Nbiza.");
                console.error("error:"+error);
            },
      });  
        }
    });

   
});
</script>
<div id="response">
<div class="wrap">
    <h2 style="display:none"></h2>
    <div style="display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;margin-bottom:.55rem">
    <h1 style="padding:9px 9px 9px 0"><?php _e('Locker List', 'ebakim-wp'); ?></h1>
    <input type="text" name="search" value="" id="searchlocker" placeholder="Search..." style="margin:0 auto;display:table">
    <a href="admin.php?page=add_new_locker" class="page-title-action" style="position:static"><?php _e('Add New Locker', 'ebakim-wp'); ?></a>
    <?php
    
    ?>
    <?php if ($records) { ?>
    <table class="wp-list-table widefat striped posts xfixed" style="table-layout: fixed;" id="default">
    <?php } else {  ?>
        <table class="wp-list-table widefat striped posts xfixed" id="default">
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

        <table id="data-table" class="wp-list-table widefat striped posts xfixed" style="table-layout: fixed;">
  <thead>
    <tr>
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
  <tbody>
    <!-- Data will be inserted here -->
  </tbody>
</table>


    </div>
</div>  
            </div>