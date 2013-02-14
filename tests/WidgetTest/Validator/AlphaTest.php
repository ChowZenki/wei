<?php

namespace WidgetTest\Validator;

class AlphaTest extends TestCase
{
    /**
     * @dataProvider providerForAlpha
     */
    public function testAlpha($input)
    {
        $this->assertTrue($this->isAlpha($input));
    }

    /**
     * @dataProvider providerForNotAlpha
     */
    public function testNotAlpha($input)
    {
        $this->assertFalse($this->isAlpha($input));
    }

    public function providerForAlpha()
    {
        return array(
            array('abcedfg'),
            array('aBcDeFg'),
        );
    }

    public function providerForNotAlpha()
    {
        return array(
            array('abcdefg1'),
            array('a bcdefg'),
            array('123'),
        );
    }
}
