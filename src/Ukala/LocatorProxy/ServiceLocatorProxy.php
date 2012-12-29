<?php

namespace Ukala\LocatorProxy;

use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * @Annotation
 */
class ServiceLocatorProxy
{

    /**
     * @var array
     */
    protected $_options = array(
        'name' => null,
        'params' => array()
    );

    public function __construct(array $options = null)
    {
        $this->setOptions($options);
    }

    /**
     * @param ServiceLocatorInterface $locator
     * @return mixed
     */
    public function doProxy(ServiceLocatorInterface $locator)
    {
        $options = $this->getOptions();
        $instance = $locator->get($options['name']);
        $this->setInstanceParams($instance, $options['params']);

        return $instance;
    }

    public function setInstanceParams($instance, array $params = array())
    {
        $methods = get_class_methods($instance);
        foreach ($params as $key => $value) {
            $method = 'set' . ucfirst($key);
            if (in_array($method, $methods)) {
                $instance->$method($value);
            }
        }
    }

    /**
     * @param array $options
     */
    public function setOptions($options)
    {
        if (is_array($options)) {
            if (isset($options['value'])) {
                $options = $options['value'];
            }
            $this->_options = array_merge($this->_options, $options);
        }
    }

    /**
     * @return array
     */
    public function getOptions()
    {
        return $this->_options;
    }

}
