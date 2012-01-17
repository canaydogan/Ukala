<?php

namespace UkalaTest\Mapping\Loader;

use UkalaTest\Framework\TestCase,
    Ukala\Mapping\Loader\AnnotationLoader;

class AnnotationLoaderTest extends TestCase
{

    protected $_annotationLoader;

    public function setUp()
    {
        $this->_annotationLoader = new AnnotationLoader(
            $this->getAnnotationReader()
        );
    }

    public function testCreation()
    {
        $this->assertInstanceOf(
            'Ukala\Mapping\Loader',
            $this->_annotationLoader
        );
    }

    public function testLoaderForMembersCount()
    {
        $classMetadata = $this->getAnnotatedClassMetadata();
        $this->assertEquals(0, count($classMetadata->getMembers()));
        $this->_annotationLoader->loadClassMetadata($classMetadata);
        $this->assertGreaterThan(0, count($classMetadata->getMembers()));
    }

    public function testIsValidatorWithValidValue()
    {
        $this->assertTrue(
            $this->_annotationLoader->isValidator($this->getNotEmptyValidator())
        );
    }

    public function testIsValidatorWithInvalidValue()
    {
        $this->assertFalse(
            $this->_annotationLoader->isValidator($this)
        );
    }

    public function testLoadClassMetadataWithClassValidators()
    {
        $classMetadata = $this->getAnnotatedClassMetadata();
        $this->assertEquals(0, count($classMetadata->getValidators()));
        $this->_annotationLoader->loadClassMetadata($classMetadata);
        $this->assertEquals(1, count($classMetadata->getValidators()));
    }

    public function testLoadClassMetadataWithPropertyValidators()
    {
        $classMetadata = $this->getAnnotatedClassMetadata();
        $this->_annotationLoader->loadClassMetadata($classMetadata);
        $members = $classMetadata->getMembers();
        $property = $members['email'][0];
        $this->assertEquals(2, count($property->getValidators()));
    }

    public function testLoadClassMetadataForMethodValidators()
    {
        $classMetadata = $this->getAnnotatedClassMetadata();
        $this->_annotationLoader->loadClassMetadata($classMetadata);
        $members = $classMetadata->getMembers();
        $method = $members['isPasswordConfirmed'][0];
        $this->assertEquals(1, count($method->getValidators()));
    }

    public function testIsFilterWithInvalidValue()
    {
        $this->assertFalse($this->_annotationLoader->isFilter(null));
    }

    public function testIsFilterWithValidFilter()
    {
        $this->assertTrue($this->_annotationLoader->isFilter(
            $this->getIntFilter()
        ));
    }

    public function testLoadClassMetadataWithClassFilters()
    {
        $classMetadata = $this->getAnnotatedClassMetadata();
        $this->assertEquals(0, count($classMetadata->getFilters()));
        $this->_annotationLoader->loadClassMetadata($classMetadata);
        $this->assertEquals(1, count($classMetadata->getFilters()));
    }

    public function testLoadClassMetadataWithPropertyFilters()
    {
        $classMetadata = $this->getAnnotatedClassMetadata();
        $this->_annotationLoader->loadClassMetadata($classMetadata);
        $members = $classMetadata->getMembers();
        $property = $members['_name'][0];
        $this->assertCount(1, $property->getFilters());
    }

    public function testLoadClassMetadataWithMethodFilters()
    {
        $classMetadata = $this->getAnnotatedClassMetadata();
        $this->_annotationLoader->loadClassMetadata($classMetadata);
        $members = $classMetadata->getMembers();
        $method = $members['getDummyMixedString'][0];
        $this->assertCount(1, $method->getFilters());
    }

}