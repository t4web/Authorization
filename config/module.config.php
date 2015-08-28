<?php

return [

    'view_manager' => [
        'template_path_stack' => [
            __DIR__ . '/../view',
        ],
    ],
    'auth' => [
        'table' => [
            'tableName' => 'auth',
            'identityColumn' => 'uname',
            'credentialColumn' => 'password',
        ],
        'remember_me_seconds' => 60 * 60 * 24 * 7, // 7 days
    ],
    'router' => [
        'routes' => [
            'login' => [
                'type' => 'Literal',
                'options' => [
                    'route' => '/login',
                    'defaults' => [
                        '__NAMESPACE__' => 'T4webAuthorization\Controller\User',
                        'controller' => 'Index',
                        'action' => 'login',
                    ]
                ]
            ],
            'logout' => [
                'type' => 'Literal',
                'options' => [
                    'route' => '/logout',
                    'defaults' => [
                        '__NAMESPACE__' => 'T4webAuthorization\Controller\User',
                        'controller' => 'Index',
                        'action' => 'logout',
                    ]
                ]
            ],
            'password-remind' => [
                'type' => 'Segment',
                'options' => [
                    'route' => '/password/:action',
                    'defaults' => [
                        '__NAMESPACE__' => 'T4webAuthorization\Controller\User',
                        'controller' => 'Password',
                        'action' => 'remind',
                    ]
                ]
            ],
            'admin-authorization-ajax-auth' => [
                'type' => 'Segment',
                'options' => [
                    'route' => '/admin/authorization/auth/ajax/:action[/:id]',
                    'defaults' => [
                        '__NAMESPACE__' => 'T4webAuthorization\Controller\Admin',
                        'controller' => 'AuthAjax',
                        'action' => 'change-password',
                    ],
                    'constraints' => [
                        'id' => '[1-9][0-9]*',
                    ],
                ]
            ],
        ],
    ],
    'console' => [
        'router' => [
            'routes' => [
                'auth-init' => [
                    'options' => [
                        'route' => 'auth init',
                        'defaults' => [
                            '__NAMESPACE__' => 'T4webAuthorization\Controller\Console',
                            'controller' => 'Init',
                            'action' => 'run'
                        ]
                    ]
                ],
                'auth-fixtures' => [
                    'options' => [
                        'route' => 'auth fixtures',
                        'defaults' => [
                            '__NAMESPACE__' => 'T4webAuthorization\Controller\Console',
                            'controller' => 'Fixtures',
                            'action' => 'run'
                        ]
                    ]
                ],
            ]
        ]
    ],
    'controller_action_injections' => [
        'T4webAuthorization\Controller\User\IndexController' => [
            'loginAction' => [
                'Request',
                'T4webAuthorization\Auth\Form\Login',
                'T4webAuthorization\Service',
                'T4webAuthorization\Controller\ViewModel\User\IndexViewModel',
                function ($serviceLocator) {
                    return $serviceLocator->get('ControllerPluginManager')->get('redirect');
                },
            ],
            'logoutAction' => [
                'T4webAuthorization\Service',
                function ($serviceLocator) {
                    return $serviceLocator->get('ControllerPluginManager')->get('redirect');
                },
            ],
        ],
        'Authorization\Controller\User\PasswordController' => [
            'remindAction' => [
                'request',
                'Authorization\Auth\Form\PasswordRemind',
                'Authorization\Auth\Service\PasswordRemind',
                function ($serviceLocator) {
                    return $serviceLocator->get('ControllerPluginManager')->get('redirect');
                },
                'Authorization\Controller\ViewModel\User\PasswordViewModel',
            ],
            'changePasswordAction' => [
                'request',
                'Authorization\Auth\Form\ChangePassword',
                'Users\User\Service\Finder',
                'Authorization\Auth\Service\PasswordRemind',
                function ($serviceLocator) {
                    return $serviceLocator->get('ControllerPluginManager')->get('redirect');
                },
                'Authorization\Controller\ViewModel\User\PasswordViewModel',
            ],
        ],
        'T4webAuthorization\Controller\Admin\AuthAjaxController' => [
            'changePasswordAction' => [
                'Request',
                'Response',
                'Authorization\Auth\Form\ChangePassword',
                'Authorization\Auth\Service\Finder',
                'Authorization\Auth\Service\Update',
                'Authorization\Controller\ViewModel\Admin\AjaxViewModel',
            ],
            'logoutAction' => [
                'Authorization\Service',
                function ($serviceLocator) {
                    return $serviceLocator->get('ControllerPluginManager')->get('redirect');
                },
            ],
        ],
    ],
    'db' => [
        'tables' => [
            'authorization-auth' => [
                'name' => 'auth',
                'columnsAsAttributesMap' => [
                    'id' => 'id',
                    'uname' => 'uname',
                    'password' => 'password',
                ],
            ],
        ],
    ],
    'criteries' => [
        'Auth' => [
            'empty' => ['table' => 'auth'],
            'Id' => [
                'table' => 'auth',
                'field' => 'id',
                'buildMethod' => 'addFilterEqual'
            ],
            'Uname' => [
                'table' => 'auth',
                'field' => 'uname',
                'buildMethod' => 'addFilterEqual'
            ],
        ],
    ],
];