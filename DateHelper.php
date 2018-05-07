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

    /** @var DateTime */
    public $now;


    public function __construct()
    {
        $now = new DateTime();
    }


    /**
     * Get current time in mysql datetime(6) format as "Y-m-d H:i:s.u"
     * @return string
     * @deprecated use dynamic
     */
    public static function getDatetime6(){

        // TODO this does now consider the getNow()
        $t = microtime(true);
        $micro = sprintf("%06d",($t - floor($t)) * 1000000);
        $d = new DateTime( date('Y-m-d H:i:s.'.$micro, $t) );

        return $d->format("Y-m-d H:i:s.u"); // note at point on "u"

    }

    /**
     * End of time is a default value for time not in reach to mark
     * date where we will not reach. Typically default for time_closed value
     * @return string
     * @deprecated use dynamic
     */
    public static function getEndOfTime(){
        return self::END_OF_TIME;
    }

    /**
     * @param string $datetime
     * @return false|string
     * @deprecated use dynamic
     */
    public static function getMysqlDateTimeFromDateTime6 ($datetime) {
        return date("Y-m-d H:i:s", strtotime( $datetime ));
    }


    /**
     * @param string  $dateTime
     * @return false|string
     * @deprecated use dynamic
     */
    public static function getDatetimeForDisplay($dateTime){
        return date("Y-m-d H:i:s", strtotime( $dateTime ));
    }

    /**
     * @param string $sqlDate
     * @return mixed
     * @deprecated use dynamic
     */
    public static function getDateDifferenceInDays($sqlDate){
        $dStart  = self::getNow();
        $dEnd = new DateTime($sqlDate);
        $dDiff = $dStart->diff($dEnd);
        $days = $dDiff->days;
        return $days;
    }

    /**
     * @param string $dateTime time that we want to check whether it has reached or not
     * @return bool
     */
    public function hasTimeReached($dateTime)
    {
        return $this->now >= new \DateTime($dateTime);
    }

    /**
     * @return DateTime
     * @deprecated use dynamic
     */
    public static function getNow() {
        return new \DateTime();
    }

}
