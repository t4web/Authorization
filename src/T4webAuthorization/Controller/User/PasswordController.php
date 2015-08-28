<?php

namespace Authorization\Controller\User;

use Authorization\Auth\Form\ChangePassword as ChangePasswordForm;
use Authorization\Auth\Form\PasswordRemind as PasswordRemindForm;
use Authorization\Auth\Service\PasswordRemind as PasswordRemindService;
use T4webActionInjections\Mvc\Controller\AbstractActionController;
use T4webBase\Domain\Service\BaseFinder;
use Users\User\User;
use Zend\Http\PhpEnvironment\Request;
use Authorization\Controller\ViewModel\User\PasswordViewModel;
use Zend\Mvc\Controller\Plugin\Redirect;

class PasswordController extends AbstractActionController
{

    public function remindAction(
        Request $request,
        PasswordRemindForm $form,
        PasswordRemindService $passwordRemind,
        Redirect $redirect,
        PasswordViewModel $view
    ) {
        $view->setForm($form);
        if (!$request->isPost()) {
            return $view;
        }

        $email = $request->getPost('email', '');
        if (!$passwordRemind->sendMail($email)) {
            $form->setData(['email' => $email]);
            $form->setMessages($passwordRemind->getErrors()->toArray());

            return $view;
        }

        return $redirect->toRoute('password-remind', ['action' => 'send-remind-mail']);
    }

    public function sendRemindMailAction() {
        return;
    }

    public function changePasswordAction(
        Request $request,
        ChangePasswordForm $form,
        BaseFinder $userFinderService,
        PasswordRemindService $passwordRemind,
        Redirect $redirect,
        PasswordViewModel $view
    ) {
        $code = $request->getQuery('code');
        if (empty($code)) {
            return $redirect->toRoute('home');
        }

        /** @var $user User */
        $user = $userFinderService->find(['Users' => ['User' => ['confirmCode' => $code]]]);
        if (!$user) {
            return $redirect->toRoute('home');
        }

        $view->setForm($form);
        if (!$request->isPost()) {
            return $view;
        }

        $data = $request->getPost()->toArray();
        if (!$passwordRemind->changePassword($user, $data)) {
            $form->setData($data);
            $form->setMessages($passwordRemind->getErrors()->toArray());

            return $view;
        }

        return $redirect->toRoute('password-remind', ['action' => 'success-changed']);
    }

    public function successChangedAction() {
        return;
    }
}