<?php

namespace T4webAuthorization\Factory\Auth\Service;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

use T4webBase\Domain\Service\BaseFinder as Finder;

class FinderServiceFactory implements FactoryInterface
{

    public function createService(ServiceLocatorInterface $serviceManager)
    {

        $service = new Finder(
            $serviceManager->get('T4webAuthorization\Auth\Repository\DbRepository'),
            $serviceManager->get('T4webAuthorization\Auth\Criteria\CriteriaFactory')
        );

        return $service;
    }
}