<?php

namespace T4webAuthorization\Auth\Service;

use Zend\EventManager\EventManager;
use T4webBase\InputFilter\InputFilterInterface;
use T4webBase\Domain\Repository\DbRepository;
use T4webBase\Domain\Service\Update as BaseUpdate;
use T4webBase\Domain\Criteria\Factory as CriteriaFactory;
use T4webAuthorization\Service;

class Update extends BaseUpdate
{

    /**
     * @var InputFilterInterface
     */
    protected $inputFilter;

    /**
     * @var DbRepository
     */
    protected $repository;

    /**
     * @var CriteriaFactory
     */
    protected $criteriaFactory;

    /**
     * @var Service
     */
    protected $authService;

    /**
     * @var EventManager
     */
    protected $eventManager;

    public function __construct(
        InputFilterInterface $inputFilter,
        DbRepository $repository,
        CriteriaFactory $criteriaFactory,
        Service $authService,
        EventManager $eventManager = null
    )
    {
        $this->inputFilter = $inputFilter;
        $this->repository = $repository;
        $this->criteriaFactory = $criteriaFactory;
        $this->authService = $authService;
        $this->eventManager = $eventManager;
    }

    public function update($id, array $data, $encryptPassword = true)
    {
        if(!$this->isValid($data)) {
            return;
        }

        if($encryptPassword == true) {
            $data['password'] = $this->authService->encryptPassword($data['password']);
        }

        $result = parent::update($id, $data);

        return $result;
    }

}