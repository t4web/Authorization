<?php

namespace Authorization\Factory\Auth\Service;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Authorization\Auth\Service\Create;

class CreateServiceFactory implements FactoryInterface
{

    public function createService(ServiceLocatorInterface $serviceManager)
    {
        $eventManager = $serviceManager->get('EventManager');
        $eventManager->addIdentifiers('Authorization\Auth\Service\Create');

        $service = new Create(
            $serviceManager->get('Authorization\Auth\InputFilter\Create'),
            $serviceManager->get('Authorization\Auth\Repository\DbRepository'),
            $serviceManager->get('Authorization\Auth\Factory\EntityFactory'),
            $serviceManager->get('Authorization\Service'),
            $eventManager
        );

        return $service;
    }
}