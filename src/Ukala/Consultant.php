<?php

namespace Ukala;

use Ukala\Mapping\AbstractMetadata;

interface Consultant
{

    /**
     * @abstract
     * @param $value
     * @param AbstractMetadata $metadata
     * @return bool
     */
    public function isAvailable($value, AbstractMetadata $metadata);

}