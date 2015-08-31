<?php

namespace T4webAuthorization\Factory\Auth\Service;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use T4webAuthorization\Auth\Service\Update;

class UpdateServiceFactory implements FactoryInterface
{

    public function createService(ServiceLocatorInterface $serviceManager)
    {
        $eventManager = $serviceManager->get('EventManager');
        $eventManager->addIdentifiers('T4webAuthorization\Auth\Service\Update');

        $service = new Update(
            $serviceManager->get('T4webAuthorization\Auth\InputFilter\Update'),
            $serviceManager->get('T4webAuthorization\Auth\Repository\DbRepository'),
            $serviceManager->get('T4webAuthorization\Auth\Criteria\CriteriaFactory'),
            $serviceManager->get('T4webAuthorization\Service'),
            $eventManager
        );

        return $service;
    }
}