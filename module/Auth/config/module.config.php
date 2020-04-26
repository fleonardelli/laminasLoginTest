<?php

declare(strict_types=1);

namespace Auth;

use Auth\Controller\Factory\AuthControllerFactory;
use Auth\Service\AuthAdapter;
use Auth\Service\Factory\AuthAdapterFactory;
use Auth\Service\Factory\AuthenticationServiceFactory;
use Auth\Service\Factory\AuthFactory;
use Auth\Service\Auth;
use Laminas\Authentication\AuthenticationService;
use Laminas\Router\Http\Literal;
use Doctrine\ORM\Mapping\Driver\AnnotationDriver;

return [
    'router' => [
        'routes' => [
            'login' => [
                'type'    => Literal::class,
                'options' => [
                    'route'    => '/login',
                    'defaults' => [
                        'controller' => Controller\AuthController::class,
                        'action'     => 'login',
                    ],
                ],
            ],
        ],
    ],
    'controllers' => [
        'factories' => [
            Controller\AuthController::class => AuthControllerFactory::class,
        ],
    ],
    'service_manager' => [
      'factories' => [
          Auth::class => AuthFactory::class,
          AuthAdapter::class => AuthAdapterFactory::class,
          AuthenticationService::class => AuthenticationServiceFactory::class,
      ],
    ],
    'view_manager' => [
        'default_template_suffix' => 'phtml',
        'template_path_stack' => [
            __DIR__ . '/../view',
        ],
    ],
    'doctrine' => [
        'driver' => [
            'auth_driver' => [
                'class' => AnnotationDriver::class,
                'cache' => 'array',
                'paths' => [__DIR__ . '/../src/Entity']
            ],
            'orm_default' => [
                'drivers' => [
                    'Auth\Entity' => 'auth_driver',
                ],
            ],
        ],
    ],
    'access_filter' => [
        'options' => [
            'mode' => 'restrictive'
        ],
        'controllers' => [
            Controller\AuthController::class => [
                ['actions' => ['login'], 'allow' => '*'],
            ],
        ],
    ],
];
