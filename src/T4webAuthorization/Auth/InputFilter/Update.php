<?php

namespace T4webAuthorization\Auth\InputFilter;

use T4webBase\InputFilter\InputFilter;
use T4webBase\InputFilter\Element\Id;
use T4webBase\InputFilter\Element\Email;
use T4webBase\InputFilter\Element\Password;

class Update extends InputFilter
{

    public function __construct()
    {

        $id = new Id('id');
        $id->setRequired(false);
        $this->add($id);

        $uname = new Email('uname', 1, 50);
        $this->add($uname);

        $password = new Password('password');
        $password->setRequired(false);
        $this->add($password);
    }
}
