<?php
namespace andmemasin\helpers;

use Codeception\Stub;
use yii\base\InvalidArgumentException;

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


    public function testGetDatetime6(){
        $result = (new DateHelper())->getDatetime6();
        $this->assertEquals(26, strlen($result));
    }

    public function testGetEndOfTime() {
        $result = (new DateHelper())->getEndOfTime();
        $this->assertEquals('3000-12-31 00:00:00.000000', $result);
    }

    public function testGetMysqlDateTimeFromDateTime6() {
        $result = (new DateHelper())->getMysqlDateTimeFromDateTime6('3000-12-31 00:00:00.000000');
        $this->assertEquals("3000-12-31 00:00:00", $result);

    }

    public function testGetDatetimeForDisplay() {
        $result = (new DateHelper())->getDatetimeForDisplay('3000-12-31 00:00:00.000000');
        $this->assertEquals("3000-12-31 00:00:00", $result);
    }

    public function testGetMysqlDateTimeFromDateTime6FailsOnNull() {
        $this->expectException(InvalidArgumentException::class);
        (new DateHelper())->getMysqlDateTimeFromDateTime6(null);
    }

    public function testGetDatetimeForDisplayFailsOnNull() {
        $this->expectException(InvalidArgumentException::class);
        (new DateHelper())->getDatetimeForDisplay(null);
    }

    public function testGetDateDifferenceInDaysFailsOnNull() {
        $this->expectException(InvalidArgumentException::class);
        (new DateHelper())->getDateDifferenceInDays(null);
    }

    public function provideFromTo() {
        return [
            // past
            ["2018-01-01", -364],
            ["2018-12-01", -30],
            // with time
            ["2018-12-01 00:00:00", -30],

            ["2018-12-30", -1],

            // future
            ["2019-01-01", 1],
            ["2019-01-30", 30],
            ["2019-12-31", 365],

        ];
    }

    /**
     * @dataProvider provideFromTo
     * @param int $date
     * @param string $to
     */
    public function testGetDateDifferenceInDays($date, $expectedDifference)
    {
        /** @var DateHelper $model */
        $model = Stub::make(DateHelper::class, ['now' => new \DateTime("2018-12-31")]);
        $result = $model->getDateDifferenceInDays($date);
        $this->assertEquals($expectedDifference, $result);
    }


}
