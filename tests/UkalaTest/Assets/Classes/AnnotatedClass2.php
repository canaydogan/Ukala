<?php

namespace UkalaTest\Assets\Classes;

use Ukala\Validator AS Validator,
    Ukala\Filter AS Filter,
    Ukala\Element AS Element;

/**
 * @Element\Clazz({"readable" = false, "writable" = true})
 */
class AnnotatedClass2
{

    /**
     * @Element\Property({"required" = true, "readable" = true, "writable" = true})
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
}

