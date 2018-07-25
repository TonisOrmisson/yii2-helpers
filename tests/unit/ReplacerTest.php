<?php
namespace andmemasin\helpers;

use Codeception\Stub;

class ReplacerTest extends \Codeception\Test\Unit
{
    /**
     * @var \andmemasin\helpers\UnitTester
     */
    protected $tester;

    /** @var ViewTag */
    private $model;

    protected function setUp()
    {
        $this->model = new Replacer();
        return parent::setUp();
    }

    public function provideStrings() {
        return [
            ["hello {var}", ['var' => "world"], "hello world", ['{var}']],
            ["hello {world}", ['world' => "world"], "hello world", ['{world}']],
            ["hello {1}", ['1' => "world"], "hello world", ['{1}']],
            ["the quick {color} {animal} jumps over {who}",
                ['color' => "brown", "animal" => "fox", "who" => "the lazy dog"],
                "the quick brown fox jumps over the lazy dog",
                ['{color}', '{animal}', '{who}']
            ],
            ["hello {world}", [], "hello {world}", ['{world}']],
            ["hello world", ['{hello}'], "hello world", []],
            [null, null, null, []],
        ];
    }

    /**
     * @dataProvider provideStrings
     * @param string $string
     * @param string $expected
     * @param array $params
     */
    public function testReplace($string, $params, $expected, $keys)
    {
        $result = Replacer::replace($string, $params);
        $this->assertEquals($expected, $result);
    }


    /**
     * @dataProvider provideStrings
     * @param string $string
     * @param string $expected
     * @param array $params
     */
    public function testGetParams($string, $params, $out, $expected) {
        $result = Replacer::getParams($string);
        $this->assertEquals($expected, $result);

    }


}