<?php

namespace Ukala\Element;

abstract class AbstractElement
{

    /**
     * @var bool
     */
    protected $_required = false;

    /**
     * @var bool
     */
    protected $_readable = false;

    /**
     * @var bool
     */
    protected $_writable = false;

    /**
     * @var string
     */
    protected $_name;

    public function __construct($options = null)
    {
        if (isset($options['value'])) {
            $options = $options['value'];
        }
        if (is_array($options)) {
            $this->setOptions($options);
        }
    }

    public function setOptions(array $options)
    {
        if (isset($options['required'])) {
            $this->setRequired($options['required']);
        }

        if (isset($options['readable'])) {
            $this->setReadable($options['readable']);
        }

        if (isset($options['writable'])) {
            $this->setWritable($options['writable']);
        }
        if (isset($options['name'])) {
            $this->setName($options['name']);
        }
    }

    public function isRequired()
    {
        return $this->_required;
    }

    public function isReadable()
    {
        return $this->_readable;
    }

    public function isWritable()
    {
        return $this->_writable;
    }

    /**
     * @param boolean $readable
     */
    public function setReadable($readable)
    {
        $this->_readable = $readable;
    }

    /**
     * @param boolean $required
     */
    public function setRequired($required)
    {
        $this->_required = $required;
    }

    /**
     * @param boolean $writable
     */
    public function setWritable($writable)
    {
        $this->_writable = $writable;
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->_name = $name;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->_name;
    }


}
