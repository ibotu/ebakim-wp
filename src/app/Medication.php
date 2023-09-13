<?php

namespace eBakim;

use DateTime;

class Medication
{
    public const COLUMNS = [
        'mid' => null,
        'medicationName' => null,
        'barcode' => null,
        'medicationDose' => null,
        'medicationBoxQuantity' => null,
        'image' => null,
        'prospectus' => null,
        'medicationUsage' => null,
    ];

    public static function setupDb(float $db_version = 0)
    {
        global $wpdb;
        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
        $table = $wpdb->prefix . App::MEDICATION_TABLE;

        dbDelta("CREATE TABLE IF NOT EXISTS {$table} (
            `mid` bigint(20) unsigned not null auto_increment,
            `medicationName` text,
            `barcode` bigint(100),
            `medicationDose` text,
            `medicationBoxQuantity` text,
            `image` text,
            `prospectus` text,
            `medicationUsage` text,
            primary key(`mid`)
        ) {$wpdb->get_charset_collate()};");
    }
    public static function insertmedication($medicationName,$barcode,$medicationDose,$medicationBoxQuantity,$medicationimage,$medicationprospectus,$medicationUsage)
    {
        global $wpdb;
        $tablename =$wpdb->prefix.APP::MEDICATION_TABLE;
        $sqlnew = $wpdb->prepare("INSERT INTO `$tablename` (`medicationName`, `barcode`, `medicationDose`, `medicationBoxQuantity`, `image`, `prospectus`, `medicationUsage`) values ('".$medicationName."', '".$barcode."', '".$medicationDose."', '".$medicationBoxQuantity."', '".$medicationimage."', '".$medicationprospectus."', '".$medicationUsage."')");
        $result=$wpdb->query($sqlnew);
        if ($result !== false) {
         return 1;
        }
        else
        {
         return 0;
        }
    }

    public static function updatemedication($mid,$medicationName,$barcode,$medicationDose,$medicationBoxQuantity,$medicationimage,$medicationprospectus,$medicationUsage)
   {
    global $wpdb;
    $tablename = $wpdb->prefix.APP::MEDICATION_TABLE;
    $data = array(
       'medicationName' => $medicationName,
       'barcode' => $barcode,
       'medicationDose' => $medicationDose,
       'medicationBoxQuantity' => $medicationBoxQuantity,
       'image' => $medicationimage,
       'prospectus' => $medicationprospectus,
       'medicationUsage' => $medicationUsage,
    );
    $where = array(
        'mid' => $mid,
    );
    $wpdb->update($tablename, $data, $where);
    if ($wpdb->last_error) {
        return '0';
    } else {
        return "1";
    }

    }
    public static function deletemedication($mid)
    {
        //require_once('wp-load.php');
        global $wpdb;
        $tablename = $wpdb->prefix.APP::MEDICATION_TABLE;
        $wpdb->query('SET FOREIGN_KEY_CHECKS = 0');
        $wherecondition=array(
            'mid'=>$mid
        );
        $wpdb->delete($tablename, $wherecondition);
        if ($wpdb->last_error) {
            return '0';
        } else {
            return "1";
        }
        $wpdb->query('SET FOREIGN_KEY_CHECKS = 1');
    }
}    