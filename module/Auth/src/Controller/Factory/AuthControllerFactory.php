<?php


namespace Auth\Controller\Factory;

use Application\Service\MessageBag;
use Auth\Service\Auth;
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
     * @return Auth|object
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $userService = $container->get(Auth::class);
        $messageBag = $container->get(MessageBag::class);

        return new AuthController($userService, $messageBag);
    }

}
