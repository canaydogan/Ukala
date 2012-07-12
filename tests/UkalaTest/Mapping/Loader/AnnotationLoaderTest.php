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

    public function testLoadClassMetadataWithClassValidatorsForElement()
    {
        $classMetadata = $this->getAnnotatedClassMetadata();
        $this->_annotationLoader->loadClassMetadata($classMetadata);
        $element = $classMetadata->getElement();
        $this->assertEquals(1, count($element->getValidators()));
    }

    public function testLoadClassMetadataWithPropertyValidators()
    {
        $classMetadata = $this->getAnnotatedClassMetadata();
        $this->_annotationLoader->loadClassMetadata($classMetadata);
        $members = $classMetadata->getMembers();
        $property = $members['email'][0];
        $this->assertEquals(2, count($property->getValidators()));
    }

    public function testLoadClassMetadataWithPropertyValidatorsViaElement()
    {
        $classMetadata = $this->getAnnotatedClassMetadata();
        $this->_annotationLoader->loadClassMetadata($classMetadata);
        $members = $classMetadata->getMembers();
        $element = $members['_valueForNewNaming'][0];
        $this->assertEquals(1, count($element->getElement()->getFilters()));
    }

    public function testLoadClassMetadataWithPropertyValidatorsForElement()
    {
        $classMetadata = $this->getAnnotatedClassMetadata();
        $this->_annotationLoader->loadClassMetadata($classMetadata);
        $members = $classMetadata->getMembers();
        $element = $members['email'][0]->getElement();
        $this->assertEquals(2, count($element->getValidators()));
    }

    public function testLoadClassMetadataForMethodValidators()
    {
        $classMetadata = $this->getAnnotatedClassMetadata();
        $this->_annotationLoader->loadClassMetadata($classMetadata);
        $members = $classMetadata->getMembers();
        $method = $members['isPasswordConfirmed'][0];
        $this->assertEquals(1, count($method->getValidators()));
    }

    public function testLoadClassMetadataForMethodValidatorsForElement()
    {
        $classMetadata = $this->getAnnotatedClassMetadata();
        $this->_annotationLoader->loadClassMetadata($classMetadata);
        $members = $classMetadata->getMembers();
        $element = $members['isPasswordConfirmed'][0]->getElement();
        $this->assertEquals(1, count($element->getValidators()));
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

    public function testLoadClassMetadataWithClassFiltersForElement()
    {
        $classMetadata = $this->getAnnotatedClassMetadata();
        $this->_annotationLoader->loadClassMetadata($classMetadata);
        $element = $classMetadata->getElement();
        $this->assertEquals(1, count($element->getFilters()));
    }

    public function testLoadClassMetadataWithPropertyFilters()
    {
        $classMetadata = $this->getAnnotatedClassMetadata();
        $this->_annotationLoader->loadClassMetadata($classMetadata);
        $members = $classMetadata->getMembers();
        $property = $members['_name'][0];
        $this->assertCount(1, $property->getFilters());
    }

    public function testLoadClassMetadataWithPropertyFiltersViaElement()
    {
        $classMetadata = $this->getAnnotatedClassMetadata();
        $this->_annotationLoader->loadClassMetadata($classMetadata);
        $members = $classMetadata->getMembers();
        $element = $members['_valueForNewNaming'][0]->getElement();
        $this->assertCount(1, $element->getFilters());
    }

    public function testLoadClassMetadataWithPropertyFiltersForElement()
    {
        $classMetadata = $this->getAnnotatedClassMetadata();
        $this->_annotationLoader->loadClassMetadata($classMetadata);
        $members = $classMetadata->getMembers();
        $element = $members['_name'][0]->getElement();
        $this->assertCount(1, $element->getFilters());
    }

    public function testLoadClassMetadataWithMethodFilters()
    {
        $classMetadata = $this->getAnnotatedClassMetadata();
        $this->_annotationLoader->loadClassMetadata($classMetadata);
        $members = $classMetadata->getMembers();
        $method = $members['getDummyMixedString'][0];
        $this->assertCount(1, $method->getFilters());
    }

    public function testLoadClassMetadataWithMethodFiltersForElement()
    {
        $classMetadata = $this->getAnnotatedClassMetadata();
        $this->_annotationLoader->loadClassMetadata($classMetadata);
        $members = $classMetadata->getMembers();
        $element = $members['getDummyMixedString'][0]->getElement();
        $this->assertCount(1, $element->getFilters());
    }

    public function testIsElementWithInvalidElement()
    {
        $this->assertFalse($this->_annotationLoader->isElement(null));
    }

    public function testIsElementWithValidElement()
    {
        $this->assertTrue($this->_annotationLoader->isElement(
            $this->newPropertyElement()
        ));
    }

    public function testElementForClass()
    {
        $classMetadata = $this->getAnnotatedClassMetadata();
        $this->_annotationLoader->loadClassMetadata($classMetadata);
        $element = $classMetadata->getElement();

        $this->assertTrue($element->isReadable());
        $this->assertTrue($element->isWritable());
        $this->assertFalse($element->isRequired());
        $this->assertEquals('className', $element->getName());
    }

    public function testElementForOriginalClassName()
    {
        $classMetadata = $this->getAnnotated2ClassMetadata();
        $this->_annotationLoader->loadClassMetadata($classMetadata);
        $element = $classMetadata->getElement();

        $this->assertEquals(
            'UkalaTest\Assets\Classes\AnnotatedClass2',
            $element->getName()
        );
    }

    public function testElementForProperty()
    {
        $classMetadata = $this->getAnnotatedClassMetadata();
        $this->_annotationLoader->loadClassMetadata($classMetadata);
        $members = $classMetadata->getMembers();
        $element = $members['_name'][0]->getElement();

        $this->assertTrue($element->isReadable());
        $this->assertTrue($element->isWritable());
        $this->assertTrue($element->isRequired());
        $this->assertEquals('newName', $element->getName());

        $element = $members['email'][0]->getElement();
        $this->assertEquals('email', $element->getName());
    }

    public function testElementWithPropertyForNewNaming()
    {
        $classMetadata = $this->getAnnotatedClassMetadata();
        $this->_annotationLoader->loadClassMetadata($classMetadata);
        $members = $classMetadata->getMembers();
        $element = $members['_valueForNewNaming'][0]->getElement();

        $this->assertTrue($element->isReadable());
        $this->assertTrue($element->isWritable());
        $this->assertTrue($element->isRequired());
        $this->assertEquals('valueForNewNaming', $element->getName());
    }

    public function testElementForMethod()
    {
        $classMetadata = $this->getAnnotatedClassMetadata();
        $this->_annotationLoader->loadClassMetadata($classMetadata);
        $members = $classMetadata->getMembers();
        $element = $members['getDummyMixedString'][0]->getElement();

        $this->assertTrue($element->isReadable());
        $this->assertFalse($element->isWritable());
        $this->assertFalse($element->isRequired());
        $this->assertEquals('newGetDummyMixedString', $element->getName());

        $element = $members['isPasswordConfirmed'][0]->getElement();

        $this->assertEquals('isPasswordConfirmed', $element->getName());
    }

    public function testIsLocatorProxyValidValue()
    {
        $this->assertTrue($this->_annotationLoader->isLocatorProxy(
            $this->newStandardLocatorProxy()
        ));
    }

    public function testIsLocatorProxyInvalidValue()
    {
        $this->assertFalse($this->_annotationLoader->isLocatorProxy(
            $this
        ));
    }

    public function testAnnotationLoaderNoViaLocator()
    {
        $this->assertNull($this->_annotationLoader->getLocator());
    }

    public function testAnnotationLoaderViaLocator()
    {
        $annotationLoader = $this->getLocator()->get('ukala_loader');

        $this->assertNotNull($annotationLoader->getLocator());
        $this->assertSame($this->getLocator(), $annotationLoader->getLocator());
    }

    public function testElementForPropertyViaLocatorProxy()
    {
        $classMetadata = $this->getAnnotatedClassMetadata();
        $this->getLocator()->get('ukala_loader')->loadClassMetadata($classMetadata);
        $members = $classMetadata->getMembers();
        $element = $members['username'][0]->getElement();

        $this->assertTrue($element->isReadable());
        $this->assertTrue($element->isWritable());
    }

    public function testElementForMethodViaLocatorProxy()
    {
        $classMetadata = $this->getAnnotatedClassMetadata();
        $this->getLocator()->get('ukala_loader')->loadClassMetadata($classMetadata);
        $members = $classMetadata->getMembers();
        $element = $members['getUsername'][0]->getElement();

        $this->assertTrue($element->isReadable());
        $this->assertTrue($element->isWritable());
    }

    public function testFilterForClassViaLocatorProxy()
    {
        $classMetadata = $this->getAnnotatedClassMetadata();
        $this->getLocator()->get('ukala_loader')->loadClassMetadata($classMetadata);
        $filters = $classMetadata->getFilters();

        $this->assertCount(2, $filters);
        $this->assertInstanceOf('Zend\Filter\Alnum', $filters[1]);
    }

}