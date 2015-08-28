<?php

namespace Authorization\Auth\Form;

use Zend\Form\Form;
use Zend\Form\Element;

class PasswordRemind extends Form
{

    public function __construct() {
        parent::__construct('passwordRemind');

        $this->setAttributes([
            'method' => 'post',
        ]);

        $email = new Element\Email('email');
        $this->add($email);
    }
}