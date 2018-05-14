<?php
namespace andmemasin\helpers;

use andmemasin\helpers\DateHelper;

class DateHelperTest extends \Codeception\Test\Unit
{
    /**
     * @var \andmemasin\helpers\UnitTester
     */
    protected $tester;

    const TIME_REACHED = 1;
    const TIME_NOT_REACHED = 2;



    public function additionProvider()
    {
        return [
            [self::TIME_NOT_REACHED, '2001-01-01 01:01:02'],
            [self::TIME_NOT_REACHED, '2001-01-01 01:02:01'],
            [self::TIME_NOT_REACHED, '2001-01-01 02:01:01'],
            [self::TIME_NOT_REACHED, '2001-01-02 01:01:01'],
            [self::TIME_NOT_REACHED, '2001-02-01 01:01:01'],
            [self::TIME_NOT_REACHED, '2002-01-02 01:01:01'],
            [self::TIME_NOT_REACHED, '2021-01-01 01:01:01'],
            [self::TIME_NOT_REACHED, '2201-01-01 01:01:01'],
            [self::TIME_NOT_REACHED, '3001-01-01 01:01:01'],

            [self::TIME_REACHED, '2001-01-01 01:01:01'], // spot on
            [self::TIME_REACHED, '2001-01-01 01:01:00'],
            [self::TIME_REACHED, '2001-01-01 01:00:01'],
            [self::TIME_REACHED, '2001-01-01 00:01:01'],
            [self::TIME_REACHED, '2001-01-00 01:01:01'],
            [self::TIME_REACHED, '2001-00-01 01:01:01'],
            [self::TIME_REACHED, '2000-01-01 01:01:01'],
            [self::TIME_REACHED, '1001-01-01 01:01:01'],
        ];
    }


    /**
     * @dataProvider additionProvider
     * @param int $timeType
     * @param string $time
     */
    public function testHasTimeReached($timeType,$time)
    {
        $nowTime = new \DateTime("2001-01-01 01:01:01");
        $dateHelper = new DateHelper();
        $dateHelper->now = $nowTime;
        if ($timeType === self::TIME_REACHED) {
            $this->assertTrue($dateHelper->hasTimeReached($time));
        } else {
            $this->assertFalse($dateHelper->hasTimeReached($time));
        }

    }


}