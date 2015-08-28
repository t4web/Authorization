<?php

namespace T4webAuthorization\Auth\InputFilter\Element;

use T4webBase\InputFilter\Element\Name;
use Zend\Validator\Db\NoRecordExists;
use Zend\Validator\EmailAddress;

class Uname extends Name
{

    private $dbNoRecordExistsValidator;

    public function __construct($options, $name = null)
    {

        $emailValidator = new EmailAddress();
        $emailValidator->setMessage('Указан неверный email');

        $this->dbNoRecordExistsValidator = new NoRecordExists($options);
        $this->dbNoRecordExistsValidator->setMessages(
            [
                NoRecordExists::ERROR_RECORD_FOUND => "Такой пользователь уже существует",
            ]
        );

        $this->getValidatorChain()
            ->attach($emailValidator, true)
            ->attach($this->dbNoRecordExistsValidator, true);

        $this->getFilterChain()
            ->attachByName('StringTrim')
            ->attachByName('StringToLower');

        parent::__construct($name, 1, 50);
    }

    public function isValid($context = null)
    {

        if (isset($context['id']) && !empty($context['id'])) {
            $this->dbNoRecordExistsValidator->setExclude("id <> {$context['id']}");
        }

        return parent::isValid($context);
    }
}