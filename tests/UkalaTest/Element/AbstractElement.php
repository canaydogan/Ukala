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
            'writable' => true
        );

        $element = $this->getElementByOptions($options);

        $this->assertTrue($element->isRequired());
        $this->assertTrue($element->isReadable());
        $this->assertTrue($element->isWritable());
    }

}
