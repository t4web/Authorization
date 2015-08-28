<?php

namespace Authorization\Auth\Form;

use Zend\Form\Form;
use Zend\Form\Element;

class ChangePassword extends Form
{

    public function __construct() {
        parent::__construct('changePassword');

        $this->setAttributes([
            'method' => 'post',
        ]);

        $password = new Element\Password('password');
        $password->setAttribute('autocomplete', 'off');
        $this->add($password);

        $confirmPassword = new Element\Password('confirm_password');
        $confirmPassword->setAttribute('autocomplete', 'off');
        $this->add($confirmPassword);
    }
}