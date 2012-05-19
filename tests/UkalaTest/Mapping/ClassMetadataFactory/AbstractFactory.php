<?php

namespace UkalaTest\Mapping\ClassMetadataFactory;

use UkalaTest\Framework\TestCase,
    Ukala\Mapping\ClassMetadataFactory\Standard,
    Doctrine\Common\Cache\ArrayCache;

abstract class AbstractFactory extends TestCase
{

    abstract public function getLoader();
    abstract public function getClass();
    abstract public function getProxyClass();

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

    public function testGetClassMetadataWithClassName()
    {
        $class = $this->getClass();
        $className = get_class($class);
        $classMetadata = $this->_standard->getClassMetadata($className);

        $this->assertInstanceOf(
            'Ukala\Mapping\ClassMetadata',
            $classMetadata
        );
    }

    public function testGetClassMetadataWithObject()
    {
        $classMetadata = $this->_standard->getClassMetadata($this->getClass());

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

    public function testGetClassNameWithNormalClass()
    {
        $class = $this->getClass();

        $this->assertEquals(get_class($class), $this->_standard->getClassName($class));
    }

    public function testGetClassNameWithProxyClass()
    {
        $class = $this->getProxyClass();

        $this->assertEquals(get_parent_class($class), $this->_standard->getClassName($class));
    }

    public function testGetClassMetadataWithProxyClass()
    {
        $object = $this->getProxyClass();
        $this->assertNull($object->getValueForLoad());

        $className = get_class($object);
        $parentClassName = get_parent_class($object);
        $classMetadata = $this->_standard->getClassMetadata($object);
        $loadedClass = $this->_standard->getLoadedClasses();

        $this->assertNotNull($object->getValueForLoad());
        $this->assertArrayHasKey($parentClassName, $loadedClass);
        $this->assertArrayNotHasKey($className, $loadedClass);
    }

}