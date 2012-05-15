<?php

namespace Ukala\Mapping;

use Zend\Validator\ValidatorInterface,
    Zend\Filter\FilterInterface,
    Ukala\Element\AbstractElement;

abstract class AbstractMetadata
{

    /**
     * @abstract
     * @return AbstractElement
     */
    abstract public function newElement();

    protected $_validators = array();

    protected $_filters = array();

    /**
     * @var AbstractElement
     */
    protected $_element;

    public function getValidators()
    {
        return $this->_validators;
    }

    public function addValidator(ValidatorInterface $validator)
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

    public function addFilter(FilterInterface $filter)
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

    /**
     * @param AbstractElement $element
     */
    public function setElement(AbstractElement $element)
    {
        $this->_element = $element;
    }

    /**
     * @return AbstractElement
     */
    public function getElement()
    {
        if (null === $this->_element) {
            $this->_element = $this->newElement();
        }
        return $this->_element;
    }


}