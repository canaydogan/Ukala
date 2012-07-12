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
    Ukala\Element\AbstractElement,
    Ukala\LocatorProxy\LocatorProxy,
    Zend\Di\LocatorInterface;

class AnnotationLoader implements Loader
{

    /**
     * @var Reader
     */
    protected $_reader;

    /**
     * @var LocatorInterface
     */
    protected $_locator;

    public function __construct(Reader $reader)
    {
        AnnotationRegistry::registerAutoloadNamespace(
            'Ukala',
            __DIR__ . '/../../../'
        );
        $this->setReader($reader);
    }

    public function loadClassMetadata(ClassMetadata $metadata)
    {
        $reflectionClass = $metadata->getReflectionClass();
        $className = $metadata->getName();
        $loaded = false;

        foreach ($this->getReader()->getClassAnnotations($reflectionClass) as $value) {
            $this->prepareMetadata($metadata, $value);
            $loaded = true;
        }

        foreach ($reflectionClass->getProperties() as $property) {
            $propertyMetadata = new PropertyMetadata($className, $property->getName());
            $metadata->addMemberMetadata($propertyMetadata);
            foreach ($this->getReader()->getPropertyAnnotations($property) as $value) {
                $this->prepareMetadata($propertyMetadata, $value);
                $loaded = true;
            }
        }

        foreach ($reflectionClass->getMethods() as $method) {
            $methodMetadata = new MethodMetadata($className, $method->getName());
            $metadata->addMemberMetadata($methodMetadata);
            foreach ($this->getReader()->getMethodAnnotations($method) as $value) {
                $this->prepareMetadata($methodMetadata, $value);
                $loaded = true;
            }
        }

        $this->prepareElements($metadata);

        return $loaded;
    }

    /**
     * @todo ozel test yaz.
     */
    public function prepareElement($element, $metadata)
    {
        if (null === $element->getName()) {
            $element->setName($metadata->getName());
        }

        foreach ($metadata->getFilters() as $validator) {
            $element->addFilter($validator);
        }

        foreach ($metadata->getValidators() as $validator) {
            $element->addValidator($validator);
        }
    }

    /**
     * @todo ozel test yaz.
     */
    public function prepareElements($metadata)
    {
        $this->prepareElement($metadata->getElement(), $metadata);

        foreach ($metadata->getMembers() as $member) {
            foreach ($member as $metadata) {
                $this->prepareElement($metadata->getElement(), $metadata);
            }
        }
    }

    /**
     * @todo ozel test yaz.
     */
    public function prepareMetadata($metadata, $value)
    {
        if ($this->isLocatorProxy($value)
            && null !== $this->getLocator()) {
            $value = $value->doProxy($this->getLocator());
        }
        if ($this->isValidator($value)) {
            $metadata->addValidator($value);
        }
        if ($this->isFilter($value)) {
            $metadata->addFilter($value);
        }
        if ($this->isElement($value)) {
            $metadata->setElement($value);
        }

        return $metadata;
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

    public function isLocatorProxy($value)
    {
        return $value instanceof LocatorProxy;
    }

    /**
     * @param LocatorInterface $locator
     */
    public function setLocator(LocatorInterface $locator)
    {
        $this->_locator = $locator;
    }

    /**
     * @return LocatorInterface
     */
    public function getLocator()
    {
        return $this->_locator;
    }

}
