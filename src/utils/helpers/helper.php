<?php
/*
Plugin Name: Custom Helpers Plugin
Description: Adds custom helper functions for the project.
*/

function dd($data)
{
  echo "<pre>";
  print_r($data);
  die();
}

function patient_fields()
{
  $sample_columns = [
    '_created', '_edited', 'status', 'tc_number', 'first_name', 'last_name', 'gender', 'date_of_birth',
    'email', 'phone', 'address', 'street', 'zipcode', 'province', 'city', 'health_insurance',
    'place_of_birth', 'picture', 'diagnosis', 'chronic_diseases', 'place_of_acceptance',
    'date_of_acceptance', 'length', 'weight', 'father_name', 'mother_name', 'education', 'profession',
    'blood_type', 'welfare', 'allergy', 'arrival_method', 'arrival_method_note', 'speaking_ability',
    'speaking_ability_note', 'hearing_ability', 'guardian_number', 'guardian_email', 'guardian_name',
    'has_guardian', 'identification_sign', 'suicide_risk', 'arrival_date', 'hearing_ability_note',
    'risk_factors', 'risk_evaluation_date', 'risk_points'
  ];
  return $sample_columns;
}

class Custom_Helper_Class
{
  // Your code here
}

define('CUSTOM_HELPER_CONSTANT', 'ebakim-wp');
