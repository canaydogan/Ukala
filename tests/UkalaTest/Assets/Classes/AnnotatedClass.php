<?php

namespace UkalaTest\Assets\Classes;

use Ukala\Validator AS Validator,
    Ukala\Filter,
    Ukala\Element,
    Ukala\LocatorProxy;

/**
 * @Validator\NotEmpty()
 * @Filter\Int()
 * @Element\Clazz({"readable" = true, "writable" = true, "name" = "className"})
 * @LocatorProxy\StandardProxy({
 *  "name" = "Zend\Filter\Alnum"
 * })
 */
class AnnotatedClass
{

    /**
     * @Validator\NotEmpty()
     * @Filter\Alpha();
     * @Element\Property({"required" = true, "readable" = true, "writable" = true, "name" = "newName"})
     * @var string
     */
    protected $_name;

    /**
     * @Validator\NotEmpty()
     * @Element\Property({"required" = true, "readable" = true, "writable" = false})
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
     * @Element\Clazz({"readable" = true})
     * @var AnnotatedClass3
     */
    public $annotatedClass;

    /**
     * @LocatorProxy\StandardProxy({
     *  "name" = "Ukala\Element\Property",
     *  "method" = "newInstance",
     *  "params" = {"readable" = true, "writable" = true}
     * })
     * @var string
     */
    public $username;

    /**
     * @var @Element\Property({"readable" = true})
     */
    protected $_valueForLoad;

    public function __load()
    {
        $this->setValueForLoad('foo');
    }

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
     * @Element\Method({"readable" = true, "name" = "newGetDummyMixedString"})
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

    /**
     * @param \UkalaTest\Assets\Classes\AnnotatedClass3 $annotatedClass
     */
    public function setAnnotatedClass($annotatedClass)
    {
        $this->annotatedClass = $annotatedClass;
    }

    /**
     * @return \UkalaTest\Assets\Classes\AnnotatedClass3
     */
    public function getAnnotatedClass()
    {
        return $this->annotatedClass;
    }

    /**
     * @param string $username
     */
    public function setUsername($username)
    {
        $this->username = $username;
    }

    /**
     * @LocatorProxy\StandardProxy({
     *  "name" = "Ukala\Element\Method",
     *  "method" = "newInstance",
     *  "params" = {"readable" = true, "writable" = true}
     * })
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * @param  $valueForLoad
     */
    public function setValueForLoad($valueForLoad)
    {
        $this->_valueForLoad = $valueForLoad;
    }

    /**
     * @return
     */
    public function getValueForLoad()
    {
        return $this->_valueForLoad;
    }

}

