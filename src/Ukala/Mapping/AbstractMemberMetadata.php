<?php

namespace Ukala\Mapping;

use Ukala\Mapping\AbstractMemberMetadata;

abstract class AbstractMemberMetadata extends AbstractMetadata
{

    abstract public function newReflectionMember();
    abstract public function getValue($object);
    abstract public function setValue($object, $value);

    /**
     * @var string
     */
    protected $_name;

    /**
     * @var string
     */
    protected $_className;

    /**
     * @var string
     */
    protected $_property;

    protected $_reflectionMember;

    public function __construct($className, $name, $property)
    {
        $this->setClassName($className);
        $this->setName($name);
        $this->setProperty($property);
    }

    /**
     * @param string $class
     */
    public function setClassName($class)
    {
        $this->_className = $class;
    }

    /**
     * @return string
     */
    public function getClassName()
    {
        return $this->_className;
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->_name = $name;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->_name;
    }

    /**
     * @param string $property
     */
    public function setProperty($property)
    {
        $this->_property = $property;
    }

    /**
     * @return string
     */
    public function getProperty()
    {
        return $this->_property;
    }

    public function isPublic()
    {
        return $this->getReflectionMember()->isPublic();
    }

    public function isProtected()
    {
        return $this->getReflectionMember()->isProtected();
    }

    public function isPrivate()
    {
        return $this->getReflectionMember()->isPrivate();
    }

    public function setReflectionMember($reflectionMember)
    {
        $this->_reflectionMember = $reflectionMember;
    }

    public function getReflectionMember()
    {
        if (null === $this->_reflectionMember) {
            $this->_reflectionMember = $this->newReflectionMember();
        }
        return $this->_reflectionMember;
    }

}