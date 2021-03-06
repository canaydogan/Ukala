<?php

namespace UkalaTest\Framework;

use Zend\Validator\NotEmpty,
    UkalaTest\Assets\Classes\AnnotatedClass,
    Doctrine\Common\Annotations\AnnotationReader,
    Ukala\Mapping\ClassMetadata,
    Ukala\Mapping\Loader\AnnotationLoader,
    Ukala\Mapping\ClassMetadataFactory\Standard,
    Zend\Filter\Int,
    Ukala\Element\Property,
    UkalaTest\Assets\Consultant\BasicConsultant,
    UkalaTest\Assets\Classes\AnnotatedClass2,
    UkalaTest\Assets\Classes\AnnotatedClass3,
    Ukala\LocatorProxy\ServiceLocatorProxy,
    UkalaTest\Assets\Classes\AnnotatedClassProxy,
    UkalaTest\Bootstrap;

class TestCase extends \PHPUnit_Framework_TestCase
{

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

    public function getAnnotated2ClassMetadata()
    {
        $annotatedClass = $this->getAnnotatedClass2();
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
        $annotatedClass->setValueForNewNaming('Foo and Foo');

        return $annotatedClass;
    }

    public static function getServiceManager()
    {
        return Bootstrap::getServiceManager();
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

    public function newBasicConsultant()
    {
        return new BasicConsultant();
    }

    public function newAnnotatedClass2()
    {
        return new AnnotatedClass2();
    }

    public function getAnnotatedClass2()
    {
        $annotatedClass2 = $this->newAnnotatedClass2();

        $annotatedClass2->setName('Can Aydogan');

        return $annotatedClass2;
    }

    public function newAnnotatedClass3()
    {
        return new AnnotatedClass3();
    }

    public function newValidAnnotatedClass3()
    {
        $annotatedClass3 = $this->newAnnotatedClass3();

        return $annotatedClass3;
    }

    public function newStandardLocatorProxy()
    {
        return new ServiceLocatorProxy();
    }

    public function newAnnotatedClassProxy()
    {
        return new AnnotatedClassProxy();
    }

    public function newValidAnnotatedClassProxy()
    {
        $annotatedClass = $this->newAnnotatedClassProxy();

        $annotatedClass->setName('Can Aydogan');
        $annotatedClass->setEmail('canaydogan89@gmail.com');
        $annotatedClass->setPassword('12345');
        $annotatedClass->setConfirmPassword('12345');
        $annotatedClass->setPhone('12345');
        $annotatedClass->setCountry('Turkey');

        return $annotatedClass;
    }

}