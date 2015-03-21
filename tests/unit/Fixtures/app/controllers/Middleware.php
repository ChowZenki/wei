<?php

namespace WeiTest\Fixtures\app\controllers;

/**
 * @property \Wei\Response $response
 */
class Middleware extends \Wei\Base
{
    protected $middleware = array();

    public function __construct($options)
    {
        parent::__construct($options);

        $this->middleware('WeiTest\Fixtures\app\middleware\Only', array('only' => 'only'));

        $this->middleware('WeiTest\Fixtures\app\middleware\except', array('except' => array(
            'only', 'before', 'after', 'around'
        )));

        $this->middleware('WeiTest\Fixtures\app\middleware\Before', array('only' => 'before'));

        $this->middleware('WeiTest\Fixtures\app\middleware\After', array('only' => 'after'));

        $this->middleware('WeiTest\Fixtures\app\middleware\Around', array('only' => 'around'));

        $this->middleware('WeiTest\Fixtures\app\middleware\Stack', array('only' => 'stack'));
        $this->middleware('WeiTest\Fixtures\app\middleware\Stack2', array('only' => 'stack'));
        $this->middleware('WeiTest\Fixtures\app\middleware\Stack3', array('only' => 'stack'));
    }

    public function only()
    {
        return 'only';
    }

    public function except()
    {
        return 'except';
    }

    public function before()
    {
        return 'before';
    }

    public function after()
    {
        return 'after';
    }

    public function around()
    {
        return 'around';
    }

    public function stack()
    {
        return $this->response->setContent($this->response->getContent() . 'stack');
    }

    public function getMiddleware()
    {
        return $this->middleware;
    }

    protected function middleware($name, array $options = array())
    {
        $this->middleware[$name] = $options;
    }
}