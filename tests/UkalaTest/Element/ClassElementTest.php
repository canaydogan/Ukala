<?php

namespace UkalaTest\Element;

use UkalaTest\Framework\TestCase,
    UkalaTest\Element\AbstractElement,
    Ukala\ELement\Clazz;

class ClassElementTest extends AbstractElement
{

    public function getElementByOptions($options)
    {
        return new Clazz($options);
    }

}
