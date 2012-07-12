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

    /**
     * @var array
     */
    protected $_validators = array();

    /**
     * @var array
     */
    protected $_filters = array();

    /**
     * @var AbstractElement
     */
    protected $_element;

    /**
     * @var string
     */
    protected $_name;

    public function hasValidators()
    {
        return count($this->_validators) > 0;
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

    /**
     * @param array $filters
     */
    public function setFilters($filters)
    {
        $this->_filters = $filters;
    }

    /**
     * @return array
     */
    public function getFilters()
    {
        return $this->_filters;
    }

    /**
     * @param array $validators
     */
    public function setValidators($validators)
    {
        $this->_validators = $validators;
    }

    /**
     * @return array
     */
    public function getValidators()
    {
        return $this->_validators;
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->_name = $name;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->_name;
    }


}