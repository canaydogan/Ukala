<?php

namespace UkalaTest;

use UkalaTest\Framework\TestCase,
    Ukala\ObjectFilter;

class ObjectFilterTest extends TestCase
{

    protected $_filter;
    protected $_annotatedCLass;

    public function setUp()
    {
        parent::setUp();
        $this->_filter = new ObjectFilter($this->getStandardClassMetadataFactory());
        $this->_annotatedCLass = $this->getAnnotatedClass();
    }

    public function testCreation()
    {
        $this->assertInstanceOf('Zend\Filter\FilterInterface', $this->_filter);
    }

    public function testForNameWithNoNeedFilterValue()
    {
        $this->_annotatedCLass->setName('can');
        $this->_filter->filter($this->_annotatedCLass);

        $this->assertEquals(
            'can',
            $this->_annotatedCLass->getName()
        );
    }

    public function testFilterForNameWithNeedFilterValue()
    {
        $this->_annotatedCLass->setName('CAN');
        $this->_filter->filter($this->_annotatedCLass);

        $this->assertEquals(
            'can',
            $this->_annotatedCLass->getName()
        );
    }

    public function testFilterForGetDummyMixedStringWithNeedNoNeedFilterValue()
    {
        $this->_annotatedCLass->getDummyMixedString('can');
        $this->_filter->filter($this->_annotatedCLass);

        $this->assertEquals(
            'can',
            $this->_annotatedCLass->getDummyMixedString()
        );
    }


    public function testFilterForGetDummyMixedStringWithNeedNeedFilterValue()
    {
        $this->_annotatedCLass->getDummyMixedString('CAN');
        $this->_filter->filter($this->_annotatedCLass);

        $this->assertEquals(
            'can',
            $this->_annotatedCLass->getDummyMixedString()
        );
    }

    public function testFilterByLocatorWithNoNeedFilterValue()
    {
        $filter = $this->getServiceManager()->get('object_filter');

        $this->_annotatedCLass->getDummyMixedString('can');
        $filter->filter($this->_annotatedCLass);

        $this->assertEquals(
            'can',
            $this->_annotatedCLass->getDummyMixedString()
        );
    }

    public function testFilterByLocatorWithNeedFilterValue()
    {
        $filter = $this->getServiceManager()->get('object_filter');

        $this->_annotatedCLass->getDummyMixedString('CAN');
        $filter->filter($this->_annotatedCLass);

        $this->assertEquals(
            'can',
            $this->_annotatedCLass->getDummyMixedString()
        );
    }

    public function testFilterForLocatorCache()
    {
        $filter = $this->getServiceManager()->get('object_filter');
        $cache = $this->getServiceManager()->get('ukala_cache');

        $filter->filter($this->_annotatedCLass);

        $this->assertTrue($cache->contains(get_class($this->_annotatedCLass)));
    }

    public function testFilterForValueForNewNamingWithNeedFilterValue()
    {
        $this->_annotatedCLass->setValueForNewNaming('can');
        $this->_filter->filter($this->_annotatedCLass);

        $this->assertEquals(
            'CAN',
            $this->_annotatedCLass->getValueForNewNaming()
        );
    }

}