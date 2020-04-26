<?php


namespace Auth\Service;


use Auth\Controller\Exception\InvalidPasswordException;
use Auth\Entity\User as UserEntity;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityNotFoundException;
use Laminas\Crypt\Password\Bcrypt;

/**
 * Class User
 *
 * @package Auth\Service
 */
class User
{
    /** @var EntityManagerInterface */
    private $entityManager;

    /** @var Bcrypt */
    private $bCrypt;

    /**
     * User constructor.
     *
     * @param EntityManagerInterface $entityManager
     * @param Bcrypt                 $bCrypt
     */
    public function __construct(EntityManagerInterface $entityManager, Bcrypt $bCrypt)
    {
        $this->entityManager = $entityManager;
        $this->bCrypt = $bCrypt;
    }

    /**
     * @param string $username
     * @param string $password
     *
     * @return UserEntity
     * @throws EntityNotFoundException
     * @throws InvalidPasswordException
     */
    public function getUserByUserPass(string $username, string $password): UserEntity
    {
        $repository = $this->entityManager->getRepository(UserEntity::class);
        /** @var UserEntity $user */
        $user = $repository->findOneBy(['username' => $username]);

        if (null == $user) {
            throw new EntityNotFoundException('Username not registered');
        }

        if (!$this->bCrypt->verify($password, $user->getPassword())) {
            throw new InvalidPasswordException('Incorrect Password');
        }

        return $user;
    }




}
