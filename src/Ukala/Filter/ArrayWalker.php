<?php

namespace Ukala\Filter;

use Zend\Filter\FilterInterface;

/**
 * @Annotation
 */
class ArrayWalker implements FilterInterface
{


    /**
     * @var Filter
     */
    protected $_filter;

    public function __construct(array $options = array())
    {
        $this->setOptions($options);
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
        $filteredValue = $value;

        foreach ($value as $key => $_value) {
            $filteredValue[$key] = $this->getFilter()->filter($_value);
        }

        return $filteredValue;
    }

    public function setOptions(array $options)
    {
        foreach ($options as $key => $value) {
            $method = 'set' . ucfirst($key);
            if (method_exists($this, $method)) {
                $this->$method($value);
            }
        }
        return $this;
    }

    /**
     * @param Filter $filter
     */
    public function setFilter($filter)
    {
        $this->_filter = $filter;
    }

    /**
     * @return Filter
     */
    public function getFilter()
    {
        return $this->_filter;
    }

}
