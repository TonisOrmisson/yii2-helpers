<?php
namespace andmemasin\helpers;

use Codeception\Stub;

class ViewTagTest extends \Codeception\Test\Unit
{
    /**
     * @var \andmemasin\helpers\UnitTester
     */
    protected $tester;

    /** @var ViewTag */
    private $model;

    protected function setUp() : void
    {
        $this->model = new ViewTag('fake');
        parent::setUp();
    }

    public function testGetId() {
        $this->assertEquals("action::fake", $this->model->getId());
    }

    public function testToString() {
        $this->assertEquals('<x-test id="action::fake"></x-test>', $this->model->__toString());
    }


}
