<?php

namespace T4webAuthorization\Factory\Controller\ViewModel;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use T4webAuthorization\Controller\ViewModel\AjaxViewModel;

class AjaxViewModelFactory implements FactoryInterface
{

    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        return new AjaxViewModel($serviceLocator->get('Response'));
    }
}