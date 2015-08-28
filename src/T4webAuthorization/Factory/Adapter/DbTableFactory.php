<?php

namespace T4webAuthorization\Factory\Adapter;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\Authentication\Adapter\DbTable\CredentialTreatmentAdapter as AuthAdapter;

class DbTableFactory implements FactoryInterface
{

    /**
     * Create service
     *
     * @param ServiceLocatorInterface $serviceLocator
     * @return mixed
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $config = $serviceLocator->get('Config');
        $authConfig = $config['auth']['table'];

        $authAdapter = new AuthAdapter(
            $serviceLocator->get('Zend\Db\Adapter\Adapter'),
            $authConfig['tableName'],
            $authConfig['identityColumn'],
            $authConfig['credentialColumn']
        );

        return $authAdapter;
    }
}