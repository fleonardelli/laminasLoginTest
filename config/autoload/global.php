<?php

use Doctrine\DBAL\Driver\PDOMySql\Driver as PDOMySqlDriver;
use Laminas\Session\Storage\SessionArrayStorage;
use Laminas\Session\Validator\RemoteAddr;
use Laminas\Session\Validator\HttpUserAgent;

return [
    'doctrine' => [
        'connection' => [
            'orm_default' => [
                'driverClass' => PDOMySqlDriver::class,
                'params' => [
                    'host'     => 'mysql',
                    'user'     => 'root',
                    'password' => 'root',
                    'dbname'   => 'test',
                ],
            ],
        ],
    ],
    'session_config' => [
        'cookie_lifetime' => 60*60*1,
        'gc_maxlifetime' => 60*60*24*30,
    ],
    'session_manager' => [
        'validators' => [
            RemoteAddr::class,
            HttpUserAgent::class,
        ],
    ],
    'session_storage' => [
        'type' => SessionArrayStorage::class
    ],
];
