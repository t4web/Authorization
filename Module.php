<?php

namespace T4webAuthorization;

use Zend\Console\Adapter\AdapterInterface;
use Zend\ModuleManager\Feature\AutoloaderProviderInterface;
use Zend\ModuleManager\Feature\ConfigProviderInterface;
use Zend\ModuleManager\Feature\ConsoleUsageProviderInterface;
use Zend\ModuleManager\Feature\ServiceProviderInterface;
use Zend\ModuleManager\Feature\ControllerProviderInterface;
use Zend\ModuleManager\Feature\ViewHelperProviderInterface;

use Zend\Mvc\MvcEvent;
use Zend\Mvc\ModuleRouteListener;

class Module implements AutoloaderProviderInterface, ConfigProviderInterface, ConsoleUsageProviderInterface,
    ServiceProviderInterface, ControllerProviderInterface, ViewHelperProviderInterface
{

    public function onBootstrap(MvcEvent $e)
    {
        $eventManager = $e->getApplication()->getEventManager();
        $moduleRouteListener = new ModuleRouteListener();
        $moduleRouteListener->attach($eventManager);

        $eventManager->attach('dispatch', [$this, 'checkLogin']);
    }

    public function checkLogin($e)
    {

        /** @var Service $authService */
        $authService = $e->getApplication()->getServiceManager()->get("T4webAuthorization\\Service");
        $target = $e->getTarget();
        $match = $e->getRouteMatch();

        $routeName = $match->getMatchedRouteName();
        if ($authService->hasIdentity() && $routeName == 'login') {
            return $target->redirect()->toUrl('/');
        }
    }

    /**
     * Returns configuration to merge with application configuration
     *
     * @return array|\Traversable
     */
    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }

    /**
     * Return an array for passing to Zend\Loader\AutoloaderFactory.
     *
     * @return array
     */
    public function getAutoloaderConfig()
    {
        return [
            'Zend\Loader\StandardAutoloader' => [
                'namespaces' => [
                    // Autoload all classes from namespace 'T4webAuthorization' from '/module/Authorization/src/Authorization'
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ]
            ]
        ];
    }

    /**
     * Returns an array or a string containing usage information for this module's Console commands.
     * The method is called with active Zend\Console\Adapter\AdapterInterface that can be used to directly access
     * Console and send output.
     *
     * If the result is a string it will be shown directly in the console window.
     * If the result is an array, its contents will be formatted to console window width. The array must
     * have the following format:
     *
     *     return array(
     *                'Usage information line that should be shown as-is',
     *                'Another line of usage info',
     *
     *                '--parameter'        =>   'A short description of that parameter',
     *                '-another-parameter' =>   'A short description of another parameter',
     *                ...
     *            )
     *
     * @param AdapterInterface $console
     * @return array|string|null
     */
    public function getConsoleUsage(AdapterInterface $console)
    {
        return [
            'auth init' => 'Initialize module',
            'auth fixtures' => 'Filled with data',
        ];
    }

    /**
     * Expected to return \Zend\ServiceManager\Config object or array to
     * seed such an object.
     *
     * @return array|\Zend\ServiceManager\Config
     */
    public function getServiceConfig()
    {
        return [
            'factories' => [
                'T4webAuthorization\Service' => 'T4webAuthorization\Factory\Service\ServiceFactory',
                'T4webAuthorization\Service\AuthenticationService' => 'T4webAuthorization\Factory\Service\AuthenticationServiceFactory',
                'T4webAuthorization\Adapter\DbTable' => 'T4webAuthorization\Factory\Adapter\DbTableFactory',

                'T4webAuthorization\Auth\Form\Login' => 'T4webAuthorization\Factory\Auth\Form\LoginFactory',
                'T4webAuthorization\Auth\InputFilter\Element\Uname' => 'T4webAuthorization\Factory\Auth\InputFilter\Element\UnameFactory',

                'T4webAuthorization\Auth\Service\Finder' => 'T4webAuthorization\Factory\Auth\Service\FinderServiceFactory',
                'T4webAuthorization\Auth\Service\Create' => 'T4webAuthorization\Factory\Auth\Service\CreateServiceFactory',
                'T4webAuthorization\Auth\Service\Update' => 'T4webAuthorization\Factory\Auth\Service\UpdateServiceFactory',

                'T4webAuthorization\Auth\Service\PasswordRemind' => 'T4webAuthorization\Factory\Auth\Service\PasswordRemindServiceFactory',
                'T4webAuthorization\Auth\Form\PasswordChange' => 'T4webAuthorization\Factory\Auth\Form\PasswordChangeFactory',
                'T4webAuthorization\Controller\ViewModel\AjaxViewModel' => 'T4webAuthorization\Factory\Controller\ViewModel\AjaxViewModelFactory',

            ],
            'invokables' => [
                'T4webAuthorization\Storage\Session' => 'T4webAuthorization\Storage\Session',
                'T4webAuthorization\Auth\InputFilter\Create' => 'T4webAuthorization\Auth\InputFilter\Create',
                'T4webAuthorization\Auth\InputFilter\Update' => 'T4webAuthorization\Auth\InputFilter\Update',
                'T4webAuthorization\Controller\ViewModel\User\IndexViewModel' => 'T4webAuthorization\Controller\ViewModel\User\IndexViewModel',
                'Authorization\Auth\Form\PasswordRemind',
                'T4webAuthorization\Auth\InputFilter\PasswordChange' => 'T4webAuthorization\Auth\InputFilter\PasswordChange',
                'Authorization\Controller\ViewModel\User\PasswordViewModel' => 'Authorization\Controller\ViewModel\User\PasswordViewModel',
            ],
        ];
    }

    /**
     * Expected to return \Zend\ServiceManager\Config object or array to seed
     * such an object.
     *
     * @return array|\Zend\ServiceManager\Config
     */
    public function getControllerConfig()
    {
        return [
            'factories' => [
                'T4webAuthorization\Controller\Console\Init' => 'T4webAuthorization\Factory\Controller\Console\InitControllerFactory',
                'T4webAuthorization\Controller\Console\Fixtures' => 'T4webAuthorization\Factory\Controller\Console\FixturesControllerFactory',
            ],
            'invokables' => [
                'T4webAuthorization\Controller\User\Index' => 'T4webAuthorization\Controller\User\IndexController',
                'T4webAuthorization\Controller\User\Password' => 'T4webAuthorization\Controller\User\PasswordController',
                'T4webAuthorization\Controller\User\AuthAjax' => 'T4webAuthorization\Controller\User\AuthAjaxController',
            ],
        ];
    }

    /**
     * Expected to return \Zend\ServiceManager\Config object or array to
     * seed such an object.
     *
     * @return array|\Zend\ServiceManager\Config
     */
    public function getViewHelperConfig()
    {
        return [
            'invokables' => [
                'auth' => 'T4webAuthorization\View\Helper\Auth',
            ],
        ];
    }
}