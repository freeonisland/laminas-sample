<?php

/**
 * Global Configuration Override
 *
 * You can use this file for overriding configuration values from modules, etc.
 * You would place values in here that are agnostic to the environment and not
 * sensitive to security.
 *
 * NOTE: In practice, this file will typically be INCLUDED in your source
 * control, so do not include passwords or other sensitive information in this
 * file.
 */

use Laminas\Mvc\Controller\LazyControllerAbstractFactory;


return [
    // ...
    'controllers' => [
        'abstract_factories' => [
            LazyControllerAbstractFactory::class,
        ]
    ],

    //DI
    'dependencies' => [
        'auto' => [
            "types" => [
                \Application\Model\AccessLogTable::class => [ // extended from TableGateway
                    "parameters" => [
                        'table' => 'AccessLog',
                        'adapter' => 'BlobAdapter', 
                        'features' => null,
                        'resultSetPrototype' => \Laminas\Db\ResultSet\ResultSet::class
                    ]
                ]
            ]
        ],
    ],

    'service_manager' => [
        'factories' => [
            'BlobAdapter' => AdapterAbstractServiceFactory::class,
        ]
    ],

    'db' => [
        'adapters' => [
            'BlobAdapter' => [
                'driver' => 'Pdo_Sqlite',
                "dsn" => "sqlite::memory:",
            ],
        ]
        //'driver' => 'Pdo_Sqlite'
    ]
];
