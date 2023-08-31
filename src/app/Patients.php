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
        'patientID' => null,
        'patientFullName' => null,
        'patientBirthDate' => null,
        'patientTcNumber' => null,
        'clinicAcceptanceDate' => null,
        'clinicPlacementType' => null,
        'clinicPlacementStatus' => null,
        'clinicEndDate' => null,
        'clinicLifePlanDate' => null,
        'clinicEskrDate' => null,
        'clinicGuardianDate' => null,
        'clinicAllowanceStatus' => null,
        'sso_details' => null,
        'healthcare_details' => null,
        // Add other field names here
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
            `patientID` varchar(250),
            `patientFullName` varchar(250),
            `patientBirthDate` datetime,
            `patientTcNumber` varchar(250),
            `clinicAcceptanceDate` datetime,
            `clinicPlacementType` varchar(250),
            `clinicPlacementStatus` varchar(250),
            `clinicEndDate` datetime,
            `clinicLifePlanDate` datetime,
            `clinicEskrDate` datetime,
            `clinicGuardianDate` datetime,
            `sso_details` text,
            `healthcare_details` text,
            `clinicAllowanceStatus` varchar(250),
            `picture` text,
            primary key(`id`)
        ) {$wpdb->get_charset_collate()};");
    }

    // Rest of your class methods...
}
