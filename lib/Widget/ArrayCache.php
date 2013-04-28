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
 * A cache widget stored data in PHP array
 *
 * @author      Twin Huang <twinhuang@qq.com>
 */
class ArrayCache extends AbstractCache
{
    /**
     * The array to store cache items
     * 
     * @var array
     */
    protected $data = array();
    
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
        return array_key_exists($key, $this->data) ? $this->data[$key] : false;
    }

    /**
     * {@inheritdoc}
     */
    public function set($key, $value, $expire = 0)
    {
        $this->data[$key] = $value;
        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function remove($key)
    {
        unset($this->data[$key]);
    }
    
    /**
     * {@inheritdoc}
     */
    public function exists($key)
    {
        return array_key_exists($key, $this->data);
    }

    /**
     * {@inheritdoc}
     */
    public function add($key, $value, $expire = 0)
    {
        if ($this->exists($key)) {
            return false;
        } else {
            $this->data[$key] = $value;
            return true;
        }
    }

    /**
     * {@inheritdoc}
     */
    public function replace($key, $value, $expire = 0)
    {
        if (!$this->exists($key)) {
            return false;
        } else {
            $this->data[$key] = $value;
            return true;
        }
    }

    /**
     * {@inheritdoc}
     */
    public function increment($key, $offset = 1)
    {
        if ($this->exists($key)) {
            return $this->data[$key] += $offset;
        } else {
            return $this->data[$key] = $offset;
        }
    }

    /**
     * {@inheritdoc}
     */
    public function decrement($key, $offset = 1)
    {
        return $this->increment($key, -$offset);
    }

    /**
     * {@inheritdoc}
     */
    public function clear()
    {
        $this->data = array();
        return true;
    }
}
