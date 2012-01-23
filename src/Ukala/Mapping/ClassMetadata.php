<?php

namespace Ukala\Mapping;

use Ukala\Mapping\AbstractMetadata,
    Ukala\Mapping\AbstractMemberMetadata,
    ReflectionClass,
    Ukala\Element\Clazz;

class ClassMetadata extends AbstractMetadata
{

    /**
     * @var string
     */
    protected $_className;

    /**
     * @var ReflectionClass
     */
    protected $_reflectionClass;

    /**
     * @var array
     */
    protected $_members = array();

    public function __construct($className)
    {
        $this->setClassName($className);
    }

    /**
     * @param string $className
     */
    public function setClassName($className)
    {
        $this->_className = $className;
    }

    /**
     * @return string
     */
    public function getClassName()
    {
        return $this->_className;
    }

    /**
     * @param ReflectionClass $reflectionClass
     */
    public function setReflectionClass(ReflectionClass $reflectionClass)
    {
        $this->_reflectionClass = $reflectionClass;
    }

    /**
     * @return ReflectionClass
     */
    public function getReflectionClass()
    {
        if (null === $this->_reflectionClass) {
            $this->_reflectionClass = new ReflectionClass($this->getClassName());
        }

        return $this->_reflectionClass;
    }

    /**
     * @param array $members
     */
    public function setMembers(array $members)
    {
        $this->_members = $members;
    }

    /**
     * @return array
     */
    public function getMembers()
    {
        return $this->_members;
    }

    public function addMemberMetadata(AbstractMemberMetadata $metadata)
    {
        $name = $metadata->getName();

        if (!isset($this->_members[$name])) {
            $this->_members[$name] = array();
        }

        $this->_members[$name][] = $metadata;
    }

    public function getMemberMetadatas($name)
    {
        return $this->_members[$name];
    }

    public function hasMemberMetadatas($name)
    {
        return array_key_exists($name, $this->_members);
    }

    public function newElement()
    {
        return new Clazz();
    }


}