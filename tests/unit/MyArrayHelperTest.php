<?php
namespace andmemasin\helpers;

use Codeception\Stub;

class MyArrayHelperTest extends \Codeception\Test\Unit
{
    /**
     * @var \andmemasin\helpers\UnitTester
     */
    protected $tester;

    public function testSelfIndex() {
        $input = ['foo', 'bar', 'hello', 'world'];
        $result = MyArrayHelper::selfIndex($input);
        $expected = ['foo' => 'foo', 'bar' => 'bar', 'hello' => 'hello', 'world' => 'world'];
        $this->assertEquals($expected, $result);
    }

    /**
     * @expectedException yii\base\InvalidArgumentException
     */
    public function testSelfIndexFails() {
        MyArrayHelper::selfIndex(null);
    }


    public function testMapIndex() {
        $input = ['foo' => 'foo', 'bar' => 'bar', 'hello' => 'hello', 'world' => 'world'];
        $map = ['bar' => 'foo', 'world' => 'hello'];
        $expected = ['foo' => 'bar', 'hello' => 'world'];
        $result = MyArrayHelper::mapIndex($map, $input);
        $this->assertEquals($expected, $result);
    }

    /**
     * @expectedException yii\base\InvalidArgumentException
     */
    public function testMapIndexFails() {
        MyArrayHelper::mapIndex(null, null);
    }


    public function testIndexByRow() {
        $input = [
            ['foo', 'bar', 'hello', 'world'],
            [1,2,3,4],
            [2,4,6,8],
        ];

        $result = MyArrayHelper::indexByRow($input, 0);
        $expected = [
            ['foo' => 1, 'bar' => 2, 'hello' => 3, 'world' => 4],
            ['foo' => 2, 'bar' => 4, 'hello' => 6, 'world' => 8],
        ];
        $this->assertEquals($expected, $result);
    }

    /**
     * @expectedException yii\base\InvalidArgumentException
     */
    public function testIndexByRowFails() {
        MyArrayHelper::indexByRow(null, null);
    }

    public function testIndexByColumn() {
        $input = [
            ['foo' => 1, 'bar' => 2, 'hello' => 3, 'world' => 4],
            ['foo' => 2, 'bar' => 4, 'hello' => 6, 'world' => 8],
        ];

        $result = MyArrayHelper::indexByColumn($input, 'world');
        $expected = [
            4 => ['foo' => 1, 'bar' => 2, 'hello' => 3, 'world' => 4],
            8 => ['foo' => 2, 'bar' => 4, 'hello' => 6, 'world' => 8],
        ];
        $this->assertEquals($expected, $result);
    }

    public function testIndexByColumnEmptyArray() {
        $input = [];

        $result = MyArrayHelper::indexByColumn($input, 'world');
        $expected = [];
        $this->assertEquals($expected, $result);
    }

    /**
     * @expectedException yii\base\InvalidArgumentException
     */
    public function testIndexByColumnFailsWithInvalidColumn() {
        $input = [
            ['foo' => 1, 'bar' => 2, 'hello' => 3, 'world' => 4],
            ['foo' => 2, 'bar' => 4, 'hello' => 6, 'world' => 8],
        ];

        $result = MyArrayHelper::indexByColumn($input, 'no-such-thing');
    }

    /**
     * @expectedException yii\base\InvalidArgumentException
     */
    public function testIndexByColumnFails() {
        MyArrayHelper::indexByColumn(null, null);
    }

    public function testRemoveByValue() {
        $input = ['foo' => 1, 'bar' => 2, 'hello' => 3, 'world' => 4];
        $result = MyArrayHelper::removeByValue($input, 3);
        $expected = ['foo' => 1, 'bar' => 2,  'world' => 4];
        $this->assertEquals($expected, $result);
    }

    public function testRemoveByValueAndColumn() {
        $input = ['foo' => 1, 'bar' => 2, 'hello' => 3, 'world' => 4];
        $result = MyArrayHelper::removeByValue($input, 3);
        $expected = ['foo' => 1, 'bar' => 2,  'world' => 4];
        $this->assertEquals($expected, $result);
    }

    public function testRemoveModelByColumnValue()
    {
        $input = [
            0 => (object) ['foo' => 1, 'bar' => 2, 'hello' => 3, 'world' => 4],
            1 => (object) ['foo' => 1, 'bar' => 99, 'hello' => 3, 'world' => 4],
            2 => (object) ['foo' => 2, 'bar' => 4, 'hello' => 6, 'world' => 8],
        ];
        $expected = [
            0 => (object) ['foo' => 1, 'bar' => 2, 'hello' => 3, 'world' => 4],
            2 => (object) ['foo' => 2, 'bar' => 4, 'hello' => 6, 'world' => 8],
        ];

        $result = MyArrayHelper::removeModelByColumnValue($input, 'bar', 99);
        $this->assertEquals($expected, $result);
    }
}