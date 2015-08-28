<?php

namespace T4webAuthorization\Auth;

use T4webBase\Domain\Entity;

class Auth extends Entity
{

    protected $uname;
    protected $password;

    /**
     * @return mixed
     */
    public function getUname()
    {
        return $this->uname;
    }

    /**
     * @param mixed $uname
     */
    public function setUname($uname)
    {
        $this->uname = $uname;
    }

    /**
     * @return mixed
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param mixed $password
     */
    public function setPassword($password)
    {
        $this->password = $password;
    }

}
