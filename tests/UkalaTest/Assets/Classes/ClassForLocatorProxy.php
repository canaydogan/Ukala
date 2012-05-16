<?php

namespace UkalaTest\Assets\Classes;

class ClassForLocatorProxy
{

    /**
     * @var string
     */
    protected $_type;

    /**
     * @var string
     */
    protected $_name;

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

    /**
     * @param string $type
     */
    public function setType($type)
    {
        $this->_type = $type;
    }

    /**
     * @return string
     */
    public function getType()
    {
        return $this->_type;
    }

}
