<?php

namespace UkalaTest\Element;

use UkalaTest\Framework\TestCase,
    UkalaTest\Element\AbstractElement;

class AbstractElementTest extends AbstractElement
{

    public function getElementByOptions($options)
    {
        return $this->getMockForAbstractClass(
            'Ukala\Element\AbstractElement',
            array(
                'options' => $options
            )
        );
    }

    public function testGetterWithDefaultValues()
    {
        $this->assertInternalType('array', $this->_element->getValidators());
        $this->assertInternalType('array', $this->_element->getFilters());
    }

    public function testSetterAndGetter()
    {
        $this->_element->setName('name');
        $this->_element->setRequired(true);
        $this->_element->setWritable(true);
        $this->_element->setReadable(true);

        $this->assertEquals('name', $this->_element->getName());
        $this->assertTrue($this->_element->isRequired());
        $this->assertTrue($this->_element->isWritable());
        $this->assertTrue($this->_element->isReadable());
    }

    public function testAddValidator()
    {
        $this->assertCount(0, $this->_element->getValidators());

        $validator = $this->getNotEmptyValidator();
        $this->_element->addValidator($validator);

        $validators = $this->_element->getValidators();
        $this->assertCount(1, $validators);
        $this->assertSame($validator, $validators[0]);
    }

    public function testAddFilter()
    {
        $this->assertCount(0, $this->_element->getValidators());

        $filter = $this->getIntFilter();
        $this->_element->addFilter($filter);

        $filters = $this->_element->getFilters();
        $this->assertCount(1, $filters);
        $this->assertSame($filter, $filters[0]);
    }

}
