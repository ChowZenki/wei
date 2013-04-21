<?php
/**
 * Widget Framework
 *
 * @copyright   Copyright (c) 2008-2013 Twin Huang
 * @license     http://www.opensource.org/licenses/apache2.0.php Apache License
 */

namespace Widget;

/**
 * The widget allows inject data from URL query string
 *
 * @author      Twin Huang <twinhuang@qq.com>
 * @property    Server $server The server widget
 * @property    Query $query The query widget
 */
class UrlDebugger extends AbstractWidget
{
    /**
     * Constructor
     * 
     * @param array $options
     */
    public function __construct(array $options = array())
    {
        parent::__construct($options);

        if ($this->widget->config('debug')) {
            $this->inject();
        }
    }

    /**
     * Inject widget parameter by specified query parameter
     */
    public function inject()
    {
        if ($this->query['_ajax']) {
            $this->server['HTTP_X_REQUESTED_WITH'] = 'xmlhttprequest';
        }

        if ($this->query['_method']) {
            $this->server['REQUEST_METHOD'] = $this->query['_method'];
        }
    }
    
    /**
     * Invoker
     * 
     * @return \Widget\UrlDebugger
     */
    public function __invoke()
    {
        return $this;
    }
}
