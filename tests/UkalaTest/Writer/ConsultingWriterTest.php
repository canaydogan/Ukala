<?php

namespace UkalaTest\Writer;

use UkalaTest\Framework\TestCase,
    Ukala\Writer\ConsultingWriter;

class ConsultingWriterTest extends TestCase
{

    protected $_writer;

    public function setUp()
    {
        parent::setUp();
        $this->_writer = new ConsultingWriter($this->getStandardClassMetadataFactory());
    }

    public function testCreation()
    {
        $this->assertInstanceOf(
            'Ukala\Writer',
            $this->_writer
        );
    }

    public function testAddConsultant()
    {
        $consultant = $this->newBasicConsultant();

        $this->_writer->addConsultant($consultant);
        $consultants = $this->_writer->getConsultants();

        $this->assertCount(1, $consultants);
        $this->assertSame($consultant, $consultants[0]);
    }

    public function testHasConsultants()
    {
        $consultant = $this->newBasicConsultant();

        $this->assertFalse($this->_writer->hasConsultants());

        $this->_writer->addConsultant($consultant);

        $this->assertTrue($this->_writer->hasConsultants());
    }

    public function testWriteWithValuesForObject()
    {
        $object = $this->getAnnotatedClass();
        $values = array(
            'newName' => 'Can Aydogan',
            'email' => 'canaydogan89@gmail.com'
        );

        $result = $this->_writer->write($values, $object);

        $this->assertSame($result, $object);
        $this->assertEquals('Can Aydogan', $object->getName());
        $this->assertNull($object->getEmail());
    }


    public function testWriteWithValuesForNotWritableObject()
    {
        $object = $this->newAnnotatedClass2();
        $values = array(
            'newName' => 'Can Aydogan',
        );

        $this->_writer->write($values, $object);

        $this->assertNull($object->getName());
    }

    public function testWriteWithValuesForConsultants()
    {
        $this->_writer->addConsultant($this->newBasicConsultant());
        $object = $this->getAnnotatedClass();

        $values = array(
            'newName' => 'forConsultant'
        );

        $this->_writer->write($values, $object);

        $this->assertNull($object->getName());
    }

    public function testReadWithLocator()
    {
        $writer = $this->getLocator()->get('object_writer');
        $object = $this->getAnnotatedClass();
        $values = array(
            'newName' => 'Can Aydogan',
            'email' => 'canaydogan89@gmail.com'
        );

        $result = $writer->write($values, $object);

        $this->assertSame($result, $object);
        $this->assertEquals('Can Aydogan', $object->getName());
        $this->assertNull($object->getEmail());
    }

    public function testWriteForLocatorCache()
    {
        $object = $this->getAnnotatedClass();

        $writer = $this->getLocator()->get('object_writer');
        $cache = $this->getLocator()->get('ukala_cache');

        $writer->write(array(), $object);

        $this->assertTrue($cache->contains(get_class($object)));
    }

}