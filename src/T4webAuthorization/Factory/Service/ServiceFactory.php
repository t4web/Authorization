<?php

namespace T4webAuthorization\Factory\Service;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

use T4webAuthorization\Service;

class ServiceFactory implements FactoryInterface
{

    /**
     * Create service
     *
     * @param ServiceLocatorInterface $serviceLocator
     * @return mixed
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {

        $service = new Service(
            $serviceLocator->get('T4webAuthorization\Adapter\DbTable'),
            $serviceLocator->get('T4webAuthorization\Service\AuthenticationService'),
            $serviceLocator->get('config')
        );

        return $service;
    }
}