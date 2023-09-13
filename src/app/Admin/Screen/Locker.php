<?php

namespace eBakim\Admin\Screen;

use eBakim\App;

class Locker extends Screen
{
    public function __construct(App $appContext)
    {
        $this->appContext = $appContext;

        return $this;
    }
    public function render()
    {   

        global $wpdb;
    
        $tablename = $wpdb->prefix . App::LOCKER_TABLE;
        
        $result = $wpdb->get_results("SELECT * FROM `$tablename`");
        $args['records']=$result;
      
        return $this->renderTemplate('locker.php',$args);
    }
    
   
}