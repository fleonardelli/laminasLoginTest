<?php


namespace Auth\Service;

use Auth\Exception\UserNotLoggedInException;
use Doctrine\ORM\EntityManagerInterface;
use Laminas\Authentication\AuthenticationService;
use Laminas\Authentication\Result;
use Laminas\Config\Config;

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

    /** @var array  */
    private $config;

    /**
     * Auth constructor.
     *
     * @param EntityManagerInterface $entityManager
     * @param AuthenticationService  $authService
     * @param array                  $config
     */
    public function __construct(
        EntityManagerInterface $entityManager,
        AuthenticationService $authService,
        array $config
    ) {
        $this->entityManager = $entityManager;
        $this->authService = $authService;
        $this->config = $config;
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

        return $this->authService->authenticate($authAdapter);
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


    /**
     * @param string $controllerName
     * @param string $actionName
     *
     * @return bool
     * @throws \Exception
     */
    public function filterAccess(string $controllerName, string $actionName): bool
    {
        $mode = isset($this->config['options']['mode'])
            ? $this->config['options']['mode']
            : 'restrictive';

        if (!in_array($mode, ['restrictive', 'permissive'])) {

            throw new \InvalidArgumentException(
                'Invalid access filter mode (expected either restrictive or permissive mode');
        }

        if (isset($this->config['controllers'][$controllerName])) {
            $items = $this->config['controllers'][$controllerName];

            foreach ($items as $item) {
                $actionList = $item['actions'];
                $allow = $item['allow'];

                if (is_array($actionList) &&
                    in_array($actionName, $actionList) ||
                    '*' == $actionList
                ) {
                    if ('*' == $allow)

                        return true;
                    else if ('@' == $allow && $this->authService->hasIdentity()) {

                        return true;
                    } else {

                        return false;
                    }
                }
            }
        }

        if ('restrictive' == $mode && !$this->authService->hasIdentity()) {

            return false;
        }

        return true;
    }

}
