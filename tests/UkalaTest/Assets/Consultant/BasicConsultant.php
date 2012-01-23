<?php

namespace UkalaTest\Assets\Consultant;

use Ukala\Consultant,
    Ukala\Mapping\AbstractMetadata;

class BasicConsultant implements Consultant
{

    /**
     * @param $value
     * @param AbstractMetadata $metadata
     * @return bool
     */
    public function isAvailable($value, AbstractMetadata $metadata)
    {
        if ('forConsultant' === $value) {
            return false;
        }

        return true;
    }

}
