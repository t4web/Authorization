<?php

namespace T4webAuthorization\Factory\Auth\Form;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

use T4webAuthorization\Auth\Form\Login;

class LoginFactory implements FactoryInterface
{

    public function createService(ServiceLocatorInterface $serviceManager)
    {

        $form = new Login();
        $form->setInputFilter($serviceManager->get('T4webAuthorization\Auth\InputFilter\Create'));

        return $form;
    }
}