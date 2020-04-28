<?php


namespace Auth\Service;

use Auth\Exception\UserLoggedInException;
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
    /** @var AuthenticationService */
    private $authenticationService;

    /** @var array  */
    private $config;

    /**
     * Auth constructor.
     *
     * @param AuthenticationService $authenticationService
     * @param array                 $config
     */
    public function __construct(
        AuthenticationService $authenticationService,
        array $config
    ) {
        $this->authenticationService = $authenticationService;
        $this->config = $config;
    }

    /**
     * @param string $username
     * @param string $password
     *
     * @return Result
     * @throws UserLoggedInException
     */
    public function login(string $username, string $password): Result
    {
        if (null != $this->authenticationService->getIdentity()) {
            throw new UserLoggedInException('User is already logged in');
        }

        $authAdapter = $this->authenticationService->getAdapter();
        $authAdapter->setUsername($username);
        $authAdapter->setPassword($password);

        return $this->authenticationService->authenticate($authAdapter);
    }

    /**
     * @throws UserNotLoggedInException
     */
    public function logout(): void
    {
        if (null == $this->authenticationService->getIdentity()) {
            throw new UserNotLoggedInException('The user is not logged in');
        }

        $this->authenticationService->clearIdentity();
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
                    else if ('@' == $allow && $this->authenticationService->hasIdentity()) {

                        return true;
                    } else {

                        return false;
                    }
                }
            }
        }

        if ('restrictive' == $mode && !$this->authenticationService->hasIdentity()) {

            return false;
        }

        return true;
    }

}
