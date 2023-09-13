<?php

namespace eBakim\Admin\Screen;

use eBakim\App;
use eBakim\Locker;

class AddLocker extends Screen
{
    public function __construct(App $appContext)
    {
        $this->appContext = $appContext;

        return $this;
    }
    public function render()
    {
        return $this->renderTemplate('addlocker.php');
    }
    public function insertlocker()
    {  
        
        $lockerNumber=$_POST['lockerNumber'];
        $patientId=$_POST['patientId'];
        $lockerNote=$_POST['lockerNote'];
        $lockerNotePersonnel=$_POST['lockerNotePersonnel'];
        $lockerNoteDate=$_POST['lockerNoteDate'];
        $response=Locker::insertlocker($lockerNumber,$patientId,$lockerNote,$lockerNotePersonnel,$lockerNoteDate);
     
        $site_url = home_url();
        if($response=='1')
        {
            echo '<script type="text/javascript">
            window.location.href = "'.$site_url.'/wp-admin/admin.php?page=locker";
            </script>';
        }
        
        
    }
}
?>