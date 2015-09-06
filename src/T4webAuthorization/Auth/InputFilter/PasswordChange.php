<?php

namespace T4webAuthorization\Auth\InputFilter;

use T4webBase\InputFilter\InputFilter;
use T4webBase\InputFilter\Element\Password;
use T4webAuthorization\InputFilter\Element\PasswordConfirm;

class PasswordChange extends InputFilter
{

    public function __construct()
    {

        // password
        $password = new Password('password');
        $password->setRequired(true);
        $this->add($password);

        // confirmPassword
        $confirmPassword = new PasswordConfirm('confirmPassword', 'password');
        $confirmPassword->setRequired(true);
        $this->add($confirmPassword);
    }
}
