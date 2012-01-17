<?php

namespace Ukala\Mapping;

use Zend\Validator\Validator;

abstract class AbstractMetadata
{

    protected $_validators = array();

    public function getValidators()
    {
        return $this->_validators;
    }

    public function addValidator(Validator $validator)
    {
        $this->_validators[] = $validator;
    }

    public function addValidators(array $validators)
    {
        foreach ($validators as $validator) {
            $this->addValidator($validator);
        }
    }

    public function hasValidators()
    {
        return count($this->_validators) > 0;
    }

}