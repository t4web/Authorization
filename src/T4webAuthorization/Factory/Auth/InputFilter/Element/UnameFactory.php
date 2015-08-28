<?php

namespace T4webAuthorization\Factory\Auth\InputFilter\Element;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use T4webAuthorization\Auth\InputFilter\Element\Uname;

class UnameFactory implements FactoryInterface
{

    public function createService(ServiceLocatorInterface $serviceManager)
    {
        $name = 'uname';

        $options = [
            'adapter' => $serviceManager->get('Zend\Db\Adapter\Adapter'),
            'table' => 'auth',
            'field' => $name
        ];

        return new Uname($options, $name);
    }
}