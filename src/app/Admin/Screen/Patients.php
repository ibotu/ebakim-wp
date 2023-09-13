<?php

namespace eBakim\Admin\Screen;

use eBakim\Patients as Core;
use eBakim\App;

class Patients extends Screen
{
   

    public function render()
    {
       
        return $this->renderTemplate('dashboard.php');
    }
  
   
}