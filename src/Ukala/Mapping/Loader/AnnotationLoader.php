<?php

namespace Ukala\Mapping\Loader;

use Ukala\Mapping\Loader,
    Ukala\Mapping\ClassMetadata,
    Ukala\Mapping\PropertyMetadata,
    Ukala\Mapping\MethodMetadata,
    Doctrine\Common\Annotations\Reader,
    Doctrine\Common\Annotations\AnnotationRegistry,
    Zend\Validator\Validator;

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

            $loaded = true;
        }

        foreach ($reflectionClass->getProperties() as $property) {
            $propertyMetadata = new PropertyMetadata($className, $property->getName());
            $metadata->addMemberMetadata($propertyMetadata);
            foreach ($this->getReader()->getPropertyAnnotations($property) as $value) {
                if ($this->isValidator($value)) {
                    $propertyMetadata->addValidator($value);
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

                $loaded = true;
            }

        }

        return $loaded;
    }

    public function isValidator($value)
    {
        return $value instanceof Validator;
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

}
