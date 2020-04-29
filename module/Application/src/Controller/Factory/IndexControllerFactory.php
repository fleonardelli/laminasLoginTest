<?php


namespace Application\Controller\Factory;


use Application\Controller\IndexController;
use Application\Service\Content;
use Application\Service\MessageBag;
use Interop\Container\ContainerInterface;
use Laminas\Authentication\AuthenticationService;
use Laminas\ServiceManager\Factory\FactoryInterface;

class IndexControllerFactory implements FactoryInterface
{
    /**
     * @param ContainerInterface $container
     * @param string             $requestedName
     * @param array|null         $options
     *
     * @return IndexController|object
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $contentService = $container->get(Content::class);
        $authService = $container->get(AuthenticationService::class);
        $messageBag = $container->get(MessageBag::class);

        return new IndexController($contentService, $authService, $messageBag);
    }
}
