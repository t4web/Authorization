<?php

namespace T4webAuthorization\Auth\InputFilter;

use T4webBase\InputFilter\InputFilter;
use T4webBase\InputFilter\Element\Id;
use T4webBase\InputFilter\Element\Name;
use T4webBase\InputFilter\Element\Password;
use T4webBase\InputFilter\Element\Int;

class Create extends InputFilter
{

    public function __construct()
    {

        $id = new Id('id');
        $id->setRequired(false);
        $this->add($id);

        $uname = new Name('uname');
        $uname->setRequired(true);
        $uname->getFilterChain()
            ->attachByName('StringTrim')
            ->attachByName('StringToLower');
        $this->add($uname);

        $password = new Password('password');
        $password->isRequired(true);
        $this->add($password);

        $rememberMe = new Int('rememberMe');
        $rememberMe->setRequired(false);
        $this->add($rememberMe);
    }
}
