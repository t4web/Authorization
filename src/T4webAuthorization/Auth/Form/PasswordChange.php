<?php

namespace T4webAuthorization\Auth\Form;

use Zend\Form\Form;
use Zend\Form\Element;

class PasswordChange extends Form
{

    public function __construct() {
        parent::__construct('changePassword');

        $this->add(
            [
                'type' => 'Zend\Form\Element\Text',
                'name' => 'uname',
                'options' => [
                    'label' => 'User name',
                ],
                'attributes' => [
                    'class' => 'form-control',
                ],
            ]
        );

        $this->add(
            [
                'type' => 'Zend\Form\Element\Password',
                'name' => 'password',
                'options' => [
                    'label' => 'Password',
                ],
                'attributes' => [
                    'class' => 'form-control',
                ],
            ]
        );

        $this->add(
            [
                'type' => 'Zend\Form\Element\Password',
                'name' => 'confirmPassword',
                'options' => [
                    'label' => 'Confirm Password',
                ],
                'attributes' => [
                    'class' => 'form-control',
                    'placeholder' => 'Confirm Password',
                ],
            ]
        );

    }
}