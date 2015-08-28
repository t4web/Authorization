<?php

namespace Authorization\Factory\Auth\Service;

use Authorization\Auth\Service\PasswordRemind;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class PasswordRemindServiceFactory implements FactoryInterface
{

    public function createService(ServiceLocatorInterface $serviceManager)
    {
        $eventManager = $serviceManager->get('EventManager');
        $eventManager->addIdentifiers('Authorization\Auth\Service\PasswordRemind');

        $service = new PasswordRemind(
            $serviceManager->get('Authorization\Auth\InputFilter\SendMail'),
            $serviceManager->get('Authorization\Auth\InputFilter\ChangePassword'),
            $serviceManager->get('Authorization\Auth\Service\Finder'),
            $serviceManager->get('Authorization\Auth\Service\Update'),
            $serviceManager->get('Users\User\Service\Finder'),
            $serviceManager->get('Users\User\Service\Update'),
            $eventManager
        );

        return $service;
    }
}