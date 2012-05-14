<?php

namespace Ukala\Validator;

use Zend\Validator\Validator;

/**
 * @Annotation
 */
class ArrayWalker implements Validator
{


    /**
     * Array of validation failure messages
     *
     * @var array
     */
    protected $_messages = array();

    /**
     * @var Validator
     */
    protected $_validator;

    public function __construct(array $options = array())
    {
        $this->setOptions($options);
    }

    /**
     * Returns true if and only if $value meets the validation requirements
     *
     * If $value fails validation, then this method returns false, and
     * getMessages() will return an array of messages that explain why the
     * validation failed.
     *
     * @param  mixed $value
     * @return boolean
     * @throws Exception If validation of $value is impossible
     */
    public function isValid($value)
    {
        $result = true;

        foreach ($value as $_value) {
            if (false === $this->getValidator()->isValid($_value)) {
                $result = false;
                $this->_messages[] = $this->getValidator()->getMessages();
            }
        }

        return $result;
    }

    /**
     * Returns an array of messages that explain why the most recent isValid()
     * call returned false. The array keys are validation failure message identifiers,
     * and the array values are the corresponding human-readable message strings.
     *
     * If isValid() was never called or if the most recent isValid() call
     * returned true, then this method returns an empty array.
     *
     * @return array
     */
    public function getMessages()
    {
        return $this->_messages;
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
     * @param Validator $validator
     */
    public function setValidator($validator)
    {
        $this->_validator = $validator;
    }

    /**
     * @return Validator
     */
    public function getValidator()
    {
        return $this->_validator;
    }


}
