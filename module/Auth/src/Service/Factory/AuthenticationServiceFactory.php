<?php


namespace Auth\Service\Factory;

use Auth\Service\AuthAdapter;
use Laminas\Authentication\AuthenticationService;
use Laminas\ServiceManager\Factory\FactoryInterface;
use Interop\Container\ContainerInterface;
use Laminas\Session\SessionManager;
use Laminas\Authentication\Storage\Session as SessionStorage;

/**
 * Class AuthenticationServiceFactory
 *
 * @package Auth\Service\Factory
 */
class AuthenticationServiceFactory implements FactoryInterface
{
    /**
     * @param ContainerInterface $container
     * @param string             $requestedName
     * @param array|null         $options
     *
     * @return AuthenticationService|object
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null) {
        $sessionManager = $container->get(SessionManager::class);
        $authStorage = new SessionStorage('Laminas_Auth', 'session', $sessionManager);
        $authAdapter = $container->get(AuthAdapter::class);

        return new AuthenticationService($authStorage, $authAdapter);
    }
}
