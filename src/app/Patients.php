<?php

namespace eBakim;

use DateTime;

class Patients
{
    const COLUMNS = [
        'id' => null,
        '_created' => null,
        '_edited' => FILTER_NULL_ON_FAILURE,
        'status' => null,
        'tc_number' => null,
        'first_name' => null,
        'last_name' => null,
        'gender' => null,
        'date_of_birth' => null,
        'email' => null,
        'phone' => null,
        'address' => null,
        'street' => null,
        'zipcode' => null,
        'province' => null,
        'city' => null,
        'health_insurance' => null,
        'place_of_birth' => null,
        'picture' => null,
        'diagnosis' => null,
        'chronic_diseases' => null,
        'place_of_acceptance' => null, 
        'date_of_acceptance' => null,  
        'length' => null,
        'weight' => null,
        'father_name' => null,
        'mother_name' => null,
        'education' => null,
        'profession' => null,
        'blood_type' => null,
        'welfare' => null,
        'allergy' => null,
        'arrival_method' => null,
        'arrival_method_note' => null,
        'speaking_ability' => null,
        'speaking_ability_note' => null,
        'hearing_ability' => null,
        'hearing_ability_note' => null,
        'risk_factors' => null,
        'risk_evaluation_date' => null,
        'risk_points' => null,
        'guardian_number' => null,
        'guardian_email' => null,
        'guardian_name' => null,
        'has_guardian' => null,
        'identification_sign' => null,
        'arrival_date' => null,
        'suicide_risk' => null,
    ];

    public static function setupDb(float $db_version = 0)
    {
        global $wpdb;
        $table = $wpdb->prefix . App::PATIENTS_TABLE;
        
        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
    
        dbDelta("CREATE TABLE IF NOT EXISTS {$table} (
            `id` bigint(20) unsigned not null auto_increment,
            `_created` datetime,
            `_edited` datetime,
            `status` varchar(250),
            `tc_number` bigint unsigned,
            `first_name` varchar(250),
            `last_name` varchar(250),
            `gender` varchar(250),
            `date_of_birth` datetime,
            `email` varchar(250),
            `phone` varchar(250),
            `address` text,
            `street` text,
            `zipcode` varchar(250),
            `province` varchar(250),
            `city` varchar(250),
            `health_insurance` varchar(250),
            `place_of_birth` varchar(250),
            `picture` text,
            `diagnosis` text,
            `chronic_diseases` text,
            `place_of_acceptance` varchar(250),
            `date_of_acceptance` datetime,
            `length` varchar(250),
            `weight` varchar(250),
            `father_name` varchar(250),
            `mother_name` varchar(250),
            `education` text,
            `profession` text,
            `blood_type` varchar(250),
            `welfare` text,
            `allergy` text,
            `arrival_method` varchar(250),
            `arrival_method_note` text,
            `speaking_ability` varchar(250),
            `speaking_ability_note` text,
            `hearing_ability` varchar(250),
            `guardian_number` varchar(250),
            `guardian_email` varchar(250),
            `guardian_name` varchar(250),
            `has_guardian` varchar(250),
            `identification_sign` text,
            `suicide_risk` varchar(250),
            `arrival_date` datetime,
            `hearing_ability_note` text,
            `risk_factors` text,
            `risk_evaluation_date` datetime,
            `risk_points` bigint unsigned,
            primary key(`id`)
        ) {$wpdb->get_charset_collate()};");
    }

    // Rest of your class methods...
}
