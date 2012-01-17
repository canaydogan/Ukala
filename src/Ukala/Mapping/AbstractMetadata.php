<?php

namespace Ukala\Mapping;

use Zend\Validator\Validator,
    Zend\Filter\Filter;

abstract class AbstractMetadata
{

    protected $_validators = array();

    protected $_filters = array();

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

    public function setFilters($filters)
    {
        $this->_filters = $filters;
    }

    public function getFilters()
    {
        return $this->_filters;
    }

    public function addFilter(Filter $filter)
    {
        $this->_filters[] = $filter;
    }

    public function addFilters(array $filters)
    {
        foreach ($filters as $filter) {
            $this->addFilter($filter);
        }
    }

    public function hasFilters()
    {
        return count($this->_filters) > 0;
    }

}