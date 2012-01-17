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

    public function testHasNoValidators()
    {
        $this->assertFalse($this->_abstractMetadata->hasValidators());
    }

}