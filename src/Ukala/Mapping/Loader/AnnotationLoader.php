<?php

namespace Ukala\Mapping\Loader;

use Ukala\Mapping\Loader,
    Ukala\Mapping\ClassMetadata,
    Ukala\Mapping\PropertyMetadata,
    Ukala\Mapping\MethodMetadata,
    Doctrine\Common\Annotations\Reader,
    Doctrine\Common\Annotations\AnnotationRegistry,
    Zend\Validator\ValidatorInterface,
    Zend\Filter\FilterInterface,
    Ukala\Element\AbstractElement;

class AnnotationLoader implements Loader
{

    /**
     * @var Reader
     */
    protected $_reader;

    public function __construct(Reader $reader)
    {
        AnnotationRegistry::registerAutoloadNamespace(
            'Ukala\Validator',
            __DIR__ . '/../../../'
        );
        AnnotationRegistry::registerAutoloadNamespace(
            'Ukala\Filter',
            __DIR__ . '/../../../'
        );
        $this->setReader($reader);
    }

    public function loadClassMetadata(ClassMetadata $metadata)
    {
        $reflectionClass = $metadata->getReflectionClass();
        $className = $metadata->getClassName();
        $loaded = false;

        foreach ($this->getReader()->getClassAnnotations($reflectionClass) as $value) {
            if ($this->isValidator($value)) {
                $metadata->addValidator($value);
            }
            if ($this->isFilter($value)) {
                $metadata->addFilter($value);
            }
            if ($this->isElement($value)) {
                $metadata->setElement($value);
            }

            $loaded = true;
        }

        foreach ($reflectionClass->getProperties() as $property) {
            $propertyMetadata = new PropertyMetadata($className, $property->getName());
            $metadata->addMemberMetadata($propertyMetadata);
            foreach ($this->getReader()->getPropertyAnnotations($property) as $value) {
                if ($this->isValidator($value)) {
                    $propertyMetadata->addValidator($value);
                }
                if ($this->isFilter($value)) {
                    $propertyMetadata->addFilter($value);
                }
                if ($this->isElement($value)) {
                    $propertyMetadata->setElement($value);
                }

                $loaded = true;
            }
        }

        foreach ($reflectionClass->getMethods() as $method) {
            $methodMetadata = new MethodMetadata($className, $method->getName());
            $metadata->addMemberMetadata($methodMetadata);
            foreach ($this->getReader()->getMethodAnnotations($method) as $value) {
                if ($this->isValidator($value)) {
                    $methodMetadata->addValidator($value);
                }
                if ($this->isFilter($value)) {
                    $methodMetadata->addFilter($value);
                }
                if ($this->isElement($value)) {
                    $methodMetadata->setElement($value);
                }

                $loaded = true;
            }

        }

        if (null === $metadata->getElement()->getName()) {
            $metadata->getElement()->setName($metadata->getClassName());
        }

        foreach ($metadata->getMembers() as $member) {
            foreach ($member as $metadata) {
                if (null === $metadata->getElement()->getName()) {
                    $metadata->getElement()->setName($metadata->getName());
                }
            }
        }

        return $loaded;
    }

    public function isValidator($value)
    {
        return $value instanceof ValidatorInterface;
    }

    /**
     * @param Reader $reader
     */
    public function setReader(Reader $reader)
    {
        $this->_reader = $reader;
    }

    /**
     * @return Reader
     */
    public function getReader()
    {
        return $this->_reader;
    }

    public function isFilter($value)
    {
        return $value instanceof FilterInterface;
    }

    public function isElement($value)
    {
        return $value instanceof AbstractElement;
    }

}
