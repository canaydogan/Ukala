<?php

namespace UkalaTest\Mapping\ClassMetadataFactory;

use UkalaTest\Framework\TestCase,
    Ukala\Mapping\ClassMetadataFactory\Standard,
    Doctrine\Common\Cache\ArrayCache;

abstract class AbstractStandard extends TestCase
{

    abstract public function getLoader();
    abstract public function getClass();

    protected $_standard;

    public function setUp()
    {
        parent::setUp();
        $this->_standard = new Standard(
            $this->getLoader()
        );
    }

    public function testCreation()
    {
        $this->assertInstanceOf(
            'Ukala\Mapping\ClassMetadataFactory',
            $this->_standard
        );
    }

    public function testGetClassMetadata()
    {
        $class = $this->getClass();
        $className = get_class($class);
        $classMetadata = $this->_standard->getClassMetadata($className);

        $this->assertInstanceOf(
            'Ukala\Mapping\ClassMetadata',
            $classMetadata
        );
    }

    public function testWithLoadedClass()
    {
        $class = $this->getClass();
        $className = get_class($class);
        $classMetadata = $this->_standard->getClassMetadata($className);
        $loadedClassMetadata = $this->_standard->getClassMetadata($className);

        $this->assertSame(
            $classMetadata,
            $loadedClassMetadata
        );
    }

    public function testWithArrayCache()
    {
        $class = $this->getClass();
        $className = get_class($class);

        $arrayCache = new ArrayCache();
        $this->_standard = new Standard($this->getLoader(), $arrayCache);

        $classMetadata = $this->_standard->getClassMetadata($className);
        $this->assertTrue($arrayCache->contains($className));

        $this->_standard = new Standard($this->getLoader(), $arrayCache);
        $cachedClassMetadata = $this->_standard->getCache()->fetch($className);
        $this->assertSame($classMetadata, $cachedClassMetadata);
    }

}

class AnnotationLoaderTest extends AbstractStandard
{
    public function getClass()
    {
        return $this->getAnnotatedClass();
    }

    public function getLoader()
    {
        return $this->getAnnotationLoader();
    }

}