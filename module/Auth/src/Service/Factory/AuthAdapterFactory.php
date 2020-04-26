<?php


namespace Auth\Service\Factory;


use Auth\Service\AuthAdapter;
use Interop\Container\ContainerInterface;
use Laminas\Crypt\Password\Bcrypt;
use Laminas\ServiceManager\Factory\FactoryInterface;

/**
 * Class AuthAdapterFactory
 *
 * @package Auth\Service\Factory
 */
class AuthAdapterFactory implements FactoryInterface
{
    /**
     * @param ContainerInterface $container
     * @param                    $requestedName
     * @param array|null         $options
     *
     * @return AuthAdapter
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $entityManager = $container->get('doctrine.entitymanager.orm_default');
        $bCrypt = $container->get(Bcrypt::class);

        return new AuthAdapter($entityManager, $bCrypt);
    }
}
