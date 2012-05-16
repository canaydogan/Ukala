<?php

namespace Ukala\LocatorProxy;

use Zend\Di\Di;

interface LocatorProxy
{

    /**
     * @abstract
     * @param Di $locator
     * @return mixed
     */
    public function doProxy(Di $locator);

}
