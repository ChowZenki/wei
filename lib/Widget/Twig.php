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
 * The twig widget
 *
 * @author      Twin Huang <twinh@yahoo.cn>
 */
class Twig extends AbstractView
{
    /**
     * Options for \Twig_Environment
     *
     * @var array
     * @see \Twig_Environment::__construct
     */
    protected $envOptions = array(
        'debug'                 => false,
        'charset'               => 'UTF-8',
        'base_template_class'   => 'Twig_Template',
        'strict_variables'      => false,
        'autoescape'            => 'html',
        'cache'                 => false,
        'auto_reload'           => null,
        'optimizations'         => -1,
    );

    /**
     * Path for \Twig_Loader_Filesystem
     *
     * @var string|array
     */
    protected $paths = array();

    /**
     * Default template file extension
     *
     * @var string
     */
    protected $extension = '.html.twig';

    /**
     * The twig environment object
     *
     * @return \Twig_Environment
     */
    protected $object;

    /**
     * Constructor
     * 
     * @param array $options
     */
    public function __construct(array $options = array())
    {
        parent::__construct($options);

        if (!$this->object) {
            $this->object = new \Twig_Environment(new \Twig_Loader_Filesystem($this->paths), $this->envOptions);
        }

        // Adds widget to template variable
        $this->object->addGlobal('widget', $this->widget);
    }

    /**
     * Returns \Twig_Environment object or render a template
     * 
     * if NO parameter provied, the invoke method will return the 
     * \Twig_Environment object. otherwise, call the render method
     *
     * @param string $name The name of template
     * @param array $vars The variables pass to template
     * 
     * @return \Twig_Environment|string
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
        if (is_array($name)) {
            foreach ($name as $key => $value) {
                $this->object->addGlobal($key, $value);
            }
        } else {
            $this->object->addGlobal($name, $value);
        }
        
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function display($name, $vars = array())
    {
        return $this->object->display($name, $vars);
    }

    /**
     * {@inheritdoc}
     */
    public function render($name, $vars = array())
    {
        return $this->object->render($name, $vars);
    }
}
