<?php
namespace andmemasin\helpers;


class QueryBuilderHelperTest extends \Codeception\Test\Unit
{
    /**
     * @var \andmemasin\helpers\UnitTester
     */
    protected $tester;

    public function testGetTypes() {
        $result = QueryBuilderHelper::getTypes();
        $this->assertInternalType('array', $result);
    }




}