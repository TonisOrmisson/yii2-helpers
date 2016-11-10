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

    /** @var string End of time for DB logical delete. */
    const END_OF_TIME = '3000-12-31 00:00:00.000000';


    /**
     * Get current time in mysql datetime(6) format as "Y-m-d H:i:s.u"
     * @return string
     */
    public static function getDatetime6(){
        $t = microtime(true);
        $micro = sprintf("%06d",($t - floor($t)) * 1000000);
        $d = new DateTime( date('Y-m-d H:i:s.'.$micro, $t) );

        return $d->format("Y-m-d H:i:s.u"); // note at point on "u"

    }
    
    /**
     * End of time is a default value for time not in reach to mark
     * date where we will not reach. Typically default for time_closed value
     * @return string
     */
    public static function getEndOfTime(){
        return self::END_OF_TIME;
    }
    
    public static function getMysqlDateTimeFromDateTime6 ($datetime) {
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
