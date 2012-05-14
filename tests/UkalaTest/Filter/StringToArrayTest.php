<?php

namespace UkalaTest\Filter;

use UkalaTest\Framework\TestCase,
    Ukala\Filter\StringToArray;

class StringToArrayTest extends TestCase
{

    protected $_filter;

    public function setUp()
    {
        parent::setUp();
        $this->_filter = new StringToArray();
    }

    public function testCreation()
    {
        $this->assertInstanceOf(
            'Zend\Filter\Filter',
            $this->_filter
        );
    }

    public function testSetterAndGetter()
    {
        $this->_filter->setDelimiter(',');

        $this->assertEquals(',', $this->_filter->getDelimiter());
    }

    public function testSetOptionsViaConstructor()
    {
        $filter = new StringToArray(array('delimiter' => ','));

        $this->assertEquals(',', $filter->getDelimiter());
    }

    public function testSetOptions()
    {
        $this->_filter->setOptions(array('delimiter' => ','));

        $this->assertEquals(',', $this->_filter->getDelimiter());
    }

    public function testFilterWithValidValue()
    {
        $value = '1,2,3,4';
        $this->_filter->setDelimiter(',');

        $filteredValue = $this->_filter->filter($value);

        $this->assertCount(4, $filteredValue);
        $this->assertEquals('1', $filteredValue[0]);
        $this->assertEquals('2', $filteredValue[1]);
        $this->assertEquals('3', $filteredValue[2]);
        $this->assertEquals('4', $filteredValue[3]);
    }

    public function testFilterWithInvalidValues()
    {
        $this->_filter->setDelimiter(',');

        $value = null;
        $filteredValue = $this->_filter->filter($value);
        $this->assertNull($filteredValue);

        $value = '';
        $filteredValue = $this->_filter->filter($value);
        $this->assertCount(1, $filteredValue);

        $value = 'asdasd';
        $filteredValue = $this->_filter->filter($value);
        $this->assertCount(1, $filteredValue);

        $value = array(1, 2, 3);
        $filteredValue = $this->_filter->filter($value);
        $this->assertSame($value, $filteredValue);
    }

}
