<?php
namespace andmemasin\helpers;

use \DateTime;

/**
 * A helper class to contain general datetime helper functions
 *
 * @package app\models\helpers
 * @author Tonis Ormisson <tonis@andmemasin.eu>
 */
class DateHelper {

    /** @var End of time for DB logical delete. */
    const END_OF_TIME = '3000-12-31 00:00:00.000000';

    public static function getDatetime6(){
        // FIXME make this to return DATETIME(6)
        return date("Y-m-d H:i:s");
    }
    
    /**
     * End of time is a default value for time not in reach to mark
     * date where we will not reach. Typically default for time_closed value
     * @return string
     */
    public static function getEndOfTime(){
        return self::END_OF_TIME;
    }
    
    public static function getMysqlDateTimeFromDateTime6    ($datetime) {
        return date("Y-m-d H:i:s", strtotime( $datetime ));
    }

    
    public static function getDatetimeForDisplay($dateTime){
        return date("Y-m-d H:i:s", strtotime( $dateTime ));
    }

    public static function getDateDifferenceInDays($sqlDate){
        $dStart  = new DateTime();
        $dEnd = new DateTime($sqlDate);
        $dDiff = $dStart->diff($dEnd);
        $days = $dDiff->days;
        return $days;
    }
}
