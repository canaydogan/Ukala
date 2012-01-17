<?php

namespace Ukala\Mapping;

use Ukala\Mapping\AbstractMemberMetadata,
    InvalidArgumentException,
    ReflectionProperty;

class PropertyMetadata extends AbstractMemberMetadata
{

    public function __construct($className, $name)
    {
        if (!property_exists($className, $name)) {
            throw new InvalidArgumentException(
                sprintf('Property %s does not exists in class %s', $name, $className)
            );
        }

        parent::__construct($className, $name, $name);
    }

    public function newReflectionMember()
    {
        $member = new ReflectionProperty($this->getClassName(), $this->getName());
        $member->setAccessible(true);

        return $member;
    }

    public function getValue($object)
    {
        return $this->getReflectionMember()->getValue($object);
    }

}