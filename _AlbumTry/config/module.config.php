<?php

declare(strict_types=1);

namespace AlbumTry;

use Laminas\Router\Http\Segment;
use Laminas\ServiceManager\Factory\InvokableFactory;

return [
    'router' => [
        'routes' => [
            'albumtry' => [
                'type' => Segment::class,
                'options' => [
                    'route' => '/albumtry/edit/:id',
                    'constraints' => [
                        'action' => 'edit',
                        'id' => '\d+'
                    ],
                    'defaults' => [
                        'controller' => Controller\EditController::class,
                        'action' => 'edit'
                    ]
                ]
            ]
        ]
    ],
    /*'controllers' => [
        'factories' => [
            Controller\EditController::class => InvokableFactory::class,
        ],
    ],*/
    'view_manager' => [
        'template_path_stack' => [
            'albumtry' => __DIR__ . '/../view',
        ],
    ]
];