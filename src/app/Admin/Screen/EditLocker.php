<?php

namespace eBakim\Admin\Screen;

use eBakim\App;
use eBakim\Locker;

class EditLocker extends Screen
{
    public function __construct(App $appContext)
    {
        $this->appContext = $appContext;

        return $this;
    }
    public function render()
    {   
        $lid = (int) ( $_GET['lid'] ?? null );

        global $wpdb;
        $tablename = $wpdb->prefix . App::LOCKER_TABLE;
        
        $result = $wpdb->get_results("SELECT * FROM `$tablename` where lid=".$lid."");
        $args['records']=$result;
      
        return $this->renderTemplate('editlocker.php',$args);
    }
    public function updatelocker()
    {
       $lid= $_POST['lid'];
       $lockerNumber=$_POST['lockerNumber'];
       $patientId=$_POST['patientId'];
       $lockerNote=$_POST['lockerNote'];
       $lockerNotePersonnel=$_POST['lockerNotePersonnel'];
       $lockerNoteDate=$_POST['lockerNoteDate'];
       $response=Locker::updatelocker($lid,$lockerNumber,$patientId,$lockerNote,$lockerNotePersonnel,$lockerNoteDate);
       $site_url = home_url();
       if($response=='1')
       {
           echo '<script type="text/javascript">
           window.location.href = "'.$site_url.'/wp-admin/admin.php?page=locker";
           </script>';
       }
    }
    public function deletelocker()
    {
        $lid = (int) ( $_GET['lid'] ?? null );
     
        $response=Locker::deletelocker($lid);
        $site_url = home_url();
        if($response=='1')
        {
            echo '<script type="text/javascript">
            window.location.href = "'.$site_url.'/wp-admin/admin.php?page=locker";
            </script>';
        }
    }
   
}