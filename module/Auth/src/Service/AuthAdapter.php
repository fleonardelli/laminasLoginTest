<?php


namespace Auth\Service;


use Auth\Controller\Exception\InvalidPasswordException;
use Auth\Entity\User as UserEntity;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityNotFoundException;
use Laminas\Authentication\Adapter\AdapterInterface;
use Laminas\Authentication\Result;
use Laminas\Crypt\Password\Bcrypt;

/**
 * Class AuthAdapter
 *
 * @package Auth\Service
 */
class AuthAdapter implements AdapterInterface
{
    /** @var string */
    private $username;
    /** @var string */
    private $password;
    /** @var EntityManagerInterface */
    private $entityManager;
    /** @var Bcrypt */
    private $bCrypt;

    /**
     * AuthAdapter constructor.
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
     */
    public function setUsername(string $username): void
    {
        $this->username = $username;
    }

    /**
     * @param string $password
     */
    public function setPassword(string $password): void
    {
        $this->password = $password;
    }

    /**
     * @return Result
     */
    public function authenticate(): Result
    {
        $repository = $this->entityManager->getRepository(UserEntity::class);

        /** @var UserEntity $user */
        $user = $repository->findOneBy(['username' => $this->username]);

        if (null == $user) {
            return new Result(
                Result::FAILURE_IDENTITY_NOT_FOUND,
                null,
                ['Username not registered']
            );
        }

        if (!$this->bCrypt->verify($this->password, $user->getPassword())) {
            return new Result(
                Result::FAILURE_CREDENTIAL_INVALID,
                null,
                ['Incorrect Password']
            );
        }

        return new Result(
            Result::SUCCESS,
            $this->username,
            ['Successful authentication']
        );
    }
}
