<?php
/**
 * Widget Framework
 *
 * @copyright   Copyright (c) 2008-2013 Twin Huang
 * @license     http://www.opensource.org/licenses/apache2.0.php Apache License
 */

namespace Widget;

use Doctrine\ORM\Configuration;
use Doctrine\ORM\EntityManager as BaseEntityManager;
use Doctrine\Common\Cache\Cache as DoctrineCache;

/**
 * A container widget for Doctrine ORM entity manager object
 *
 * @author      Twin Huang <twinhuang@qq.com>
 * @method      \Doctrine\DBAL\Connection db() Returns the Doctrine DBAL connection object
 * @todo        ohter mapping
 */
class EntityManager extends AbstractWidget
{
    /**
     * The configuration for \Doctrine\ORM\Configuration
     *
     * @var array
     * @see \Doctrine\ORM\Configuration
     */
    protected $config = array(
        'cache' => null,
        'proxyDir' => null,
        'proxyNamespace' => 'Proxy',
        'autoGenerateProxyClasses' => null,
        'annotationDriverPaths' => array(),
        'entityNamespaces' => array(),
        'useSimpleAnnotationReader' => false,
    );

    /**
     * The Doctrine ORM entity manager object
     * 
     * @var \Doctrine\ORM\EntityManager
     */
    protected $em;

    /**
     * Constructor
     *
     * @param array $options
     */
    public function __construct(array $options = array())
    {
        parent::__construct($options);
        $options = $this->config;

        // Create cache object
        switch (true) {
            case is_string($options['cache']) :
                $class = '\Doctrine\Common\Cache\\' . $options['cache'];
                $cache = new $class;
                break;

             case $options['cache'] instanceof DoctrineCache :
                 $cache = $options['cache'];
                 break;

             default :
                 $cache = false;
        }

        $config = new Configuration;

        // Set default cache
        if ($cache) {
            $config->setMetadataCacheImpl($cache);
            $config->setQueryCacheImpl($cache);
            $config->setHydrationCacheImpl($cache);
            $config->setResultCacheImpl($cache);
        }

        // todo other driver ?
        if ($options['annotationDriverPaths']) {
            $driverImpl = $config->newDefaultAnnotationDriver($options['annotationDriverPaths'], $options['useSimpleAnnotationReader']);
            $config->setMetadataDriverImpl($driverImpl);
        }

        if ($options['entityNamespaces']) {
            $config->setEntityNamespaces($options['entityNamespaces']);
        }

        // Proxy configuration
        if ($options['proxyDir']) {
            $config->setProxyDir($options['proxyDir']);
        }

        if ($options['proxyNamespace']) {
            $config->setProxyNamespace($options['proxyNamespace']);
        }

        if (is_bool($options['autoGenerateProxyClasses'])) {
            $config->setAutoGenerateProxyClasses($options['autoGenerateProxyClasses']);
        }

        // Create EntityManager
        $this->em = BaseEntityManager::create($this->db(), $config);
    }

    /**
     * Returns the Docrine ORM entity manager
     *
     * @return \Doctrine\ORM\EntityManager
     */
    public function __invoke()
    {
        return $this->em;
    }

    /**
     * Set configuration for \Doctrine\ORM\Configuration
     *
     * @param array $config
     * @return EntityManager
     */
    public function setConfig(array $config)
    {
        $this->config = $config + $this->config;

        return $this;
    }
}
