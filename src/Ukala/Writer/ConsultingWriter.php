<?php

namespace Ukala\Writer;

use Ukala\Writer,
    Ukala\Mapping\ClassMetadataFactory,
    Ukala\Consultant,
    Doctrine\Common\Collections\ArrayCollection,
    Ukala\Mapping\AbstractMetadata;

class ConsultingWriter implements Writer, Consultant
{

    /**
     * @var array
     */
    protected $_consultants = array();

    /**
     * @var ClassMetadataFactory
     */
    protected $_classMetadataFactory;

    public function __construct(ClassMetadataFactory $classMetadataFactory)
    {
        $this->setClassMetadataFactory($classMetadataFactory);
    }

    /**
     * @param array $values
     * @param object $object
     * @return object
     */
    public function write($values, $object)
    {
        $className = get_class($object);
        $metadata = $this->getClassMetadataFactory()->getClassMetadata($className);

        if (!$metadata->getElement()->isWritable()
            || !$this->isAvailable($values, $metadata)) {
            return $object;
        }

        foreach ($metadata->getMembers() as $member) {
            foreach ($member as $memberMetadata) {
                $element = $memberMetadata->getElement();
                $memberName = $memberMetadata->getName();
                if ($element->isWritable()
                    && array_key_exists($memberName, $values)
                    && $this->isAvailable($values[$memberName], $memberMetadata)) {
                    $memberMetadata->setValue($object, $values[$memberName]);
                }
            }
        }

        return $object;
    }

    public function addConsultant(Consultant $consultant)
    {
        $this->_consultants[] = $consultant;
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

    /**
     * @param array $consultants
     */
    public function setConsultants(array $consultants)
    {
        $this->_consultants = $consultants;
    }

    /**
     * @return array
     */
    public function getConsultants()
    {
        return $this->_consultants;
    }

    public function hasConsultants()
    {
        return count($this->_consultants) > 0 ? true : false;
    }

    /**
     * @param $value
     * @param AbstractMetadata $metadata
     * @return bool
     */
    public function isAvailable($value, AbstractMetadata $metadata)
    {
        $available = true;

        foreach ($this->getConsultants() as $consultant) {
            if (!$consultant->isAvailable($value, $metadata)) {
                $available = false;
            }
        }

        return $available;
    }


}
