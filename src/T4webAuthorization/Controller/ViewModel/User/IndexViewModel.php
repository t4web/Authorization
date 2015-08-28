<?php

namespace T4webAuthorization\Controller\ViewModel\User;

use Zend\View\Model\ViewModel;
use T4webBase\InputFilter\InvalidInputError;

class IndexViewModel extends ViewModel
{
    /**
     * @var \Zend\Form\Form
     */
    protected $form;

    /**
     * @param null $element
     * @return \Zend\Form\ElementInterface|\Zend\Form\Form
     */
    public function getForm($element = null)
    {
        if (!empty($element)) {
            return $this->form->get($element);
        }

        return $this->form;
    }

    /**
     * @param \Zend\Form\Form $form
     */
    public function setForm($form)
    {
        $this->form = $form;
    }

    /**
     * @param InvalidInputError $errors
     */
    public function setErrors(InvalidInputError $errors)
    {
        $this->setVariable('errors', $errors->getErrors());
    }

    /**
     * @return mixed
     */
    public function getErrors()
    {
        return $this->getVariable('errors');
    }

}
