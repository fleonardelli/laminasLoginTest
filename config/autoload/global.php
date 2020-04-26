<?php

use Doctrine\DBAL\Driver\PDOMySql\Driver as PDOMySqlDriver;

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
                ]
            ],
        ],
    ],
];
