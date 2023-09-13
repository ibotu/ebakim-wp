<?php

namespace eBakim;

use DateTime;

class Locker
{
    const COLUMNS = [
        'lid'=>null,
        'lockerNumber'=>null,
        'patientId'=>null,
        'lockerNote'=>null,
        'lockerNotePersonnel'=>null,
        'lockerNoteDate'=>null,
        'mid' => null,
        'medicationName' => null,
        'barcode' => null,
        'medicationDose' => null,
        'medicationBoxQuantity' => null,
        'image' => null,
        'prospectus' => null,
        'medicationUsage' => null,
       
        // Add other field names here
    ];

    public static function setupDb(float $db_version = 0)
    {
        global $wpdb;
        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
      
        $table = $wpdb->prefix . App::LOCKER_TABLE;

        dbDelta("CREATE TABLE IF NOT EXISTS {$table} (
            `lid` bigint(20) unsigned not null auto_increment,
            `lockerNumber` text,
            `patientId` bigint(100),
            `lockerNote` text,
            `lockerNotePersonnel` text,
            `lockerNoteDate` text,
            primary key(`lid`)
        ) {$wpdb->get_charset_collate()};");

       
     }
     public static function insertlocker($lockerNumber,$patientId,$lockerNote,$lockerNotePersonnel,$lockerNoteDate)
    {
        global $wpdb;
        $tablename =$wpdb->prefix.APP::LOCKER_TABLE;
        $sqlnew = $wpdb->prepare("INSERT INTO `$tablename` (`lockerNumber`, `patientId`, `lockerNote`, `lockerNotePersonnel`, `lockerNoteDate`) values ('".$lockerNumber."', '".$patientId."', '".$lockerNote."', '".$lockerNotePersonnel."', '".$lockerNoteDate."')");
        $result=$wpdb->query($sqlnew);
        if ($result !== false) {
         return 1;
        }
        else
        {
            //echo "Something is wrong";
        return 0;
        }
    }
   public static function updatelocker($lid,$lockerNumber,$patientId,$lockerNote,$lockerNotePersonnel,$lockerNoteDate)
   {
    global $wpdb;
    $tablename = $wpdb->prefix.APP::LOCKER_TABLE;
    $data = array(
       'lockerNumber' => $lockerNumber,
       'patientId' => $patientId,
       'lockerNote' => $lockerNote,
       'lockerNotePersonnel' => $lockerNotePersonnel,
       'lockerNoteDate' => $lockerNoteDate,

    );
    $where = array(
        'lid' => $lid,
    );
    $wpdb->update($tablename, $data, $where);
    if ($wpdb->last_error) {
        return '0';
    } else {
        return "1";
    }
    }
    public static function deletelocker($lid)
    {
        require_once('wp-load.php');
        global $wpdb;
        $tablename = $wpdb->prefix.APP::LOCKER_TABLE;
        $wpdb->query('SET FOREIGN_KEY_CHECKS = 0');
        $wherecondition=array(
            'lid'=>$lid
        );
        $wpdb->delete($tablename, $wherecondition);
        if ($wpdb->last_error) {
            return '0';
        } else {
            return "1";
        }
        $wpdb->query('SET FOREIGN_KEY_CHECKS = 1');
    }
   

   
    // Rest of your class methods...
}
