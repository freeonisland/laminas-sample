<?php

/**
 * @see       https://github.com/laminas/laminas-mvc-skeleton for the canonical source repository
 * @copyright https://github.com/laminas/laminas-mvc-skeleton/blob/master/COPYRIGHT.md
 * @license   https://github.com/laminas/laminas-mvc-skeleton/blob/master/LICENSE.md New BSD License
 */

declare(strict_types=1);

namespace Application;

use Laminas\Router\Http\Literal;
use Laminas\Router\Http\Segment;
use Laminas\ServiceManager\Factory\InvokableFactory;

return [
    'router' => [
        'routes' => [
            'home' => [
                'type'    => Literal::class,
                'options' => [
                    'route'    => '/',
                    'defaults' => [
                        'controller' => \Application\Controller\IndexController::class,
                        'action'     => 'index',
                    ],
                ],
            ],
            'ldap' => [
                'type'    => Literal::class,
                'options' => [
                    'route'    => '/ldap',
                    'defaults' => [
                        'controller' => \Ldap\Controller\IndexController::class,
                        'action'     => 'index',
                    ],
                ],
            ]
        ],
    ],
    'controllers' => [
        'factories' => [
            \Application\Controller\IndexController::class => InvokableFactory::class,
            \Ldap\Controller\IndexController::class => InvokableFactory::class,
        ],
    ],
    'view_manager' => [
        'display_not_found_reason' => true,
        'display_exceptions'       => true,
        'doctype'                  => 'HTML5',
        'not_found_template'       => 'error/404',
        'exception_template'       => 'error/index',
        'template_map' => [
            'application/index/index' => __DIR__ . '/../view/index/index.phtml',
            'ldap/index/index'        => __DIR__ . '/../../Ldap/view/index/index.phtml',

            'layout/layout'           => __DIR__ . '/../view/layout/layout.phtml',
            'error/404'               => __DIR__ . '/../view/error/404.phtml',
            'error/index'             => __DIR__ . '/../view/error/index.phtml'
        ],
        'template_path_stack' => [
            __DIR__ . '/../view',
        ],
    ],
];
