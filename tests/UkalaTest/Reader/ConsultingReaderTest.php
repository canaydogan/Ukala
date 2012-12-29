<?php

namespace UkalaTest\Reader;

use UkalaTest\Framework\TestCase,
    Ukala\Reader\ConsultingReader,
    Doctrine\Common\Collections\ArrayCollection;

class ConsultingReaderTest extends TestCase
{

    protected $_reader;

    public function setUp()
    {
        parent::setUp();
        $this->_reader = new ConsultingReader($this->getStandardClassMetadataFactory());
    }

    public function testCreation()
    {
        $this->assertInstanceOf(
            'Ukala\Reader',
            $this->_reader
        );
    }

    public function testAddConsultant()
    {
        $consultant = $this->newBasicConsultant();

        $this->_reader->addConsultant($consultant);
        $consultants = $this->_reader->getConsultants();

        $this->assertCount(1, $consultants);
        $this->assertSame($consultant, $consultants[0]);
    }

    public function testHasConsultants()
    {
        $consultant = $this->newBasicConsultant();

        $this->assertFalse($this->_reader->hasConsultants());

        $this->_reader->addConsultant($consultant);

        $this->assertTrue($this->_reader->hasConsultants());
    }

    public function testReadWithObject()
    {
        $object = $this->getAnnotatedClass();

        $result = $this->_reader->read($object);

        $this->assertNotNull($result);
        $this->assertEquals($object->getName(), $result['newName']);
        $this->assertEquals($object->getEmail(), $result['email']);
        $this->assertEquals(
            $object->getDummyMixedString(),
            $result['newGetDummyMixedString']
        );
    }

    public function testReadWithObjectForSubClass()
    {
        $annotatedClass = $this->newValidAnnotatedClass3();
        $object = $this->getAnnotatedClass();
        $object->setAnnotatedClass($annotatedClass);

        $result = $this->_reader->read($object);

        $this->assertNotNull($result['annotatedClass']);
        $this->assertEquals($annotatedClass->getName(), $result['annotatedClass']['name']);
    }

    public function testReadWithObjects()
    {
        $objects = array(
            $this->getAnnotatedClass(),
            $this->getAnnotatedClass()
        );

        $result = $this->_reader->read($objects);

        $this->assertNotNull($result);
        $this->assertCount(2, $result);
        $this->assertEquals($objects[0]->getName(), $result[0]['newName']);
        $this->assertEquals($objects[0]->getEmail(), $result[0]['email']);
        $this->assertEquals(
            $objects[0]->getDummyMixedString(),
            $result[0]['newGetDummyMixedString']
        );
    }

    public function testReadWithArrayCollection()
    {
        $objects = new ArrayCollection(array(
            $this->getAnnotatedClass(),
            $this->getAnnotatedClass()
        ));

        $result = $this->_reader->read($objects);

        $this->assertNotNull($result);
        $this->assertCount(2, $result);
        $this->assertEquals($objects[0]->getName(), $result[0]['newName']);
        $this->assertEquals($objects[0]->getEmail(), $result[0]['email']);
        $this->assertEquals(
            $objects[0]->getDummyMixedString(),
            $result[0]['newGetDummyMixedString']
        );
    }

    public function testReadWithObjectsForConsultants()
    {
        $this->_reader->addConsultant($this->newBasicConsultant());

        $objects = array(
            $this->getAnnotatedClass(),
            $this->getAnnotatedClass()
        );
        $objects[0]->setName('forConsultant');

        $result = $this->_reader->read($objects);

        $this->assertNotNull($result);
        $this->assertCount(2, $result);
        $this->assertArrayNotHasKey('newName', $result[0]);
        $this->assertArrayHasKey('newName', $result[1]);
    }

    public function testReadWithNotReadableObject()
    {
        $result = $this->_reader->read($this->getAnnotatedClass2());

        $this->assertCount(0, $result);
    }

    public function testReadWithLocator()
    {
        $object = $this->getAnnotatedClassWithValidValues();

        $reader = $this->getServiceManager()->get('object_reader');

        $result = $this->_reader->read($object);

        $this->assertNotNull($result);
        $this->assertEquals($object->getName(), $result['newName']);
        $this->assertEquals($object->getEmail(), $result['email']);
        $this->assertEquals(
            $object->getDummyMixedString(),
            $result['newGetDummyMixedString']
        );
    }

    public function testReadForLocatorCache()
    {
        $object = $this->getAnnotatedClassWithValidValues();

        $reader = $this->getServiceManager()->get('object_reader');
        $cache = $this->getServiceManager()->get('ukala_cache');

        $reader->read($object);

        $this->assertTrue($cache->contains(get_class($object)));
    }

    public function testReadWithProxyObject()
    {
        $object = $this->newValidAnnotatedClassProxy();
        $result = $this->_reader->read($object);

        $this->assertNotNull($result);
        $this->assertEquals($object->getName(), $result['newName']);
        $this->assertEquals($object->getEmail(), $result['email']);
        $this->assertEquals(
            $object->getDummyMixedString(),
            $result['newGetDummyMixedString']
        );
    }

}