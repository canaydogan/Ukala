<?php

namespace Ukala\Filter;

use Zend\Filter\Filter;

/**
 * @Annotation
 */
class StringToArray implements Filter
{

    public function __construct(array $options = array())
    {
        $this->setOptions($options);
    }

    /**
     * Returns the result of filtering $value
     *
     * @param  mixed $value
     * @throws Zend\Filter\Exception\RuntimeException If filtering $value is impossible
     * @return mixed
     */
    public function filter($value)
    {
        $filteredValue = $value;

        if (is_string($value)) {
            $filteredValue = explode($this->getDelimiter(), $value);
        } elseif (null !== $value && !is_array($value)) {
            $filteredValue = array($value);
        }

        return $filteredValue;
    }

    public function setOptions(array $options)
    {
        foreach ($options as $key => $value) {
            if ($key == 'options') {
                $key = 'adapterOptions';
            }
            $method = 'set' . ucfirst($key);
            if (method_exists($this, $method)) {
                $this->$method($value);
            }
        }
        return $this;
    }

    /**
     * @var string
     */
    protected $_delimiter;

    /**
     * @param string $delimiter
     */
    public function setDelimiter($delimiter)
    {
        $this->_delimiter = $delimiter;
    }

    /**
     * @return string
     */
    public function getDelimiter()
    {
        return $this->_delimiter;
    }
}
