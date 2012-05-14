<?php

namespace UkalaTest\Assets\Classes;

use Ukala\Element AS Element;

/**
 * @Element\Clazz({"readable" = true})
 */
class AnnotatedClass3
{

    /**
     * @Element\Property({"readable" = true})
     * @var string
     */
    public $name = 'name';

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

}

