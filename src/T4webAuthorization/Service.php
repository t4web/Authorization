<?php

namespace T4webAuthorization;

use Zend\Authentication\AuthenticationService;
use Zend\Authentication\Adapter\DbTable\CredentialTreatmentAdapter as AuthAdapter;
use Zend\Authentication\Result as AuthResult;

class Service
{

    /**
     * @var AuthAdapter
     */
    protected $authAdapter;

    /**
     * @var AuthenticationService
     */
    protected $authService;

    /**
     * @var
     */
    protected $config;

    public function __construct(
        AuthAdapter $authAdapter,
        AuthenticationService $authService,
        $config
    ) {
        $this->authAdapter = $authAdapter;
        $this->authService = $authService;
        $this->config = $config;
    }

    /**
     * Performs an authentication attempt
     *
     * @param      $userName
     * @param      $password
     * @param bool $rememberMe
     * @param bool $encryptPassword
     * @return AuthResult
     */
    public function authenticate($userName, $password, $rememberMe = false, $encryptPassword = false)
    {

        if($encryptPassword === false) {
            $password = $this->encryptPassword($password);
        }

        $this->authAdapter->setIdentity($userName);
        $this->authAdapter->setCredential($password);

        /* @var $result AuthResult */
        $result = $this->authService->authenticate($this->authAdapter);

        if ($result->isValid()) {
            $resultRow = $this->authAdapter->getResultRowObject();

            $storage = $this->authService->getStorage();

            if (true == $rememberMe) {
                $storage->setRememberMe($this->config['auth']['remember_me_seconds']);
            }

            $storage->write(['id' => $resultRow->id]);
        }

        return $result;
    }

    /**
     * Returns true if and only if an identity is available from storage
     *
     * @return bool
     */
    public function hasIdentity()
    {
        return $this->authService->hasIdentity();
    }

    /**
     * Returns the identity from storage or null if no identity is available
     *
     * @return mixed|null
     */
    public function getIdentity()
    {
        return $this->authService->getIdentity();
    }

    /**
     * @return int
     */
    public function getUserId()
    {
        $storage = $this->authService->getStorage()->read();

        if (!isset($storage['id'])) {
            return 0;
        }

        return (int)$storage['id'];
    }

    /**
     * Clears the identity from persistent storage
     *
     * @return void
     */
    public function logout()
    {
        $this->authService->getStorage()->forgetMe();
        $this->authService->clearIdentity();
    }

    /**
     * Encrypt user password
     *
     * @param $password
     * @return string
     */
    public function encryptPassword($password)
    {
        return hash_hmac('ripemd160', $password, 'space_secret_key');
    }
}