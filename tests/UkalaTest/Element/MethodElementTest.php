<?php

namespace UkalaTest\Element;

use UkalaTest\Framework\TestCase,
    UkalaTest\Element\AbstractElement,
    Ukala\ELement\Method;

class MethodElementTest extends AbstractElement
{

    public function getElementByOptions($options)
    {
        return new Method($options);
    }

}
