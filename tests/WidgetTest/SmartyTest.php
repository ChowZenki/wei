<?php

namespace WidgetTest;

/**
 * @property \Widget\Smarty $smarty The smarty widget
 */
class SmartyTest extends TestCase
{
    public function setUp()
    {
        $this->widget->config('smarty', array(
            'options' => array(
                'template_dir' => __DIR__ . '/Fixtures'
            )
        ));
        parent::setUp();
    }
    
    public function testInvoker()
    {
        // Receive the original smarty object
        $this->assertInstanceOf('\Smarty', $this->smarty());
        
        $content = $this->smarty('smarty.tpl', array(
            'value' => __METHOD__
        ));
        
        $this->assertEquals(__METHOD__, $content);
    }

    public function testGetExtension()
    {
        $this->assertEquals('.tpl', $this->smarty->getExtension());
    }
    
    public function testRender()
    {
        $content = $this->smarty->render('smarty.tpl', array(
            'value' => __METHOD__
        ));
        
        $this->assertEquals(__METHOD__, $content);
    }
    
    public function testDisplay()
    {
        $this->expectOutputString(__METHOD__);
        
        $this->smarty->display('smarty.tpl', array(
            'value' => __METHOD__
        ));
    }
    
    public function testAssign()
    {
        $this->smarty->assign('value', __METHOD__);
        
        $content = $this->smarty->render('smarty.tpl');
        
        $this->assertEquals(__METHOD__, $content);
    }
    
    public function testAssignArray()
    {
        $this->smarty->assign(array(
            'value' => __METHOD__
        ));
        
        $this->assertEquals(__METHOD__, $this->smarty()->getVariable('value'));
    }
    
    public function testGetDefaultVariable()
    {
        $this->assertSame($this->widget, $this->smarty()->getVariable('widget')->value);
    }
}