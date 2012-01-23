<?php

namespace UkalaTest\Framework;

use Zend\Validator\NotEmpty,
    UkalaTest\Assets\Classes\AnnotatedClass,
    Doctrine\Common\Annotations\AnnotationReader,
    Ukala\Mapping\ClassMetadata,
    Ukala\Mapping\Loader\AnnotationLoader,
    Ukala\Mapping\ClassMetadataFactory\Standard,
    Zend\Filter\Int,
    Ukala\Element\Property;

class TestCase extends \PHPUnit_Framework_TestCase
{

    public static $locator;

    public function getNotEmptyValidator()
    {
        return new NotEmpty();
    }

    public function getAnnotatedClass()
    {
        $annotatedClass = new AnnotatedClass();

        return $annotatedClass;
    }

    public function getAnnotationReader()
    {
        $annotationReader = new AnnotationReader();

        return $annotationReader;
    }

    public function getAnnotationLoader()
    {
        $annotationLoader = new AnnotationLoader($this->getAnnotationReader());

        return $annotationLoader;
    }

    public function getAnnotatedClassMetadata()
    {
        $annotatedClass = $this->getAnnotatedClass();
        $className = get_class($annotatedClass);
        $classMetadata = new ClassMetadata($className);

        return $classMetadata;
    }

    public function getStandardClassMetadataFactory()
    {
        $classMetadataFactory = new Standard($this->getAnnotationLoader());

        return $classMetadataFactory;
    }

    public function getAnnotatedClassWithValidValues()
    {
        $annotatedClass = $this->getAnnotatedClass();
        $annotatedClass->setName('Can Aydogan');
        $annotatedClass->setEmail('canaydogan89@gmail.com');
        $annotatedClass->setPassword('12345');
        $annotatedClass->setConfirmPassword('12345');
        $annotatedClass->setPhone('12345');
        $annotatedClass->setCountry('Turkey');

        return $annotatedClass;
    }

    public static function setLocator($locator)
    {
        self::$locator = $locator;
    }

    public static function getLocator()
    {
        return self::$locator;
    }

    /**
     * @todo rename to newIntFilter
     */
    public function getIntFilter()
    {
        return new Int();
    }

    public function newPropertyElement()
    {
        return new Property();
    }

}