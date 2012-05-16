<?php

namespace UkalaTest\LocatorProxy;

use UkalaTest\Framework\TestCase,
    Ukala\LocatorProxy\StandardProxy,
    Zend\Di\Di;

class StandardProxyTest extends TestCase
{

    protected $_proxy;

    protected $_locator;

    public function setUp()
    {
        $this->_proxy = new StandardProxy();
        $this->_locator = new Di();
        $this->_locator->instanceManager()->setParameters(
            'UkalaTest\Assets\Classes\ClassForLocatorProxy',
            array(
                'type' => 'foo',
                'name' => 'foobar'
            )
        );
        $this->_proxy->setOptions(array(
            'name' => 'UkalaTest\Assets\Classes\ClassForLocatorProxy'
        ));
    }

    public function testCreation()
    {
        $this->assertInstanceOf(
            'Ukala\LocatorProxy\LocatorProxy',
            $this->_proxy
        );
    }

    public function testSetterAndGetter()
    {
        $proxy = new StandardProxy();
        $options = $proxy->getOptions();
        $this->assertNull($options['name']);
        $this->assertInternalType('array', $options['params']);
        $this->assertTrue($options['isShared']);
        $this->assertEquals('get', $options['method']);

        $options = array('method' => 'newInstance');
        $proxy->setOptions(array(
            'method' => 'newInstance'
        ));
        $options = $proxy->getOptions();

        $this->assertNull($options['name']);
        $this->assertInternalType('array', $options['params']);
        $this->assertTrue($options['isShared']);
        $this->assertEquals('newInstance', $options['method']);

        $proxy->setOptions(array(
            'value' => array('method' => 'newInstance')
        ));
        $options = $proxy->getOptions();

        $this->assertEquals('newInstance', $options['method']);
    }

    public function testOptionsViaConstructor()
    {
        $params  = array('param' => 'value');
        $proxy = new StandardProxy(array('params' => $params));

        $options = $proxy->getOptions();
        $this->assertSame($params, $options['params']);
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

    public function testDoProxyViaNewInstanceWithNoParams()
    {
        $this->_proxy->setOptions(array(
            'method' => 'newInstance'
        ));
        $result = $this->_proxy->doProxy($this->_locator);

        $this->assertEquals('foo', $result->getType());
        $this->assertEquals('foobar', $result->getName());

        $result->setType('new foo');
        $result = $this->_proxy->doProxy($this->_locator);

        $this->assertEquals('foo', $result->getType());
    }

    public function testDoProxyViaNewInstanceWithParams()
    {
        $this->_proxy->setOptions(array(
            'method' => 'newInstance',
            'params' => array(
                'type' => 'new foo'
            )
        ));
        $result = $this->_proxy->doProxy($this->_locator);

        $this->assertEquals('new foo', $result->getType());
        $this->assertEquals('foobar', $result->getName());
    }

    public function testDoProxyViaNoShared()
    {
        $this->_proxy->setOptions(array(
            'method' => 'newInstance',
            'isShared' => false
        ));
        $result = $this->_proxy->doProxy($this->_locator);
        $result->setType('new foo');

        $this->_proxy->setOptions(array(
            'method' => 'get'
        ));
        $result = $this->_proxy->doProxy($this->_locator);
        $this->assertEquals('foo', $result->getType());
    }

    public function testDoProxyWithShared()
    {
        $this->_proxy->setOptions(array(
            'method' => 'newInstance',
            'isShared' => true
        ));
        $result = $this->_proxy->doProxy($this->_locator);
        $result->setType('new foo');

        $this->_proxy->setOptions(array(
            'method' => 'get'
        ));
        $result = $this->_proxy->doProxy($this->_locator);
        $this->assertEquals('new foo', $result->getType());
    }

    public function testDoProxyWithUndefinedMethod()
    {
        $this->setExpectedException('InvalidArgumentException');
        $this->_proxy->setOptions(array('method' => 'undefined'));
        $this->_proxy->doProxy($this->_locator);
    }

}
