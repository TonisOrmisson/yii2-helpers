<?php
namespace andmemasin\helpers;

use yii\base\ErrorException;
use yii\base\InvalidArgumentException;

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

    public function testSelfIndexFails() {
        $this->expectException(InvalidArgumentException::class);
        MyArrayHelper::selfIndex(null);
    }


    public function testMapIndex() {
        $input = ['foo' => 'foo', 'bar' => 'bar', 'hello' => 'hello', 'world' => 'world'];
        $map = ['bar' => 'foo', 'world' => 'hello'];
        $expected = ['foo' => 'bar', 'hello' => 'world'];
        $result = MyArrayHelper::mapIndex($map, $input);
        $this->assertEquals($expected, $result);
    }

    public function testMapIndexFails() {
        $this->expectException(InvalidArgumentException::class);
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

    public function testIndexByRowFails() {
        $this->expectException(InvalidArgumentException::class);
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



    public function testIndexByColumnFailsWithInvalidColumn() {

        if (intval(PHP_VERSION_ID) >= 70400) {
            $this->expectException(ErrorException::class);
        } else {
            $this->expectException(InvalidArgumentException::class);
        }

        $input = [
            ['foo' => 1, 'bar' => 2, 'hello' => 3, 'world' => 4],
            ['foo' => 2, 'bar' => 4, 'hello' => 6, 'world' => 8],
        ];

        $result = MyArrayHelper::indexByColumn($input, 'no-such-thing');
    }

    public function testIndexByColumnFails() {
        $this->expectException(InvalidArgumentException::class);
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
