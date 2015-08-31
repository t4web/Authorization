<?php

namespace T4webAuthorization\Factory\Auth\Service;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use T4webAuthorization\Auth\Service\Create;

class CreateServiceFactory implements FactoryInterface
{

    public function createService(ServiceLocatorInterface $serviceManager)
    {
        $eventManager = $serviceManager->get('EventManager');
        $eventManager->addIdentifiers('T4webAuthorization\Auth\Service\Create');

        $service = new Create(
            $serviceManager->get('T4webAuthorization\Auth\InputFilter\Create'),
            $serviceManager->get('T4webAuthorization\Auth\Repository\DbRepository'),
            $serviceManager->get('T4webAuthorization\Auth\Factory\EntityFactory'),
            $serviceManager->get('T4webAuthorization\Service'),
            $eventManager
        );

        return $service;
    }
}