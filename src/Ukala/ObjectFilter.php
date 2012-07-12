<?php

namespace Ukala;

use Zend\Filter\FilterInterface,
    Ukala\Mapping\ClassMetadataFactory;

class ObjectFilter implements FilterInterface
{

    /**
     * @var ClassMetadataFactory
     */
    protected $_classMetadataFactory;

    public function __construct(ClassMetadataFactory $classMetadataFactory)
    {
        $this->setClassMetadataFactory($classMetadataFactory);
    }

    /**
     * Returns the result of filtering $value
     *
     * @param  mixed $value
     * @throws Zend\Filter\Exception\RuntimeException If filtering $value is impossible
     * @return mixed
     */
    public function filter($value)
    {
        $className = get_class($value);

        $metadata = $this->getClassMetadataFactory()->getClassMetadata($className);

        foreach ($metadata->getMembers() as $member) {
            foreach ($member as $memberMetadata) {
                foreach ($memberMetadata->getElement()->getFilters() as $filter) {
                    $memberMetadata->setValue(
                        $value,
                        $filter->filter($memberMetadata->getValue($value))
                    );
                }
            }
        }

        return $value;
    }

    /**
     * @param ClassMetadataFactory $classMetadataFactory
     */
    public function setClassMetadataFactory(ClassMetadataFactory $classMetadataFactory)
    {
        $this->_classMetadataFactory = $classMetadataFactory;
    }

    /**
     * @return ClassMetadataFactory
     */
    public function getClassMetadataFactory()
    {
        return $this->_classMetadataFactory;
    }

}
