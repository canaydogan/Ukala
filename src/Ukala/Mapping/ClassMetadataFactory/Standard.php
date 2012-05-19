<?php

namespace Ukala\Mapping\ClassMetadataFactory;

use Ukala\Mapping\ClassMetadataFactory,
    Ukala\Mapping\Loader,
    Ukala\Mapping\ClassMetadata,
    Doctrine\Common\Cache\Cache,
    Doctrine\ORM\Proxy\Proxy;

class Standard implements ClassMetadataFactory
{

    /**
     * @var Loader
     */
    protected $_loader;

    /**
     * @var Cache
     */
    protected $_cache;

    /**
     * @var array
     */
    protected $_loadedClasses  = array();

    public function __construct(Loader $loader, Cache $cache = null)
    {
        $this->setLoader($loader);
        if (null !== $cache) {
            $this->setCache($cache);
        }
    }

    public function getClassMetadata($class)
    {
        if (is_object($class)) {
            $class = $this->getClassName($class);
        }
        if (isset($this->_loadedClasses[$class])) {
            return $this->_loadedClasses[$class];
        }

        if (null !== $this->_cache
            && $this->_cache->contains($class)) {
            return $this->_loadedClasses[$class] = $this->_cache->fetch($class);
        }

        $metadata = new ClassMetadata($class);
        $this->getLoader()->loadClassMetadata($metadata);
        $this->_loadedClasses[$class] = $metadata;

        if (null !== $this->_cache) {
            $this->_cache->save($class, $metadata);
        }

        return $this->_loadedClasses[$class];
    }

    public function getClassName($object)
    {
        if ($object instanceof Proxy) {
            /**
             * @todo buraya daha iyi bir cozum bul.(__load'u entity'lerin degerlerinin yuklenmesi icin kullandim)
             */
            if (method_exists($object, "__load")) {
                $object->__load();
            }
            return get_parent_class($object);
        }

        return get_class($object);
    }

    /**
     * @param array $loadedClass
     */
    public function setLoadedClasses(array $loadedClass)
    {
        $this->_loadedClasses = $loadedClass;
    }

    /**
     * @return array
     */
    public function getLoadedClasses()
    {
        return $this->_loadedClasses;
    }

    /**
     * @param Loader $loader
     */
    public function setLoader(Loader $loader)
    {
        $this->_loader = $loader;
    }

    /**
     * @return Loader
     */
    public function getLoader()
    {
        return $this->_loader;
    }

    /**
     * @param Cache $cache
     */
    public function setCache(Cache $cache)
    {
        $this->_cache = $cache;
    }

    /**
     * @return Cache
     */
    public function getCache()
    {
        return $this->_cache;
    }

}
