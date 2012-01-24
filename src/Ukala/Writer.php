<?php

namespace Ukala;

interface Writer
{

    /**
     * @abstract
     * @param array $values
     * @param object $object
     * @return object
     */
    public function write($values, $object);

}
