<?php
/*
Plugin Name: Custom Helpers Plugin
Description: Adds custom helper functions for the project.
*/

function dd($data) {
  echo "<pre>"; print_r($data); die();  
}

class Custom_Helper_Class {
    // Your code here
}

define('CUSTOM_HELPER_CONSTANT', 'ebakim');
?>
