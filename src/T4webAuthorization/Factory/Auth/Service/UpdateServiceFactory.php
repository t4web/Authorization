<?php

namespace Authorization\Factory\Auth\Service;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Authorization\Auth\Service\Update;

class UpdateServiceFactory implements FactoryInterface
{

    public function createService(ServiceLocatorInterface $serviceManager)
    {
        $eventManager = $serviceManager->get('EventManager');
        $eventManager->addIdentifiers('Authorization\Auth\Service\Update');

        $service = new Update(
            $serviceManager->get('Authorization\Auth\InputFilter\Update'),
            $serviceManager->get('Authorization\Auth\Repository\DbRepository'),
            $serviceManager->get('Authorization\Auth\Criteria\CriteriaFactory'),
            $serviceManager->get('Authorization\Service'),
            $eventManager
        );

        return $service;
    }
}