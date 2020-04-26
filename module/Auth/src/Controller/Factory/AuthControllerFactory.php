<?php


namespace Auth\Controller\Factory;

use Auth\Service\User;
use Interop\Container\ContainerInterface;
use Laminas\ServiceManager\Factory\FactoryInterface;
use Auth\Controller\AuthController;

/**
 * Class AuthControllerFactory
 *
 * @package Auth\Controller\Factory
 */
class AuthControllerFactory implements FactoryInterface
{

    /**
     * @param ContainerInterface $container
     * @param string             $requestedName
     * @param array|null         $options
     *
     * @return User|object
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $userService = $container->get(User::class);

        return new AuthController($userService);
    }

}
