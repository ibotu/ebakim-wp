<?php

namespace eBakim\Admin\Screen;

use eBakim\App;
use WP_REST_Response;
class LockerSearch extends Screen
{
    public function __construct(App $appContext)
    {
        $this->appContext = $appContext;

        return $this;
    }
    public function render(): WP_REST_Response
    {   
       $search=$_POST['condition'];
        global $wpdb;
        //$search="A2";
    
        $tablename = $wpdb->prefix . App::LOCKER_TABLE;
        $tablename1=$wpdb->prefix . App::MEDICATION_TABLE;
        $tablename2 =$wpdb->prefix . App::PATIENT_MEDICATION_TABLE;
        $results = $wpdb->get_results("SELECT m.mid,m.medicationName,l.lid,l.lockerNumber,l.patientId,mp.lid,mp.mid FROM $tablename2 AS mp LEFT JOIN $tablename1 AS m ON mp.mid = m.mid LEFT JOIN $tablename AS l ON mp.lid = l.lid WHERE l.lockerNumber LIKE '%".$search."%' OR l.patientId Like '%".$search."%' OR m.medicationName LIKE '%".$search."%';");
        //$args['records']=$result;
        $json_array = array();

        if ($results) {
            foreach ($results as $result) {
                $json_array[] = array(
                    'mid' => $result->mid,
                    'medicationName' => $result->medicationName,
                    'lid' => $result->lid,
                    'lockerNumber' => $result->lockerNumber,
                    'patientId' => $result->patientId
                );
            }
        }
        //return $this->renderTemplate('lockersearch.php',$args);
        $response = new WP_REST_Response($json_array);
        //echo $response;
       
        return $response;
        
    }
    
   
}