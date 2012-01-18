<?php

namespace UkalaTest\Mapping;

use UkalaTest\Framework\TestCase,
    Ukala\Mapping\MethodMetadata,
    ReflectionClass;

class MethodMetadataTest extends TestCase
{

    protected $_methodMetadata;
    protected $_annotatedClass;
    protected $_method;

    public function setUp()
    {
        parent::setUp();
        $this->_annotatedClass = $this->getAnnotatedClass();
        $className = get_class($this->_annotatedClass);
        $reflectionClass = new ReflectionClass($this->_annotatedClass);
        $this->_method = 'getName';

        $this->_methodMetadata = new MethodMetadata($className, $this->_method);
    }

    public function testConstructorWithInvalidMethod()
    {
        $this->setExpectedException('InvalidArgumentException');

        $annotatedClass = $this->getAnnotatedClass();
        $className = get_class($annotatedClass);

        $methodMetadata = new MethodMetadata($className, 'invalidMethod');
    }

    public function testNewReflectionMemberMethod()
    {
        $this->assertInstanceOf(
            'ReflectionMethod',
            $this->_methodMetadata->newReflectionMember()
        );
    }

    public function testGetValueWithObject()
    {
        $this->_annotatedClass->setName('test value');

        $this->assertEquals(
            'test value',
            $this->_methodMetadata->getValue($this->_annotatedClass)
        );
    }

    public function testSetValueWithObject()
    {
        $className = get_class($this->_annotatedClass);
        $metadata = new MethodMetadata($className, 'getDummyMixedString');

        $metadata->setValue($this->_annotatedClass, 'value for set');
        $this->assertEquals('value for set', $this->_annotatedClass->getDummyMixedString());
    }

}