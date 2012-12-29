<?php

namespace UkalaTest\LocatorProxy;

use UkalaTest\Framework\TestCase;
use Ukala\LocatorProxy\ServiceLocatorProxy;
use UkalaTest\Assets\Classes\ClassForLocatorProxy;
use Zend\ServiceManager\ServiceManager;

class ServiceLocatorProxyTest extends TestCase
{

    protected $_proxy;

    protected $_locator;

    public function setUp()
    {
        $this->_locator = new ServiceManager();
        $this->_locator->setFactory(
            'UkalaTest\Assets\Classes\ClassForLocatorProxy',
            function ($sm) {
                $object = new ClassForLocatorProxy();
                $object->setName('foobar');
                $object->setType('foo');

                return $object;
            }
        );

        $this->_proxy = new ServiceLocatorProxy();
        $this->_proxy->setOptions(array(
            'name' => 'UkalaTest\Assets\Classes\ClassForLocatorProxy'
        ));
    }

    public function testCreation()
    {
        $proxy = new ServiceLocatorProxy();
        $options = $proxy->getOptions();

        $this->assertNull($options['name']);
        $this->assertInternalType('array', $options['params']);
        $this->assertCount(0, $options['params']);
    }

    public function testSetterAndGetter()
    {
        $proxy = new ServiceLocatorProxy();
        $params = array(1, 2, 3);

        $proxy->setOptions(array(
            'name' => 'testname',
            'params' => $params
        ));

        $options = $proxy->getOptions();
        $this->assertEquals('testname', $options['name']);
        $this->assertSame($params, $options['params']);
    }

    public function testOptionsViaConstructor()
    {
        $params  = array('param' => 'value');
        $proxy = new ServiceLocatorProxy(array('params' => $params));

        $options = $proxy->getOptions();
        $this->assertSame($params, $options['params']);
    }

    public function testInstanceSetParams()
    {
        $instance = new ClassForLocatorProxy();
        $this->_proxy->setInstanceParams($instance, array(
            'name' => 'Smith',
            'Type' => 'Ajan',
            'invalid' => 'invalid value'
        ));

        $this->assertEquals('Smith', $instance->getName());
        $this->assertEquals('Ajan', $instance->getType());
    }

    public function testDoProxyViaGetWithNoParams()
    {
        $result = $this->_proxy->doProxy($this->_locator);

        $this->assertEquals('foo', $result->getType());
        $this->assertEquals('foobar', $result->getName());

        $result->setType('new foo');
        $result = $this->_proxy->doProxy($this->_locator);

        $this->assertEquals('new foo', $result->getType());
    }

    public function testDoProxyViaGetWithParams()
    {
        $this->_proxy->setOptions(array(
            'params' => array(
                'type' => 'new foo'
            )
        ));
        $result = $this->_proxy->doProxy($this->_locator);

        $this->assertEquals('new foo', $result->getType());
        $this->assertEquals('foobar', $result->getName());
    }

}