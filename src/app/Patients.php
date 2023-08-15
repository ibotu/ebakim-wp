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
        'TCnumber' => null,
        'firstName' => null,
        'lastName' => null,
        'gender' => null,
        'dateOfBirth' => null,
        'email' => null,
        'phone' => null,
        'address' => null,
        'street' => null,
        'zipcode' => null,
        'province' => null,
        'city' => null,
        'healthInsurance' => null,
        'placeOfBirth' => null,
        'picture' => null,
        'diagnosis' => null,
        'chronicDiseases' => null,
        'placeOfAcceptance' =>null, 
        'dateOfAcceptance' => null,  
        'length' => null,
        'weight' => null,
        'fatherName' => null,
        'motherName' => null,
        'education' => null,
        'profession' => null,
        'bloodType' => null,
        'welfare' => null,
        'allergy' => null,
        'arrivalMethod' => null,
        'arrivalMethodNote' =>null,
        'speakingAbility' => null,
        'speakingAbilityNote' => null,
        'hearingAbility' => null,
        'hearingAbilityNote' => null,
        'riskFactors' => null,
        'riskEvaluationDate' => null,
        'riskPoints' => null,
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
            `TCnumber` bigint unsigned,
            `firstName` varchar(250),
            `lastName` varchar(250),
            `gender` varchar(250),
            `dateOfBirth` datetime,
            `email` varchar(250),
            `phone` varchar(250),
            `address` text,
            `street` text,
            `zipcode` varchar(250),
            `province` varchar(250),
            `city` varchar(250),
            `healthInsurance` varchar(250),
            `placeOfBirth` varchar(250),
            `picture` text,
            `diagnosis` text,
            `chronicDiseases` text,
            `placeOfAcceptance` varchar(250),
            `dateOfAcceptance` datetime,
            `length` varchar(250),
            `weight` varchar(250),
            `fatherName` varchar(250),
            `motherName` varchar(250),
            `education` text,
            `profession` text,
            `bloodType` varchar(250),
            `welfare` text,
            `allergy` text,
            `arrivalMethod` varchar(250),
            `arrivalMethodNote` text,
            `speakingAbility` varchar(250),
            `speakingAbilityNote` text,
            `hearingAbility` varchar(250),
            `hearingAbilityNote` text,
            `riskFactors` text,
            `riskEvaluationDate` datetime,
            `riskPoints` bigint unsigned,
            primary key(`id`)
        ) {$wpdb->get_charset_collate()};");
    }

    // public static function prepareData(array $args, bool $extract_nums = true): array
    // {
    //     $data = [];

    //     foreach ([

    //     ] as $char) {
    //         array_key_exists($char, $args) && ($data[$char] = trim($args[$char]));
    //     }

    //     foreach ([

    //     ] as $date) {
    //         array_key_exists($float, $args) && ($data[$float] = $extract_nums ? App::extractNum($args[$float]) : $args[$float]);
    //     }
    // }
}