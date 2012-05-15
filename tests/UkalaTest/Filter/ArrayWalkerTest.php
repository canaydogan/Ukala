<?php

namespace UkalaTest\Filter;

use UkalaTest\Framework\TestCase,
    Ukala\Filter\ArrayWalker,
    Ukala\Filter\StringToUpper;

class ArrayWalkerTest extends TestCase
{

    protected $_filter;

    public function setUp()
    {
        parent::setUp();
        $this->_filter = new ArrayWalker();
    }

    public function testCreation()
    {
        $this->assertInstanceOf(
            'Zend\Filter\FilterInterface',
            $this->_filter
        );
    }

    public function testSetterAndGetter()
    {
        $filter = new StringToUpper();
        $this->_filter->setFilter($filter);

        $this->assertSame($filter, $this->_filter->getFilter());
    }

    public function testSetOptions()
    {
        $filter = new StringToUpper();
        $this->_filter->setOptions(array('filter' => $filter));

        $this->assertSame($filter, $this->_filter->getFilter());
    }

    public function testSetOptionsViaConstructor()
    {
        $_filter = new StringToUpper();
        $filter = new ArrayWalker(array('filter' => $_filter));

        $this->assertSame($_filter, $filter->getFilter());
    }

    public function testFilterWithValidValues()
    {
        $value = array(
            'abc',
            'def'
        );
        $this->_filter->setFilter(new StringToUpper());

        $filteredValue = $this->_filter->filter($value);
        $this->assertCount(2, $filteredValue);
        $this->assertEquals('ABC', $filteredValue[0]);
        $this->assertEquals('DEF', $filteredValue[1]);
    }

    public function testFilterWithInvalidValues()
    {
        $this->_filter->setFilter(new StringToUpper());

        $value = array();
        $filteredValue = $this->_filter->filter($value);
        $this->assertCount(0, $filteredValue);

        $value = array('ABC');
        $filteredValue = $this->_filter->filter($value);
        $this->assertCount(1, $filteredValue);
        $this->assertEquals('ABC', $filteredValue[0]);
    }

}
