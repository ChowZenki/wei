<?php
/**
 * Widget Framework
 *
 * @copyright   Copyright (c) 2008-2013 Twin Huang
 * @license     http://www.opensource.org/licenses/apache2.0.php Apache License
 */

namespace Widget;

use Widget\View\AbstractView;

/**
 * A wrapper widget for Smarty object
 *
 * @author      Twin Huang <twinhuang@qq.com>
 */
class Smarty extends AbstractView
{
    /**
     * The original Smarty object
     *
     * @var \Smarty
     */
    protected $object;
    
    /**
     * Default template file extension
     *
     * @var string
     */
    protected $extension = '.tpl';

    /**
     * Options for \Smarty
     *
     * @var array
     * @link http://www.smarty.net/docs/en/api.variables.tpl
     */
    public $options = array(
        'template_dir'      => array(),
        'config_dir'        => array(),
        'plugins_dir'       => array(),
        'compile_dir'       => null,
        'cache_dir'         => null,
        'left_delimiter'    => '{',
        'right_delimiter'   => '}',
    );

    /**
     * Constructor
     * 
     * @param array $options
     */
    public function __construct(array $options = array())
    {
        parent::__construct(array_merge(array(
            'object' => $this->object,
            'options' => $this->options
        ), $options));
        
        // Adds widget to template variable
        $this->object->assign('widget', $this->widget);
    }
    
    /**
     * Returns \Smarty object or render a template
     * 
     * if NO parameter provied, the invoke method will return the \Smarty 
     * object otherwise, call the render method
     *
     * @param string $name The name of template
     * @param array $vars The variables pass to template
     * 
     * @return \Smarty|string
     */
    public function __invoke($name = null, $vars = array())
    {
        if (0 === func_num_args()) {
            return $this->object;
        } else {
            return $this->render($name, $vars);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function assign($name, $value = null)
    {
        $this->object->assign($name, $value);
        
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function display($name, $vars = array())
    {
         $vars && $this->object->assign($vars);

         return $this->object->display($name);
    }

    /**
     * {@inheritdoc}
     */
    public function render($name, $vars = array())
    {
        $vars && $this->object->assign($vars);

        return $this->object->fetch($name);
    }
    
    /**
     * Set Smarty object
     * 
     * @param \Smarty $object
     * @return \Widget\Smarty
     */
    public function setObject(\Smarty $object = null)
    {
        $this->object = $object ? $object : new \Smarty();
        
        return $this;
    }
    
    /**
     * Set property value for Smarty
     * 
     * @param array $options
     * @return \Widget\Smarty
     */
    public function setOptions(array $options)
    { 
        foreach ($options as $key => $value) {
            $this->options[$key] = $value;
            $value && $this->object->$key = $value;
        }
        
        return $this;
    }
}
