<?php


namespace Auth\Service;


use Auth\Entity\User as UserEntity;
use Doctrine\ORM\EntityManagerInterface;

/**
 * Class User
 *
 * @package Auth\Service
 */
class User
{
    /** @var EntityManagerInterface */
    private $entityManager;


    /**
     * User constructor.
     *
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @return array
     */
    public function getUserBy(): array
    {
        $repository = $this->entityManager->getRepository(UserEntity::class);

        return $repository->findAll();
    }


}
