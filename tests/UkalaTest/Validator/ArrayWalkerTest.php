<?php

namespace UkalaTest\Validator;

use UkalaTest\Framework\TestCase,
    Ukala\Validator\EmailAddress,
    Ukala\Validator\ArrayWalker;

class ArrayWalkerTest extends TestCase
{

    protected $_validator;

    public function setUp()
    {
        parent::setUp();
        $this->_validator = new ArrayWalker();
    }

    public function testCreation()
    {
        $this->assertInstanceOf(
            'Zend\Validator\Validator',
            $this->_validator
        );
        $this->assertInternalType('array', $this->_validator->getMessages());
    }

    public function testSetterAndGetter()
    {
        $validator = array();
        $this->_validator->setValidator($validator);

        $this->assertSame($validator, $this->_validator->getValidator());
    }

    public function testSetOptions()
    {
        $_validator = array();
        $this->_validator->setOptions(array('validator' => $_validator));

        $this->assertSame($_validator, $this->_validator->getValidator());
    }

    public function testSetOptionsViaConstructor()
    {
        $_validator = array();
        $validator = new ArrayWalker(array('validator' => $_validator));

        $this->assertSame($_validator, $validator->getValidator());
    }

    public function testIsValidWithValidValues()
    {
        $value = array(
            'canaydogan89@gmail.com',
            'canaydogan1905@hotmail.com'
        );
        $this->_validator->setValidator(new EmailAddress());

        $this->assertTrue($this->_validator->isValid($value));
    }

    public function testIsValidWithInvalidValues()
    {
        $value = array(
            'canaydogan89',
            'canaydogan1905@hotmail.com'
        );
        $this->_validator->setValidator(new EmailAddress());

        $this->assertFalse($this->_validator->isValid($value));
        $this->assertCount(1, $this->_validator->getMessages());
    }

}
