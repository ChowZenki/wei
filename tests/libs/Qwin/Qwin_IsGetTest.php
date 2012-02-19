<?php
require_once dirname(__FILE__) . '/../../../libs/Qwin.php';
require_once dirname(__FILE__) . '/../../../libs/Qwin/IsGet.php';

/**
 * Test class for Qwin_IsGet.
 * Generated by PHPUnit on 2012-02-02 at 10:05:43.
 */
class Qwin_IsGetTest extends PHPUnit_Framework_TestCase {

    /**
     * @var Qwin_IsGet
     */
    protected $object;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp() {
        $this->object = new Qwin_IsGet;
    }

    /**
     * Tears down the fixture, for example, closes a network connection.
     * This method is called after a test is executed.
     */
    protected function tearDown() {

    }

    /**
     * @covers Qwin_IsGet::__invoke
     */
    public function test__invoke() {
        $widget = $this->object;

        $result = isset($_SERVER['REQUEST_METHOD']) && 'GET' == strtoupper($_SERVER['REQUEST_METHOD']);

        $this->assertEquals($result, $widget->isGet());
    }
}
