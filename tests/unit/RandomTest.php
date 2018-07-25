<?php
namespace andmemasin\helpers;


class RandomTest extends \Codeception\Test\Unit
{
    /**
     * @var \andmemasin\helpers\UnitTester
     */
    protected $tester;

    public function testGeneratePasswordLenth() {
        $result = Random::generatePassword(9);
        $this->assertEquals(9, strlen($result));
    }

    public function testGeneratePasswordContainsUpperCase() {
        $result = Random::generatePassword(9, 1);
        $this->assertTrue(preg_match('/[A-Z]/', $result) > 0);
    }

    public function testGeneratePasswordContainsVowels() {
        $result = Random::generatePassword(99, 2);
        $this->assertTrue(preg_match('/[AEUY]/', $result) > 0);
    }

    public function testGeneratePasswordContainsNumbers() {
        $result = Random::generatePassword(99, 4);
        $this->assertTrue(preg_match('/[23456789]/', $result) > 0);
    }

    public function testGeneratePasswordContainsSpecials() {
        $result = Random::generatePassword(99, 8);
        $this->assertTrue(preg_match('/[@#$%]/', $result) > 0);
    }

    public function testGetUuidV4() {
        $result = Random::getUuidV4();
        $UUIDv4 = '/^[0-9A-F]{8}-[0-9A-F]{4}-4[0-9A-F]{3}-[89AB][0-9A-F]{3}-[0-9A-F]{12}$/i';
        $this->assertTrue(preg_match($UUIDv4, $result) > 0);

    }


}