<?php

namespace WidgetTest\Validator;

class StartsWithTest extends TestCase
{
    /**
     * @dataProvider providerForStartsWith
     */
    public function testStartsWith($input, $findMe, $case = false)
    {
        $this->assertTrue($this->isStartsWith($input, $findMe, $case));
    }

    /**
     * @dataProvider providerForNotStartsWith
     */
    public function testNotStartsWith($input, $findMe, $case = false)
    {
        $this->assertFalse($this->isStartsWith($input, $findMe, $case));
    }

    public function providerForStartsWith()
    {
        return array(
            array('abc', 'a', false),
            array('ABC', 'A', false),
            array('abc', '', false),
            array('abc', array('A', 'B', 'C'), false),
            array('hello word', array('hel', 'hell'), false)
        );
    }

    public function providerForNotStartsWith()
    {
        return array(
            array('abc', 'b', false),
            array('ABC', 'a', true),
            array('abc', array('A', 'B', 'C'), true),
        );
    }
}
