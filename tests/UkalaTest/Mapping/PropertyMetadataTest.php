<?php

namespace UkalaTest\Mapping;

use UkalaTest\Framework\TestCase,
    Ukala\Mapping\PropertyMetadata,
    ReflectionClass;

class PropertyMetadataTest extends  TestCase
{

    protected $_propertyMetadata;
    protected $_annotatedClass;
    protected $_property;

    public function setUp()
    {
        parent::setUp();
        $this->_annotatedClass = $this->getAnnotatedClass();
        $className = get_class($this->_annotatedClass);
        $reflectionClass = new ReflectionClass($this->_annotatedClass);
        $properties = $reflectionClass->getProperties();
        $this->_property = $properties[0];

        $this->_propertyMetadata = new PropertyMetadata($className, $this->_property->getName());
    }

    public function testConstructorWithInvalidProperty()
    {
        $this->setExpectedException('InvalidArgumentException');

        $annotatedClass = $this->getAnnotatedClass();
        $className = get_class($annotatedClass);

        $this->_propertyMetadata = new PropertyMetadata($className, 'invalidProperty');
    }

    public function testNewReflectionMemberMethod()
    {
        $this->assertInstanceOf(
            'ReflectionProperty',
            $this->_propertyMetadata->newReflectionMember()
        );
    }

    public function testGetValueWithObject()
    {
        $setterMethodName = 'set' . ucfirst(str_replace('_', '', $this->_property->getName()));
        $this->_annotatedClass->{$setterMethodName}('test value');
        $this->assertEquals(
            'test value',
            $this->_propertyMetadata->getValue($this->_annotatedClass)
        );
    }

}
