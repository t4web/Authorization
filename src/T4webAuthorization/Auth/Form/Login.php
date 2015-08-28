<?php

namespace T4webAuthorization\Auth\Form;

use Zend\Form\Form;

class Login extends Form
{

    public function __construct()
    {
        parent::__construct('login');

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
                'type' => 'Zend\Form\Element\Checkbox',
                'name' => 'rememberMe',
                'options' => [
                    'label' => 'Remember Me?',
                    'use_hidden_element' => false,
                    'checked_value' => '1',
                    'unchecked_value' => '0',
                ]
            ]
        );
    }
}