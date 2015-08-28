<?php

namespace T4webAuthorization\Storage;

use Zend\Authentication\Storage\Session as Storage;

class Session extends Storage
{

    public function setRememberMe($time = null)
    {
        $this->session->getManager()->rememberMe($time);
    }

    public function forgetMe()
    {
        $this->session->getManager()->forgetMe();
    }
}
