<?php

namespace T4webAuthorization\Controller\User;

use T4webActionInjections\Mvc\Controller\AbstractActionController;
use Zend\Http\PhpEnvironment\Request;
use T4webAuthorization\Service as AuthService;
use T4webAuthorization\Auth\InputFilter\PasswordChange as Filter;
use T4webBase\Domain\Service\BaseFinder as Finder;
use T4webAuthorization\Auth\Service\Update;
use T4webAuthorization\Controller\ViewModel\AjaxViewModel;
use Zend\Json\Json;
use T4webAuthorization\Auth\Auth;

class AuthAjaxController extends AbstractActionController
{

    public function changePasswordAction(
        Request $request,
        AuthService $authService,
        Filter $filter,
        Finder $authServiceFinder,
        Update $authServiceUpdate,
        AjaxViewModel $view
    ) {

        if (!$request->isPut() || !$authService->hasIdentity()) {
            $view->setErrors([]);
            return $view;
        }

        $data = Json::decode($request->getContent(), Json::TYPE_ARRAY);

        $filter->setData($data);

        if (!$filter->isValid()) {
            $view->setErrors($filter->getMessages());

            return $view;
        }

        /** @var Auth $entity */
        $entity = $authServiceFinder->find(['T4webAuthorization' => ['Auth' => ['Id' => (int)$authService->getId()]]]);

        if (!$entity) {
            $view->setErrors(['message' => 'bad params']);

            return $view;
        }

        $entity->setPassword($data['password']);
        $authServiceUpdate->update($entity->getId(), $entity->extract());

        return $view;

    }

}