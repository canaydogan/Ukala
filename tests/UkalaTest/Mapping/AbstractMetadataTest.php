<?php

use UkalaTest\Framework\TestCase;

class AbstractMetadataTest extends TestCase
{

    protected $_abstractMetadata;

    public function setUp()
    {
        parent::setUp();
        $this->_abstractMetadata = $this->getMockForAbstractClass(
            'Ukala\Mapping\AbstractMetadata'
        );
    }

    public function testGetterForDefaultValues()
    {
        $this->assertInternalType('array', $this->_abstractMetadata->getValidators());
        $this->assertInternalType('array', $this->_abstractMetadata->getFilters());
    }

    public function testSetterAndGetter()
    {
        $validators = array($this->getNotEmptyValidator());
        $filters = array($this->getIntFilter());
        $element  = $this->newPropertyElement();

        $this->_abstractMetadata->setValidators($validators);
        $this->_abstractMetadata->setFilters($filters);
        $this->_abstractMetadata->setElement($element);
        $this->_abstractMetadata->setName('name');

        $this->assertSame($validators, $this->_abstractMetadata->getValidators());
        $this->assertSame($filters, $this->_abstractMetadata->getFilters());
        $this->assertSame($element, $this->_abstractMetadata->getElement());
        $this->assertEquals('name', $this->_abstractMetadata->getName());
    }

    public function testAddValidator()
    {
        $validator = $this->getNotEmptyValidator();
        $this->_abstractMetadata->addValidator($validator);

        $this->assertEquals(1, count($this->_abstractMetadata->getValidators()));
    }

    public function testAddValidators()
    {
        $validators = array(
            $this->getNotEmptyValidator(),
            $this->getNotEmptyValidator()
        );

        $this->_abstractMetadata->addValidators($validators);
        $this->assertEquals(2, count($this->_abstractMetadata->getValidators()));
    }

    public function testHasValidatorsWithNoValidators()
    {
        $this->assertFalse($this->_abstractMetadata->hasValidators());
    }

    public function testHasValidatorsWithValidator()
    {
        $this->_abstractMetadata->addValidator($this->getNotEmptyValidator());
        $this->assertTrue($this->_abstractMetadata->hasValidators());
    }

    public function testAddFilter()
    {
        $filter = $this->getIntFilter();


        $this->assertCount(0, $this->_abstractMetadata->getFilters());

        $this->_abstractMetadata->addFilter($filter);

        $filters = $this->_abstractMetadata->getFilters();

        $this->assertCount(1, $filters);
        $this->assertSame($filter, $filters[0]);
    }

    public function testAddFilters()
    {
        $filters = array(
            $this->getIntFilter(),
            $this->getIntFilter()
        );

        $this->assertCount(0, $this->_abstractMetadata->getFilters());

        $this->_abstractMetadata->addFilters($filters);

        $_filters = $this->_abstractMetadata->getFilters();

        $this->assertCount(2, $_filters);
        $this->assertSame($filters[0], $filters[0]);
    }

    public function testHasFiltersWithNoFilters()
    {
        $this->assertFalse($this->_abstractMetadata->hasFilters());
    }

    public function testHasFiltersWithFilter()
    {
        $this->_abstractMetadata->addFilter($this->getIntFilter());
        $this->assertTrue($this->_abstractMetadata->hasFilters());
    }

    public function testGetElementWithDefinedElement()
    {
        $property = $this->newPropertyElement();
        $this->_abstractMetadata->setElement($property);

        $this->assertSame($property, $this->_abstractMetadata->getElement());
    }

    public function testGetElementWithUndefinedElement()
    {
        $this->_abstractMetadata->expects($this->once())
                                ->method('newElement')
                                ->will($this->returnValue($this->newPropertyElement()));

        $this->assertInstanceOf(
            'Ukala\Element\AbstractElement',
            $this->_abstractMetadata->getElement()
        );
    }

}