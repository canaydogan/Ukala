<?php

namespace UkalaTest\Mapping\ClassMetadataFactory;

use UkalaTest\Mapping\ClassMetadataFactory\AbstractFactory;

class AnnotationLoaderTest extends AbstractFactory
{
    public function getClass()
    {
        return $this->getAnnotatedClass();
    }

    public function getProxyClass()
    {
        return $this->newAnnotatedClassProxy();
    }

    public function getLoader()
    {
        return $this->getAnnotationLoader();
    }

}