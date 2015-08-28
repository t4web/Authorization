<?php

namespace Authorization\Factory\Auth\Form;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

use Authorization\Auth\Form\ChangePassword;

class ChangePasswordFactory implements FactoryInterface
{

    public function createService(ServiceLocatorInterface $serviceManager)
    {

        $form = new ChangePassword();
        $form->setInputFilter($serviceManager->get('Authorization\Auth\InputFilter\ChangePassword'));

        return $form;
    }
}