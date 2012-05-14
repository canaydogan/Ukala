<?php

namespace UkalaTest\Element;

use UkalaTest\Framework\TestCase;

abstract class AbstractElement extends TestCase
{

    abstract public function getElementByOptions($options);

    public function setUp()
    {
        parent::setUp();
        $this->_element = $this->getElementByOptions(array());
    }

    public function testConstructorWithOptions()
    {
        $options = array(
            'required' => true,
            'readable' => true,
            'writable' => true,
            'name' => 'name'
        );

        $element = $this->getElementByOptions($options);

        $this->assertTrue($element->isRequired());
        $this->assertTrue($element->isReadable());
        $this->assertTrue($element->isWritable());
        $this->assertEquals('name', $element->getName());
    }

    public function testConstructorForAnnotationReader()
    {
        $options = array(
            'value' => array(
                'required' => true,
                'readable' => true,
                'writable' => true,
                'name' => 'name'
            )
        );

        $element = $this->getElementByOptions($options);

        $this->assertTrue($element->isRequired());
        $this->assertTrue($element->isReadable());
        $this->assertTrue($element->isWritable());
        $this->assertEquals('name', $element->getName());
    }

}
