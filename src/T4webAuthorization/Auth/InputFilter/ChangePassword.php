<?php

namespace Authorization\Auth\InputFilter;

use T4webBase\InputFilter\InputFilter;
use T4webBase\InputFilter\Element\Password;

class ChangePassword extends InputFilter
{

    public function __construct()
    {
        $password = new Password('password');
        $this->add($password);

        $confirmPassword = new Password('confirm_password');
        $this->add($confirmPassword);
    }

    public function isValid()
    {
        $password = $this->get('password')->getValue();
        $confirmPassword = $this->get('confirm_password')->getValue();
        if ($password != $confirmPassword) {
            $this->invalidInputs['confirm_password'] = $this->get('confirm_password');
            $this->get('confirm_password')->setErrorMessage('Пароли не совпадают');
            return false;
        }

        return parent::isValid();
    }
}
