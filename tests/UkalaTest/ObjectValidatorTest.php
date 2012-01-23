<?php

namespace UkalaTest;

use UkalaTest\Framework\TestCase,
    Ukala\ObjectValidator;

class ObjectValidatorTest extends TestCase
{

    protected $_validator;

    public function setUp()
    {
        parent::setUp();
        $this->_validator = new ObjectValidator($this->getStandardClassMetadataFactory());
    }

    public function testCreation()
    {
        $this->assertInstanceOf('Zend\Validator\Validator', $this->_validator);
    }

    public function testAddMessageWithNoExistKey()
    {
        $this->_validator->addMessage('key', 'message');

        $messages = $this->_validator->getMessages();

        $this->assertEquals(1, count($messages['key']));
        $this->assertEquals($messages['key'][0], 'message');
    }

    public function testAddMessageWithExistKey()
    {
        $this->_validator->addMessage('key', 'message1');
        $this->_validator->addMessage('key', 'message2');

        $messages = $this->_validator->getMessages();

        $this->assertEquals(2, count($messages['key']));
        $this->assertEquals($messages['key'][0], 'message1');
        $this->assertEquals($messages['key'][1], 'message2');
    }

    public function testResetMessages()
    {
        $this->_validator->addMessage('key', 'message');
        $this->assertEquals(1, count($this->_validator->getMessages()));
        $this->_validator->resetMessages();
        $this->assertEquals(0, count($this->_validator->getMessages()));
    }

    public function testResetWithMessages()
    {
        $this->_validator->addMessage('key', 'message');
        $this->assertEquals(1, count($this->_validator->getMessages()));
        $this->_validator->reset();
        $this->assertEquals(0, count($this->_validator->getMessages()));
    }

    public function testIsValidWithValidObject()
    {
        $validObject = $this->getAnnotatedClassWithValidValues();
        $this->assertTrue($this->_validator->isValid($validObject));
        $this->assertEquals(0, count($this->_validator->getMessages()));
    }

    public function testIsValidWithInvalidName()
    {
        $invalidObject = $this->getAnnotatedClassWithValidValues();
        $invalidObject->setName(null);
        $this->assertFalse($this->_validator->isValid($invalidObject));

        $messages = $this->_validator->getMessages();
        $this->assertEquals(1, count($messages['_name']));
        $this->assertEquals(1, count($messages));
    }

    public function testIsValidWithInvalidPassword()
    {
        $invalidObject = $this->getAnnotatedClassWithValidValues();
        $invalidObject->setPassword('123');
        $this->assertFalse($this->_validator->isValid($invalidObject));

        $messages = $this->_validator->getMessages();
        $this->assertEquals(1, count($messages['_password']));

        $invalidObject->setPassword('123456789');
        $this->assertFalse($this->_validator->isValid($invalidObject));
        $messages = $this->_validator->getMessages();
        $this->assertEquals(1, count($messages['_password']));
    }

    public function testIsValidWithInvalidEmail()
    {
        $invalidObject = $this->getAnnotatedClassWithValidValues();
        $invalidObject->setEmail(null);
        $this->assertFalse($this->_validator->isValid($invalidObject));

        $messages = $this->_validator->getMessages();
        $this->assertEquals(2, count($messages['email']));

        $invalidObject->setEmail('invaliemailaddress');
        $this->assertFalse($this->_validator->isValid($invalidObject));

        $messages = $this->_validator->getMessages();
        $this->assertEquals(1, count($messages['email']));
    }

    public function testIsValidWithInvalidConfirmPassword()
    {
        $invalidObject = $this->getAnnotatedClassWithValidValues();
        $invalidObject->setConfirmPassword('wrongconfirmpassword');

        $this->assertFalse($this->_validator->isValid($invalidObject));
        $messages = $this->_validator->getMessages();
        $this->assertEquals(1, count($messages['isPasswordConfirmed']));
    }

    public function testIsValidWithLocator()
    {
        $validObject = $this->getAnnotatedClassWithValidValues();

        $validator = $this->getLocator()->get('object_validator');
        $this->assertTrue($validator->isValid($validObject));
        $this->assertEquals(0, count($validator->getMessages()));
    }

    public function testIsValidForLocatorCache()
    {
        $validObject = $this->getAnnotatedClassWithValidValues();

        $validator = $this->getLocator()->get('object_validator');
        $cache = $this->getLocator()->get('ukala_cache');

        $this->assertTrue($validator->isValid($validObject));

        $this->assertTrue($cache->contains(get_class($validObject)));
    }

    public function testIsValidWithNullPhone()
    {
        $validObject = $this->getAnnotatedClassWithValidValues();
        $validObject->setPhone(null);

        $this->assertTrue($this->_validator->isValid($validObject));
    }

    public function testIsValidWithEmptyPhone()
    {
        $validObject = $this->getAnnotatedClassWithValidValues();
        $validObject->setPhone('');

        $this->assertTrue($this->_validator->isValid($validObject));
    }

    public function testIsValidWithInvalidPhone()
    {
        $validObject = $this->getAnnotatedClassWithValidValues();
        $validObject->setPhone('123');

        $this->assertFalse($this->_validator->isValid($validObject));
    }

    public function testIsValidForNoHasValidatorWithNullCountry()
    {
        $validObject = $this->getAnnotatedClassWithValidValues();
        $validObject->setCountry(null);

        $this->assertFalse($this->_validator->isValid($validObject));
    }

    public function testIsValidForNoHasValidatorWithEmptyCountry()
    {
        $validObject = $this->getAnnotatedClassWithValidValues();
        $validObject->setCountry('');

        $this->assertFalse($this->_validator->isValid($validObject));
    }

    public function testIsValidForNoHasValidatorWithValidCountry()
    {
        $validObject = $this->getAnnotatedClassWithValidValues();
        $validObject->setCountry('Turkey');

        $this->assertTrue($this->_validator->isValid($validObject));
    }

}
