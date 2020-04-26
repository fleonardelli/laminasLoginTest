<?php

declare(strict_types=1);

namespace Auth;

use Auth\Controller\Factory\AuthControllerFactory;
use Auth\Service\Factory\UserFactory;
use Auth\Service\User;
use Laminas\Router\Http\Literal;
use Doctrine\ORM\Mapping\Driver\AnnotationDriver;

return [
    'router' => [
        'routes' => [
            'home' => [
                'type'    => Literal::class,
                'options' => [
                    'route'    => '/',
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
          User::class => UserFactory::class,
      ],
    ],
    'view_manager' => [
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
    ]
];
