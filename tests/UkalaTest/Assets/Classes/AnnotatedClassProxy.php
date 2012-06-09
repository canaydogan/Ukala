<?php

namespace UkalaTest\Assets\Classes;

use \Doctrine\ORM\Proxy\Proxy,
    UkalaTest\Assets\Classes\AnnotatedClass;

class AnnotatedClassProxy extends AnnotatedClass implements Proxy
{
    /**
     * Is this proxy initialized or not.
     *
     * @return bool
     */
    public function __isInitialized()
    {
        // TODO: Implement __isInitialized() method.
    }

}
