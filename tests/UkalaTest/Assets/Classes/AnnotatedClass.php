<?php

namespace UkalaTest\Assets\Classes;

use Ukala\Validator AS Validator,
    Ukala\Filter AS Filter,
    Ukala\Element AS Element;

/**
 * @Validator\NotEmpty()
 * @Filter\Int()
 * @Element\Clazz({"readable" = true, "writable" = true})
 */
class AnnotatedClass
{

    /**
     * @Validator\NotEmpty()
     * @Filter\Alpha();
     * @Element\Property({"required" = true, "readable" = true, "writable" = true})
     * @var string
     */
    protected $_name;

    /**
     * @Validator\NotEmpty()
     * @Element\Property({"required" = true, "readable" = true})
     * @Validator\EmailAddress()
     * @var string
     */
    public $email;

    /**
     * @Validator\StringLength(min = 4, max = 8)
     * @var string
     */
    private $_password;

    /**
     * @var string
     */
    public $confirmPassword;

    public $dummyMixedString = '1234abc';

    /**
     * @Element\Property({"required" = false})
     * @Validator\StringLength(min = 4, max = 8)
     * @var string
     */
    public $phone;

    /**
     * @Element\Property({"required" = true})
     * @var string
     */
    public $country;

    /**
     * @Validator\NotEmpty()
     * @return bool
     */
    public function isPasswordConfirmed()
    {
        if ($this->getPassword() === $this->getConfirmPassword()) {
            return true;
        }

        return false;
    }

    /**
     * @Filter\Alpha()
     * @Element\Method({"readable" = true})
     */
    public function getDummyMixedString($value = null)
    {
        if ($value) {
            $this->dummyMixedString = $value;
        }
        return $this->dummyMixedString;
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

    /**
     * @param string $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->_password = $password;
    }

    /**
     * @return string
     */
    public function getPassword()
    {
        return $this->_password;
    }

    /**
     * @param string $confirmPassword
     */
    public function setConfirmPassword($confirmPassword)
    {
        $this->confirmPassword = $confirmPassword;
    }

    /**
     * @return string
     */
    public function getConfirmPassword()
    {
        return $this->confirmPassword;
    }

    /**
     * @param string $phone
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;
    }

    /**
     * @return string
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * @param string $country
     */
    public function setCountry($country)
    {
        $this->country = $country;
    }

    /**
     * @return string
     */
    public function getCountry()
    {
        return $this->country;
    }

}

