<?php


namespace Auth\Service;

use Auth\Exception\UserNotLoggedInException;
use Doctrine\ORM\EntityManagerInterface;
use Laminas\Authentication\AuthenticationService;
use Laminas\Authentication\Result;

/**
 * Class Auth
 *
 * @package Auth\Service
 */
class Auth
{
    /** @var EntityManagerInterface */
    private $entityManager;

    /** @var AuthenticationService */
    private $authService;

    /**
     * Auth constructor.
     *
     * @param EntityManagerInterface $entityManager
     * @param AuthenticationService  $authService
     */
    public function __construct(EntityManagerInterface $entityManager, AuthenticationService $authService)
    {
        $this->entityManager = $entityManager;
        $this->authService = $authService;
    }

    /**
     * @param string $username
     * @param string $password
     *
     * @return Result
     * @throws UserNotLoggedInException
     */
    public function login(string $username, string $password): Result
    {
        if (null != $this->authService->getIdentity()) {
            throw new UserNotLoggedInException('User is already logged in');
        }

        $authAdapter = $this->authService->getAdapter();
        $authAdapter->setUsername($username);
        $authAdapter->setPassword($password);

        return $authAdapter->authenticate();
    }

    /**
     * @throws UserNotLoggedInException
     */
    public function logout(): void
    {
        if (null == $this->authService->getIdentity()) {
            throw new UserNotLoggedInException('The user is not logged in');
        }

        $this->authService->clearIdentity();
    }
}
