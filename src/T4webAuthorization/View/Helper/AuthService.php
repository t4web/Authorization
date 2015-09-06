<?php

namespace T4webAuthorization\View\Helper;

use Zend\View\Helper\AbstractHelper;
use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\ServiceManager\ServiceLocatorAwareTrait;

class AuthService extends AbstractHelper implements ServiceLocatorAwareInterface
{

    use ServiceLocatorAwareTrait;

    /**
     * Get the service locator.
     *
     * @return \Zend\ServiceManager\ServiceLocatorInterface
     */
    public function getServiceLocator()
    {
        return $this->serviceLocator->getServiceLocator();
    }

    /**
     * @return \T4webAuthorization\Service
     */
    public function __invoke()
    {
        /** @var \T4webAuthorization\Service $authService */
        $authService = $this->getServiceLocator()->get('T4webAuthorization\Service');

        return $authService;
    }
}