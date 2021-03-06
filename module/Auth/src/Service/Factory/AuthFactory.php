<?php


namespace Auth\Service\Factory;


use Interop\Container\ContainerInterface;
use Laminas\Authentication\AuthenticationService;
use Laminas\Config\Config;
use Laminas\ServiceManager\Factory\FactoryInterface;
use Auth\Service\Auth;

/**
 * Class AuthFactory
 *
 * @package Auth\Service\Factory
 */
class AuthFactory implements FactoryInterface
{
    /**
     * @param ContainerInterface $container
     * @param string             $requestedName
     * @param array|null         $options
     *
     * @return Auth|object
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $authService = $container->get(AuthenticationService::class);
        $config = $container->get('configuration');

        return new Auth($authService, $config['access_filter']);
    }
}
