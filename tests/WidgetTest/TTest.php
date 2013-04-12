<?php

namespace WidgetTest;

/**
 * @property \Widget\T $t The translator widget
 */
class TTest extends TestCase
{
    public function testLoadFromArray()
    {
        $this->t->loadFromArray(array(
            'key' => 'value'
        ));
        
        $this->assertEquals('value', $this->t('key'));
        $this->assertEquals('value', $this->t->trans('key'));
    }
    
    public function testLoad()
    {
        $this->t->load(function(){
            return array(
                'key1' => 'value1'
            );
        });
        
        $this->assertEquals('value1', $this->t('key1'));
        $this->assertEquals('value1', $this->t->trans('key1'));
    }
    
    public function testLoadFromFile()
    {
        $this->t->setLocale('en');
        
        $this->t->loadFromFile(__DIR__ . '/Fixtures/i18n/%s.php');
        
        $this->assertEquals('value', $this->t('key'));
        
        // load again
        $this->t->loadFromFile(__DIR__ . '/Fixtures/i18n/%s.php');
    }
    
    public function testLoadFromFallback()
    {
        $this->t->setLocale('zh-CN');
        
        $this->t->loadFromFile(__DIR__ . '/Fixtures/i18n/%s.php');
        
        $this->assertEquals('value', $this->t('key'));
    }
    
    public function testFallbackLocale()
    {
        $this->assertEquals('en', $this->t->getFallbackLocale());
        
        $this->t->setFallbackLocale('zh-CN');
        
        $this->assertEquals('zh-CN', $this->t->getFallbackLocale());
    }
        
     public function testLocale()
    {
        $this->assertEquals('en', $this->t->getLocale());
        
        $this->t->setLocale('zh-CN');
        
        $this->assertEquals('zh-CN', $this->t->getLocale());
    }   
    
    /**
     * @expectedException \Widget\Exception\InvalidArgumentException
     */
    public function testFileNotFound()
    {
        $this->t->loadFromFile('not found file for locale %s');
    }
}