<?php

namespace UkalaTest\Element;

use UkalaTest\Framework\TestCase,
    UkalaTest\Element\AbstractElement;

class AbstractElementTest extends AbstractElement
{

    public function getElementByOptions($options)
    {
        return $this->getMockForAbstractClass(
            'Ukala\Element\AbstractElement',
            array(
                'options' => $options
            )
        );
    }

}
