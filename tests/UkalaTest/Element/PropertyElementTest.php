<?php

namespace UkalaTest\Element;

use UkalaTest\Framework\TestCase,
    UkalaTest\Element\AbstractElement,
    Ukala\ELement\Property;

class PropertyElementTest extends AbstractElement
{

    public function getElementByOptions($options)
    {
        return new Property($options);
    }

}
