<?php

namespace Ukala\LocatorProxy;

use Ukala\LocatorProxy\LocatorProxy,
    Zend\Di\Di,
    InvalidArgumentException;

/**
 * @Annotation
 */
class StandardProxy implements LocatorProxy
{

    /**
     * @var array
     */
    protected $_options = array(
        'method' => 'get',
        'name' => null,
        'params' => array(),
        'isShared' => true
    );

    public function __construct(array $options = null)
    {
        $this->setOptions($options);
    }

    /**
     * @param Di $locator
     * @return mixed
     */
    public function doProxy(Di $locator)
    {
        $options = $this->getOptions();
        $result = null;

        if ('get' === $options['method']) {
            $result = $locator->get($options['name'], $options['params']);
        } elseif ('newInstance' === $options['method']) {
            $result = $locator->newInstance($options['name'], $options['params'], $options['isShared']);
        } else {
            throw new InvalidArgumentException("'$options[method]' is undefined method'");
        }

        return $result;
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
