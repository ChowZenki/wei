<?php
require_once dirname(__FILE__) . '/../../../libs/Qwin.php';
require_once dirname(__FILE__) . '/../../../libs/Qwin/IsPost.php';

/**
 * Test class for Qwin_IsPost.
 * Generated by PHPUnit on 2012-02-02 at 10:10:22.
 */
class Qwin_IsPostTest extends PHPUnit_Framework_TestCase {

    /**
     * @var Qwin_IsPost
     */
    protected $object;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp() {
        $this->object = new Qwin_IsPost;
    }

    /**
     * Tears down the fixture, for example, closes a network connection.
     * This method is called after a test is executed.
     */
    protected function tearDown() {

    }

    /**
     * @covers Qwin_IsPost::call
     */
    public function testCall() {
        $widget = $this->object;

        $result = isset($_SERVER['REQUEST_METHOD']) && 'POST' == strtoupper($_SERVER['REQUEST_METHOD']);

        $this->assertEquals($result, $widget->isPost());
    }

}