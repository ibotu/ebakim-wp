<?php

namespace eBakim\Admin\Screen;

use eBakim\App;

class PatientMedication extends Screen
{
    public function __construct(App $appContext)
    {
        $this->appContext = $appContext;

        return $this;
    }
    public function render()
    {   

        global $wpdb;
        $tablename = $wpdb->prefix . App::PATIENT_MEDICATION_TABLE;
        
        $result = $wpdb->get_results("SELECT * FROM `$tablename`");
        $args['records']=$result;
      
        return $this->renderTemplate('patientmedication.php',$args);
    }
   
}