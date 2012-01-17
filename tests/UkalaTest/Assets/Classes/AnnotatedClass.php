<?php

namespace UkalaTest\Assets\Classes;

use Ukala\Validator AS Validator;

/**
 * @Validator\NotEmpty()
 */
class AnnotatedClass
{

    /**
     * @Validator\NotEmpty()
     * @var string
     */
    protected $_name;

    /**
     * @Validator\NotEmpty()
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

}

