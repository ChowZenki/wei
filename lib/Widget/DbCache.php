<?php
/**
 * Widget Framework
 *
 * @copyright   Copyright (c) 2008-2011 Twin Huang
 * @license     http://www.opensource.org/licenses/apache2.0.php Apache License
 */
namespace Widget;

use Widget\Exception;
use Widget\Cache\AbstractCache;

/**
 * A database cache widget
 *
 * @author  Twin Huang <twinhuang@qq.com>
 * @todo    add serialize field
 */
class DbCache extends AbstractCache
{
    /**
     * The cache table name
     *
     * @var string
     */
    protected $table = 'cache';

    /**
     * @var \Doctrine\DBAL\Connection
     */
    protected $conn;
    
    /**
     * Constructor
     *
     * @param array $options
     */
    public function __construct(array $options = array())
    {
        parent::__construct($options);
        
        $this->conn = $this->db();

        $this->connect();
    }

    /**
     * Connect the database
     *
     * @throws Exception\UnsupportedException When driver not support
     */
    public function connect()
    {
        $db = $this->db();
        
        $sm = $db->getSchemaManager();
        
        if (!$sm->tablesExist($this->table)) {
            $schema = $sm->createSchema();
            $table = $schema->createTable($this->table);
            $table->addColumn('id', 'string');
            $table->addColumn('value', 'string');
            $table->addColumn('expire', 'integer');
            $table->addColumn('lastModified', 'integer');
            $table->setPrimaryKey(array('id'));
            $sm->createTable($table);
        }
        
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
        $result = $this->conn->fetchAssoc("SELECT * FROM {$this->table} WHERE id = ?", array($key));

        return $result ? unserialize($result['value']) : false;
    }
    
    /**
     * {@inheritdoc}
     */
    public function set($key, $value, $expire = 0)
    {
        $data = array(
            'value' => serialize($value),
            'lastModified' => time(),
            'expire' => $expire ? time() + $expire : 2147483647
        );
        $identifier = array(
            'id' => $key
        );
        
        if ($this->exists($key)) {
            $result = $this->conn->update($this->table, $data, $identifier);
        } else {
            $result = $this->conn->insert($this->table, $data + $identifier);
        }
        
        return (bool)$result;
    }
    
    /**
     * {@inheritdoc}
     */
    public function remove($key)
    {
        return (bool)$this->conn->delete($this->table, array('id' => $key));
    }
    
    /**
     * {@inheritdoc}
     */
    public function exists($key)
    {
        return (bool)$this->conn->fetchArray("SELECT id FROM {$this->table} WHERE id = ?", array($key));
    }

    /**
     * {@inheritdoc}
     */
    public function add($key, $value, $expire = 0)
    {
        if ($this->exists($key)) {
            return false;
        } else {
            return $this->set($key, $value, $expire);
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
            return $this->set($key, $value, $expire);
        }
    }

    /**
     * Note: This method is not an atomic operation
     * 
     * {@inheritdoc}
     */
    public function increment($key, $offset = 1)
    {
        $value = $this->get($key);
        
        return $this->set($key, $value + $offset);
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
        return (bool)$this->conn->executeUpdate("DELETE FROM {$this->table}");
    }
}
