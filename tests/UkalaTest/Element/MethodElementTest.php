<?php

namespace UkalaTest\Element;

use UkalaTest\Framework\TestCase,
    UkalaTest\Element\AbstractElement,
    Ukala\ELement\MethodElement;

class MethodElementTest extends AbstractElement
{

    public function getElementByOptions($options)
    {
        return new MethodElement($options);
    }

}
