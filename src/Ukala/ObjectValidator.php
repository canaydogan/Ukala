<?php

namespace Ukala;

use Zend\Validator\Validator,
    Ukala\Mapping\ClassMetadataFactory;

class ObjectValidator implements Validator
{

    /**
     * @var array
     */
    protected $_messages = array();

    /**
     * @var ClassMetadataFactory
     */
    protected $_classMetadataFactory;

    public function __construct(ClassMetadataFactory $classMetadataFactory)
    {
        $this->setClassMetadataFactory($classMetadataFactory);
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
        $this->reset();
        $valid = true;
        $className = get_class($value);

        $metadata = $this->getClassMetadataFactory()->getClassMetadata($className);

        foreach ($metadata->getMembers() as $member) {
            foreach ($member as $memberMetadata) {
                $validators = $memberMetadata->getValidators();
                $element = $memberMetadata->getElement();
                if (count($validators)) {
                    $_value = $memberMetadata->getValue($value);

                    if ($element->isRequired()
                        || (null !== $_value && '' !== $_value)) {
                        foreach ($validators as $validator) {
                            if (!$validator->isValid($_value)) {
                                $valid = false;
                                $this->addMessage(
                                    $element->getName(),
                                    $validator->getMessages()
                                );
                            }
                        }
                    }
                } elseif ($element->isRequired()) {
                    $_value = $memberMetadata->getValue($value);
                    if (null === $_value || '' === $_value) {
                        $valid = false;
                    }
                }
            }
        }

        return $valid;
    }

    public function addMessage($key, $message)
    {
        if (!isset($this->_messages[$key])) {
            $this->_messages[$key] = array();
        }
        $this->_messages[$key][] = $message;
    }

    public function reset()
    {
        $this->resetMessages();
    }

    public function resetMessages()
    {
        $this->_messages = array();
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

    /**
     * @param array $messages
     */
    public function setMessages(array $messages)
    {
        $this->_messages = $messages;
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
