<?php

namespace eBakim\Admin\Screen;

use eBakim\App;
use eBakim\Medication;

class AddMedication extends Screen
{
    public function __construct(App $appContext)
    {
        $this->appContext = $appContext;

        return $this;
    }
    public function render()
    {
        return $this->renderTemplate('addmedication.php');
    }
    public function insertmedication()
    {
        
        $medicationName=$_POST['medicationName'];
        $barcode=$_POST['barcode'];
        $medicationDose=$_POST['medicationDose'];
        $medicationBoxQuantity=$_POST['medicationBoxQuantity'];
        $medication_picture_filename = '';
        if (isset($_FILES['medicationimage']) && $_FILES['medicationimage']['error'] === UPLOAD_ERR_OK) {
           
            $upload_dir = wp_upload_dir();
           
            $target_dir = $upload_dir['path'] . '/images/';
            $medication_picture_filename = $target_dir . basename($_FILES['medicationimage']['name']);
            if (move_uploaded_file($_FILES['medicationimage']['tmp_name'], $medication_picture_filename)) {
                $medicationimage = basename($_FILES['medicationimage']['name']);
            }
        }
        $medication_prospectus_filename = '';
        if (isset($_FILES['medicationprospectus']) && $_FILES['medicationprospectus']['error'] === UPLOAD_ERR_OK) {

            $upload_dir = wp_upload_dir();
            $target_dir = $upload_dir['path'] . '/images/';
            $medication_prospectus_filename = $target_dir . basename($_FILES['medicationprospectus']['name']);
            if (move_uploaded_file($_FILES['medicationprospectus']['tmp_name'], $medication_prospectus_filename)) {
                $medicationprospectus = basename($_FILES['medicationprospectus']['name']);
            }
        }
            $medicationUsage=$_POST['medicationUsage'];
               
            $response=Medication::insertmedication($medicationName,$barcode,$medicationDose,$medicationBoxQuantity,$medicationimage,$medicationprospectus,$medicationUsage);
            $site_url = home_url();
            if($response=='1')
            {
                echo '<script type="text/javascript">
                window.location.href = "'.$site_url.'/wp-admin/admin.php?page=medication";
                </script>';
            }
        }
}
