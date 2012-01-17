<?php

namespace Ukala\Mapping;

use Ukala\Mapping\ClassMetadata;

interface Loader
{

    public function loadClassMetadata(ClassMetadata $metadata);

}