<?php

namespace Authorization\Auth\Service;

use Authorization\Auth\Auth;
use Authorization\Auth\InputFilter\ChangePassword;
use Authorization\Auth\InputFilter\SendMail;
use T4webBase\Domain\Service\BaseFinder;
use T4webBase\Domain\Service\Update as BaseUpdate;
use T4webBase\InputFilter\ErrorAwareTrait;
use Users\User\User;
use Zend\EventManager\EventManager;

class PasswordRemind
{
    use ErrorAwareTrait;

    private $sendMailInputFilter;
    private $changePasswordInputFilter;
    private $authFinderService;
    private $authUpdateService;
    private $userFinderService;
    private $userUpdateService;

    public function __construct(
        SendMail $sendMailInputFilter,
        ChangePassword $changePasswordInputFilter,
        BaseFinder $authFinderService,
        Update $authUpdateService,
        BaseFinder $userFinderService,
        BaseUpdate $userUpdateService,
        EventManager $eventManager = null
    ) {
        $this->sendMailInputFilter = $sendMailInputFilter;
        $this->changePasswordInputFilter = $changePasswordInputFilter;
        $this->authFinderService = $authFinderService;
        $this->authUpdateService = $authUpdateService;
        $this->userFinderService = $userFinderService;
        $this->userUpdateService = $userUpdateService;
        $this->eventManager = $eventManager;
    }

    public function sendMail($email)
    {
        $this->sendMailInputFilter->setData(['email' => $email]);
        if (!$this->sendMailInputFilter->isValid()) {
            $this->setErrors($this->sendMailInputFilter->getMessages());

            return false;
        }

        /** @var $auth Auth */
        $auth = $this->authFinderService->find(['Authorization' => ['Auth' => ['uname' => $email]]]);
        /** @var $user User */
        $user = $this->userFinderService->find(['Users' => ['User' => ['AuthId' => $auth->getId()]]]);
        if (empty($user->getConfirmCode())) {
            $user->generateConfirmCode();
            $this->userUpdateService->update($user->getId(), $user->extract());
        }

        $this->eventManager->trigger(__FUNCTION__, $this, compact('user'));

        return true;
    }

    public function changePassword(User $user, array $data)
    {
        $this->changePasswordInputFilter->setData($data);
        if (!$this->changePasswordInputFilter->isValid()) {
            $this->setErrors($this->changePasswordInputFilter->getMessages());

            return false;
        }

        /** @var $auth Auth */
        $auth = $this->authFinderService->find(['Authorization' => ['Auth' => ['id' => $user->getAuthId()]]]);
        $auth->setPassword($this->changePasswordInputFilter->get('password')->getValue());
        $this->authUpdateService->update($auth->getId(), $auth->extract());

        $user->clearConfirmCode();
        $this->userUpdateService->update($user->getId(), $user->extract());

        return true;
    }
}