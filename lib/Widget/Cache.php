<?php
/**
 * Widget Framework
 *
 * @copyright   Twin Huang
 * @license     http://www.opensource.org/licenses/apache2.0.php Apache License
 */

namespace Widget;

use Widget\Cache\AbstractCache;

/**
 * A cache widget proxy
 *
 * @author      Twin Huang <twinhuang@qq.com>
 */
class Cache extends AbstractCache
{
    /**
     * The storage widget object
     *
     * @var Cache\CacheInterface
     */
    protected $object;

    /**
     * The storage widget name
     *
     * @ver string
     */
    protected $driver = 'apc';

    /**
     * Constructor
     *
     * @param array $options
     */
    public function __construct(array $options = array())
    {
        parent::__construct($options + get_object_vars($this));
    }
    
    /**
     * Set cache driver
     * 
     * @param string $driver
     * @return Cache
     * @throws Exception\InvalidArgumentException
     */
    public function setDriver($driver)
    {
        $class = $this->widget->getClass($driver);

        if (!class_exists($class)) {
            throw new Exception\InvalidArgumentException(sprintf('Cache driver class "%s" not found', $class));
        }

        if (!in_array('Widget\Cache\CacheInterface', class_implements($class))) {
            throw new Exception\InvalidArgumentException(sprintf('Cache driver "%s" should implement the interface "Widget\Cache\CacheInterface"', $class));
        }

        $this->object = $this->widget->get($driver);

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function __invoke($key, $value = null, $expire = 0)
    {
        if (1 == func_num_args()) {
            return $this->get($key);
        } else {
            return $this->set($key, $value, $expire);
        }
    }
    
    /**
     * {@inheritdoc}
     */
    public function get($key)
    {
        return $this->object->get($key);
    }
    
    /**
     * {@inheritdoc}
     */
    public function set($key, $value, $expire = 0)
    {
        return $this->object->set($key, $value, $expire);
    }
    
    /**
     * {@inheritdoc}
     */
    public function remove($key)
    {
        return $this->object->remove($key);
    }
    
    /**
     * {@inheritdoc}
     */
    public function exists($key)
    {
        return $this->object->exists($key);
    }

    /**
     * {@inheritdoc}
     */
    public function add($key, $value, $expire = 0)
    {
        return $this->object->add($key, $value, $expire);
    }
    
    /**
     * {@inheritdoc}
     */
    public function replace($key, $value, $expire = 0)
    {
        return $this->object->replace($key, $value, $expire);
    }
    
    /**
     * {@inheritdoc}
     */
    public function increment($key, $step = 1)
    {
        return $this->object->increment($key, $step);
    }
    
    /**
     * {@inheritdoc}
     */
    public function decrement($key, $step = 1)
    {
        return $this->object->decrement($key, $step);
    }

    /**
     * {@inheritdoc}
     */
    public function clear()
    {
        return $this->object->clear();
    }
}
