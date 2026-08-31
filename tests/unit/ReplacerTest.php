<?php
namespace andmemasin\helpers;

use Codeception\Stub;
use InvalidArgumentException;

class ReplacerTest extends \Codeception\Test\Unit
{
    /**
     * @var \andmemasin\helpers\UnitTester
     */
    protected $tester;

    /** @var ViewTag */
    private $model;

    protected function setUp() : void
    {
        $this->model = new Replacer();
        parent::setUp();
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
            ["hello {world}", null, "hello {world}", ['{world}']],
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
     * @param array $keys
     */
    public function testReplace($string, $params, $expected, $keys)
    {
        $result = Replacer::replace($string, $params);
        $this->assertEquals($expected, $result);
    }


    /**
     * @dataProvider provideStrings
     * @param string $string
     * @param array $expected
     * @param array $params
     * @param string $out
     */
    public function testGetParams($string, $params, $out, $expected) {
        $result = Replacer::getParams($string);
        $this->assertEquals($expected, $result);

    }

    public function testReplaceFailsOnInvalidTextType() {
        $this->expectException(InvalidArgumentException::class);
        Replacer::replace(['x'], []);
    }

    public function testReplaceFailsOnInvalidParamsType() {
        $this->expectException(InvalidArgumentException::class);
        Replacer::replace('x{a}', 'not-array');
    }

    public function testHelpersWorkWithoutYii() {
        $script = 'require $argv[1]; require $argv[2]; echo \\andmemasin\\helpers\\Replacer::replace("hello {name} {missing}", ["name" => "world"]); echo "|"; echo json_encode(\\andmemasin\\helpers\\QueryBuilderHelper::getTypes());';
        $command = sprintf(
            '%s -n -r %s %s %s 2>&1',
            escapeshellarg(PHP_BINARY),
            escapeshellarg($script),
            escapeshellarg(__DIR__ . '/../../src/Replacer.php'),
            escapeshellarg(__DIR__ . '/../../src/QueryBuilderHelper.php')
        );
        exec($command, $output, $exitCode);

        $this->assertSame(0, $exitCode, implode(PHP_EOL, $output));
        $this->assertSame(
            'hello world {missing}|{"string":"String","integer":"Integer","double":"Double","date":"Date","datetime":"datetime","boolean":"boolean"}',
            implode(PHP_EOL, $output)
        );
    }


}
