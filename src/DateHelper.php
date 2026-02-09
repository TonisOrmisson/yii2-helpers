<?php
namespace andmemasin\helpers;

use \DateTime;
use Yii;
use yii\base\InvalidArgumentException;

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
        if (!isset(Yii::$app) || !is_string(Yii::$app->timeZone) || Yii::$app->timeZone === '') {
            throw new \RuntimeException('Application timezone must be configured for ' . __CLASS__);
        }

        $timeZone = new \DateTimeZone(Yii::$app->timeZone);
        $this->now = new DateTime('now', $timeZone);
    }


    /**
     * Get current time in mysql datetime(6) format as "Y-m-d H:i:s.u"
     * @return string
     */
    public function getDatetime6() {

        $d = new DateTime();
        return $d->format("Y-m-d H:i:s.u"); // note at point on "u"
    }

    /**
     * End of time is a default value for time not in reach to mark
     * date where we will not reach. Typically default for time_closed value
     * @return string
     */
    public function getEndOfTime() {
        return self::END_OF_TIME;
    }


    /**
     * @param string $datetime
     * @return false|string
     */
    public function getMysqlDateTimeFromDateTime6($datetime) {
        if (!is_string($datetime) || $datetime === '') {
            throw new InvalidArgumentException('Datetime must be non-empty string in ' . __CLASS__ . '::' . __FUNCTION__);
        }

        $timestamp = strtotime($datetime);
        if ($timestamp === false) {
            throw new InvalidArgumentException('Invalid datetime value "' . $datetime . '" in ' . __CLASS__ . '::' . __FUNCTION__);
        }

        return date("Y-m-d H:i:s", $timestamp);
    }


    /**
     * @param string  $dateTime
     * @return false|string
     * @deprecated use Formatter
     */
    public function getDatetimeForDisplay($dateTime) {
        if (!is_string($dateTime) || $dateTime === '') {
            throw new InvalidArgumentException('Datetime must be non-empty string in ' . __CLASS__ . '::' . __FUNCTION__);
        }

        $timestamp = strtotime($dateTime);
        if ($timestamp === false) {
            throw new InvalidArgumentException('Invalid datetime value "' . $dateTime . '" in ' . __CLASS__ . '::' . __FUNCTION__);
        }

        return date("Y-m-d H:i:s", $timestamp);
    }

    /**
     * @param string $sqlDate
     * @return mixed
     */
    public function getDateDifferenceInDays($sqlDate) {
        if (!is_string($sqlDate) || $sqlDate === '') {
            throw new InvalidArgumentException('Datetime must be non-empty string in ' . __CLASS__ . '::' . __FUNCTION__);
        }

        $dStart = $this->now;
        $dEnd = new DateTime($sqlDate);
        $dDiff = $dStart->diff($dEnd);
        return (int) $dDiff->format('%r%a');
    }

    /**
     * @param string $dateTime time that we want to check whether it has reached or not
     * @return bool
     */
    public function hasTimeReached($dateTime)
    {
        if (!is_string($dateTime) || $dateTime === '') {
            throw new InvalidArgumentException('Datetime must be non-empty string in ' . __CLASS__ . '::' . __FUNCTION__);
        }
        return $this->now >= new \DateTime($dateTime);
    }

}
