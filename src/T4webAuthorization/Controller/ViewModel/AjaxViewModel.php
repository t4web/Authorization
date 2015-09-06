<?php

namespace T4webAuthorization\Controller\ViewModel;

use Zend\View\Model\JsonModel;
use Zend\Http\PhpEnvironment\Response;

class AjaxViewModel extends JsonModel
{

    protected $response;

    public function __construct(Response $response)
    {
        $this->response = $response;
    }

    /**
     * @param array $errors
     * @param int   $code
     */
    public function setErrors(array $errors, $code = Response::STATUS_CODE_400)
    {
        $this->setVariable('errors', $errors);

        $this->response->setStatusCode($code);
    }
}
