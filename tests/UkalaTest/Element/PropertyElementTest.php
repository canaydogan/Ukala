<?php

namespace UkalaTest\Element;

use UkalaTest\Framework\TestCase,
    UkalaTest\Element\AbstractElement,
    Ukala\ELement\PropertyElement;

class PropertyElementTest extends AbstractElement
{

    public function getElementByOptions($options)
    {
        return new PropertyElement($options);
    }

}
