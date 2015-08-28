<?php

namespace T4webAuthorization\Factory\Service;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\Authentication\AuthenticationService;

class AuthenticationServiceFactory implements FactoryInterface
{

    /**
     * Create service
     *
     * @param ServiceLocatorInterface $serviceLocator
     * @return mixed
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $authService = new AuthenticationService();

        $storage = $serviceLocator->get('T4webAuthorization\Storage\Session');
        $authService->setStorage($storage);

        return $authService;
    }
}