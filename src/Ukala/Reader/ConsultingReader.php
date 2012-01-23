<?php

namespace Ukala\Reader;

use Ukala\Reader,
    Ukala\Mapping\ClassMetadataFactory,
    Ukala\Consultant,
    Doctrine\Common\Collections\ArrayCollection,
    Ukala\Mapping\AbstractMetadata;

class ConsultingReader implements Reader, Consultant

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

    public function read($value)
    {
        $result = array();

        if (is_array($value)) {
            foreach ($value as $_value) {
                $result[] = $this->read($_value);
            }
        } else {
            $result = $this->_read($value);
        }


        return $result;
    }

    protected function _read($value)
    {
        $className = get_class($value);
        $metadata = $this->getClassMetadataFactory()->getClassMetadata($className);

        $result = array();

        foreach ($metadata->getMembers() as $member) {
            foreach ($member as $memberMetadata) {
                $element = $memberMetadata->getElement();
                if ($element->isReadable()
                    && $this->isAvailable($memberMetadata->getValue($value), $memberMetadata)) {
                    $result[$memberMetadata->getName()] = $memberMetadata->getValue($value);
                }
            }
        }

        return $result;
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
