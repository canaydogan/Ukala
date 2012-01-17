<?php

namespace UkalaTest\Mapping;

use UkalaTest\Framework\TestCase,
    ReflectionClass;

class AbstractMemberMetadataTest extends TestCase
{

    protected $_abstractMemberMetadata;

    public function setUp()
    {
        parent::setUp();
        $annotatedClass = $this->getAnnotatedClass();
        $reflectionClass = new ReflectionClass($annotatedClass);
        $properties = $reflectionClass->getProperties();
        $property = $properties[0];

        $this->_abstractMemberMetadata = $this->getMockForAbstractClass(
            'Ukala\Mapping\AbstractMemberMetadata',
            array(
                'className' => get_class($annotatedClass),
                'name' => $property->getName(),
                'property' => $property->getName()
            )
        );
    }

    public function testConstructor()
    {
        $annotatedClass = $this->getAnnotatedClass();
        $className = get_class($annotatedClass);
        $reflectionClass = new ReflectionClass($annotatedClass);
        $properties = $reflectionClass->getProperties();
        $property = $properties[0];

        $abstractMemberData = $this->getMockForAbstractClass(
            'Ukala\Mapping\AbstractMemberMetadata',
            array(
                'className' => $className,
                'name' => $property->getName(),
                'property' => $property->getName()
            )
        );

        $this->assertEquals($className, $abstractMemberData->getClassName());
        $this->assertEquals($property->getName(), $abstractMemberData->getName());
        $this->assertEquals($property->getName(), $abstractMemberData->getProperty());
    }

    public function testAccessLevels()
    {
        $annotatedClass = $this->getAnnotatedClass();
        $reflectionClass = new ReflectionClass($annotatedClass);
        $className = get_class($annotatedClass);

        foreach ($reflectionClass->getProperties() as $property) {
            $abstractMemberData = $this->getMockForAbstractClass(
                'Ukala\Mapping\AbstractMemberMetadata',
                array(
                    'className' => $className,
                    'name' => $property->getName(),
                    'property' => $property->getName()
                )
            );
            $abstractMemberData->setReflectionMember($property);

            if ($property->isPublic()) {
                $this->assertTrue($abstractMemberData->isPublic());
            } elseif ($property->isProtected()) {
                $this->assertTrue($abstractMemberData->isProtected());
            } elseif ($property->isPrivate()) {
                $this->assertTrue($abstractMemberData->isPrivate());
            }
        }
    }

    public function testNullReflectionMember()
    {
        $this->_abstractMemberMetadata->expects($this->once())
                                      ->method('newReflectionMember');

        $this->_abstractMemberMetadata->getReflectionMember();
    }

}