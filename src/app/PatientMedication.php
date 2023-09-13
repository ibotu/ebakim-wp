<?php

namespace eBakim;

use DateTime;

class PatientMedication
{
    public const COLUMNS = [
        'pmid' => null,
        'prescriptionCode' => null,
        'prescriptionDate' => null,
        'purchaseDate' => null,
        'usageStartDate' => null,
        'usageStopDate' => null,
        'medulaEndDate' => null,
        'usageDose' => null,
        'period' => null,
        'usageNumber' => null,
        'boxQuantity' => null,
        'medicationNote' => null,
        'hospitalName' => null,
        'clinicName' => null,
        'medicationStopPhysician' => null,
        'medicationAmountRemaining' => null,
    ];

    public static function setupDb(float $db_version = 0)
    {
        global $wpdb;
        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
        $table = $wpdb->prefix . App::LOCKER_TABLE;
        $table1 = $wpdb->prefix . App::MEDICATION_TABLE;
        $table2 = $wpdb->prefix . App::PATIENT_MEDICATION_TABLE;
        
        dbDelta("CREATE TABLE IF NOT EXISTS {$table2} (
            `pmid` bigint(20) unsigned not null auto_increment,
            `mid` bigint(20),
            `lid` bigint(20),
            `prescriptionCode` text,
            `prescriptionDate` datetime,
            `purchaseDate` datetime,
            `usageStartDate` datetime,
            `usageStopDate` date,
            `medulaEndDate` date,
            `usageDose` text,
            `period` text,
            `usageNumber` int(20),
            `boxQuantity` bigint(20),
            `medicationNote` text,
            `hospitalName` text,
            `clinicName` text,
            `medicationStopPhysician` text,
            `medicationAmountRemaining` text, 
            primary key(`pmid`),
            FOREIGN KEY (lid) REFERENCES {$table}(lid),
            FOREIGN KEY (mid) REFERENCES {$table1}(mid)
        ) {$wpdb->get_charset_collate()};");
    }
   
}    