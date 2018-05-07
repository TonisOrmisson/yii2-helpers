<?php
namespace andmemasin\helpers;

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
            [self::TIME_NOT_REACHED, '2001-01-02 01:01:01'],
        ];
    }



    /**
     * @dataProvider additionProvider
     */
    public function testHasTimeReached($timeType,$time)
    {
        $nowTime = "2001-01-01 01:01:01";
        $stub = $this->createMock('\DateTime');
        $stub->expects($this->any())
            ->will($this->returnValue($nowTime));
        if ($timeType === self::TIME_REACHED) {
            $this->assertTrue(DateHelper::hasTimeReached($time));
        } else {
            $this->assertFalse(DateHelper::hasTimeReached($time));
        }

    }


}