<?php

namespace Authorization\Auth\Service;

use Zend\EventManager\EventManager;
use T4webBase\InputFilter\InputFilterInterface;
use T4webBase\Domain\Repository\DbRepository;
use T4webBase\Domain\Factory\EntityFactoryInterface;
use T4webBase\Domain\Service\Create as BaseCreate;

use Authorization\Service;

class Create extends BaseCreate
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
     * @var EntityFactoryInterface
     */
    protected $entityFactory;

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
        EntityFactoryInterface $entityFactory,
        Service $authService,
        EventManager $eventManager = null
    )
    {
        $this->inputFilter = $inputFilter;
        $this->repository = $repository;
        $this->entityFactory = $entityFactory;
        $this->authService = $authService;
        $this->eventManager = $eventManager;
    }

    /**
     * @param array $data
     * @return EntityInterface|null
     */
    public function create(array $data)
    {
        if(!$this->isValid($data)) {
            return;
        }

        $data['password'] = $this->authService->encryptPassword($data['password']);

        $result = parent::create($data);

        return $result;
    }

}