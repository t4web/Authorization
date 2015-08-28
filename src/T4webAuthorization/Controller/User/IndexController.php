<?php

namespace T4webAuthorization\Controller\User;

use T4webActionInjections\Mvc\Controller\AbstractActionController;

use Zend\Http\PhpEnvironment\Request;
use T4webAuthorization\Auth\Form\Login as LoginForm;
use T4webAuthorization\Service as AuthService;
use T4webAuthorization\Controller\ViewModel\User\IndexViewModel as View;
use Zend\Mvc\Controller\Plugin\Redirect;

use Zend\Authentication\Result as AuthResult;

class IndexController extends AbstractActionController
{

    public function loginAction(
        Request $request,
        LoginForm $form,
        AuthService $authService,
        View $view,
        Redirect $redirect
    ) {
        $view->setForm($form);

        if ($request->isPost()) {
            $form->setData($request->getPost());

            if ($form->isValid()) {
                $data = $form->getData();

                /* @var AuthResult */
                $result = $authService->authenticate($data['uname'], $data['password'], $data['rememberMe']);

                if ($result->getCode() != AuthResult::SUCCESS) {
                    $form->setMessages(['password' => ['Неверный логин или пароль']]);

                    return $view;
                }

                if ($routeName = $request->getQuery('fromRoute', null)) {
                    $routeParams = [];
                    if ($routeUrl = $request->getQuery('url', null)) {
                        $routeParams['url'] = $routeUrl;
                    }
                    if ($routeAction = $request->getQuery('action', null)) {
                        $routeParams['action'] = $routeAction;
                    }
                    return $redirect->toRoute($routeName, $routeParams);
                }

                return $redirect->toRoute('home');
            }
        }

        return $view;
    }

    public function logoutAction(AuthService $authService, Redirect $redirect)
    {
        $authService->logout();

        return $redirect->toRoute('home');
    }
}