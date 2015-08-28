<?php

namespace Authorization\Controller\Admin;

use T4webActionInjections\Mvc\Controller\AbstractActionController;
use Zend\Http\PhpEnvironment\Request;
use Zend\Http\PhpEnvironment\Response;
use Authorization\Auth\Form\ChangePassword;
use T4webBase\Domain\Service\BaseFinder;
use Authorization\Auth\Service\Update;
use Authorization\Controller\ViewModel\Admin\AjaxViewModel;
use Zend\Json\Json;
use Authorization\Auth\Auth;

class AuthAjaxController extends AbstractActionController
{

    public function changePasswordAction(
        Request $request,
        Response $response,
        ChangePassword $form,
        BaseFinder $authServiceFinder,
        Update $authServiceUpdate,
        AjaxViewModel $view
    ) {

        if (!$request->isPost() && !$request->isPut()) {
            return $view;
        }

        $data = Json::decode($request->getContent(), Json::TYPE_ARRAY);

        $form->setData($data);

        if (!$form->isValid()) {
            $response->setStatusCode(Response::STATUS_CODE_404);
            $view->setErrors($form->getMessages());

            return $view;
        }

        /** @var Auth $entity */
        $entity = $authServiceFinder->find(['Authorization' => ['Auth' => ['Id' => (int)$data['id']]]]);

        if (!$entity) {
            $response->setStatusCode(Response::STATUS_CODE_404);
            $view->setErrors(['message' => 'bad params']);

            return $view;
        }

        $entity->setPassword($data['password']);
        $authServiceUpdate->update($entity->getId(), $entity->extract());

        return $view;

    }

}