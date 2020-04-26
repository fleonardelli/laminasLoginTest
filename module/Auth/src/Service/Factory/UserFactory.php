<?php


namespace Auth\Service\Factory;


use Interop\Container\ContainerInterface;
use Laminas\Crypt\Password\Bcrypt;
use Laminas\ServiceManager\Factory\FactoryInterface;
use Auth\Service\User;

/**
 * Class UserFactory
 *
 * @package Auth\Service\Factory
 */
class UserFactory implements FactoryInterface
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
        $entityManager = $container->get('doctrine.entitymanager.orm_default');
        $bCrypt = $container->get(Bcrypt::class);

        return new User($entityManager, $bCrypt);
    }
}
