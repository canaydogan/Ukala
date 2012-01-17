<?php

namespace UkalaTest;

use UkalaTest\Framework\TestCase,
    Ukala\ObjectFilter;

class ObjectFilterTest extends TestCase
{

    protected $_filter;

    public function setUp()
    {
        parent::setUp();
        $this->_filter = new ObjectFilter($this->getStandardClassMetadataFactory());
    }

    public function testCreation()
    {
        $this->assertInstanceOf('Zend\Filter\Filter', $this->_filter);
    }

}
