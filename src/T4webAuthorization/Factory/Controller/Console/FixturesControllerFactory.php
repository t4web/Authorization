<?php

namespace T4webAuthorization\Factory\Controller\Console;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

use T4webAuthorization\Controller\Console\FixturesController;

class FixturesControllerFactory implements FactoryInterface
{

    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $serviceManager = $serviceLocator->getServiceLocator();

        return new FixturesController(
            $serviceManager->get('Zend\Db\Adapter\Adapter')
        );
    }
}