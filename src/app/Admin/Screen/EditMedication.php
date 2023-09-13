<?php

namespace eBakim\Admin\Screen;

use eBakim\App;
use eBakim\Medication;

class EditMedication extends Screen
{
    public function __construct(App $appContext)
    {
        $this->appContext = $appContext;

        return $this;
    }
    public function render()
    {   
        $mid = (int) ( $_GET['mid'] ?? null );

        global $wpdb;
        $tablename = $wpdb->prefix . App::MEDICATION_TABLE;
        
        $result = $wpdb->get_results("SELECT * FROM `$tablename` where mid=".$mid."");
        $args['records']=$result;
      
        return $this->renderTemplate('editmedication.php',$args);
    }
    public function updatemedication()
    {
       
       $mid= $_POST['mid'];
       $medicationName=$_POST['medicationName'];
       $editmedicationimage=$_POST['editmedicationimage'];
       $editmedicationprospectus=$_POST['editmedicationprospectus'];
       $barcode=$_POST['barcode'];
       $medicationDose=$_POST['medicationDose'];
       $medicationBoxQuantity=$_POST['medicationBoxQuantity'];
       $medication_picture_filename = '';
       if($_FILES['medicationimage']['size'] == 0)
       {
        $medicationimage=$editmedicationimage;
        echo "fine";
       }
       else
       {
         
                $upload_dir = wp_upload_dir();

                $target_dir = $upload_dir['path'] . '/images/';
                $medication_picture_filename = $target_dir . basename($_FILES['medicationimage']['name']);
                if (move_uploaded_file($_FILES['medicationimage']['tmp_name'], $medication_picture_filename)) {
                    $medicationimage = basename($_FILES['medicationimage']['name']);
                }
            
        }
        
       
       $medication_prospectus_filename = '';
       if($_FILES['medicationprospectus']['size'] == 0)
       {
        $medicationprospectus=$editmedicationprospectus;
       }
       else
       {
   

        $upload_dir = wp_upload_dir();
        $target_dir = $upload_dir['path'] . '/images/';
        $medication_prospectus_filename = $target_dir . basename($_FILES['medicationprospectus']['name']);
        if (move_uploaded_file($_FILES['medicationprospectus']['tmp_name'], $medication_prospectus_filename)) {
            $medicationprospectus = basename($_FILES['medicationprospectus']['name']);
        
    }
}
        $medicationUsage=$_POST['medicationUsage'];
       $response=Medication::updatemedication($mid,$medicationName,$barcode,$medicationDose,$medicationBoxQuantity,$medicationimage,$medicationprospectus,$medicationUsage);
       $site_url = home_url();
       if($response=='1')
       {
           echo '<script type="text/javascript">
           window.location.href = "'.$site_url.'/wp-admin/admin.php?page=medication";
           </script>';
       }
    }
    public function deletemedication()
    {
        $mid = (int) ( $_GET['mid'] ?? null );
     
        $response=Medication::deletemedication($mid);
        $site_url = home_url();
        if($response=='1')
        {
            echo '<script type="text/javascript">
            window.location.href = "'.$site_url.'/wp-admin/admin.php?page=medication";
            </script>';
        }
    }
   
}