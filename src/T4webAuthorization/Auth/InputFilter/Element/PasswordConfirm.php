<?php

namespace T4webAuthorization\Auth\InputFilter\Element;

use T4webBase\InputFilter\Element\Password;
use Zend\Validator\Identical;

class PasswordConfirm extends Password
{

    public function __construct($name, $identicalName)
    {
        parent::__construct($name);

        $identical = new Identical($identicalName);
        $identical->setMessage("Пароли не совпадают", Identical::NOT_SAME);

        $this->getValidatorChain()
            ->attach($identical, true);
    }
}
