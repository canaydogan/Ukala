<?php

namespace Ukala\Validator;

use Zend\Validator\AbstractValidator,
    Zend\Validator\Exception\InvalidArgumentException;

/**
 * @Annotation
 * @todo testlerini yaz.
 */
class ArrayLength extends AbstractValidator
{
    const INVALID   = 'arrayLengthInvalid';
    const TOO_SHORT = 'arrayLengthTooShort';
    const TOO_LONG  = 'arrayLengthTooLong';

    /**
     * @var array
     */
    protected $_messageTemplates = array(
        self::INVALID   => "Invalid type given. Array expected",
        self::TOO_SHORT => "'%value%' is less than %min% length",
        self::TOO_LONG  => "'%value%' is more than %max% length",
    );

    /**
     * @var array
     */
    protected $_messageVariables = array(
        'min' => array('options' => 'min'),
        'max' => array('options' => 'max'),
    );

    protected $options = array(
        'min'      => 0, // Minimum length
        'max'      => null, // Maximum length, null if there is no length limitation
        'encoding' => null, // Encoding to use
    );

    /**
     * Sets validator options
     *
     * @param  integer|array|\Zend\Config\Config $options
     * @return void
     */
    public function __construct($options = array())
    {
        if (!is_array($options)) {
            $options     = func_get_args();
            $temp['min'] = array_shift($options);
            if (!empty($options)) {
                $temp['max'] = array_shift($options);
            }

            if (!empty($options)) {
                $temp['encoding'] = array_shift($options);
            }

            $options = $temp;
        }

        parent::__construct($options);
    }

    /**
     * Returns the min option
     *
     * @return integer
     */
    public function getMin()
    {
        return $this->options['min'];
    }

    /**
     * Sets the min option
     *
     * @param  integer $min
     * @throws \Zend\Validator\Exception
     * @return \Ukala\Validator\ArrayLength
     */
    public function setMin($min)
    {
        if (null !== $this->getMax() && $min > $this->getMax()) {
            throw new Exception\InvalidArgumentException("The minimum must be less than or equal to the maximum length, but $min >"
                . " " . $this->getMax());
        }

        $this->options['min'] = max(0, (integer) $min);
        return $this;
    }

    /**
     * Returns the max option
     *
     * @return integer|null
     */
    public function getMax()
    {
        return $this->options['max'];
    }

    /**
     * Sets the max option
     *
     * @param  integer|null $max
     * @throws \Zend\Validator\Exception
     * @return \Ukala\Validator\ArrayLength
     */
    public function setMax($max)
    {
        if (null === $max) {
            $this->options['max'] = null;
        } else if ($max < $this->getMin()) {
            throw new Exception\InvalidArgumentException("The maximum must be greater than or equal to the minimum length, but "
                . "$max < " . $this->getMin());
        } else {
            $this->options['max'] = (integer) $max;
        }

        return $this;
    }

    /**
     * Returns true if and only if the array length of $value is at least the min option and
     * no greater than the max option (when the max option is not null).
     *
     * @param  string $value
     * @return boolean
     */
    public function isValid($value)
    {
        if (!is_array($value)) {
            $this->error(self::INVALID);
            return false;
        }

        $length = count($value);
        $this->setValue($length);

        if ($length < $this->getMin()) {
            $this->error(self::TOO_SHORT);
        }

        if (null !== $this->getMax() && $this->getMax() < $length) {
            $this->error(self::TOO_LONG);
        }

        if (count($this->getMessages())) {
            return false;
        } else {
            return true;
        }
    }
}
