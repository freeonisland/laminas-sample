<?php

/**
 * @see       https://github.com/laminas/laminas-mvc-skeleton for the canonical source repository
 * @copyright https://github.com/laminas/laminas-mvc-skeleton/blob/master/COPYRIGHT.md
 * @license   https://github.com/laminas/laminas-mvc-skeleton/blob/master/LICENSE.md New BSD License
 */

declare(strict_types=1);

namespace Application;

use Laminas\Router\Http\Literal;
use Laminas\Router\Http\Regex;
use Laminas\Router\Http\Segment;
use Laminas\Stdlib\ArrayUtils;
use Laminas\ServiceManager\Factory\InvokableFactory;

/**
 * https://docs.laminas.dev/laminas-router/routing/
 */
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
            /*
             * https://docs.laminas.dev/laminas-router/routing/#laminas-router-http-regex
             * /ldap/001-some-blog_slug-here.html
             * 
             * (?<PARAM>regex)?
             * 'regex' => '/ldap/(?<id>[a-zA-Z0-9_-]+)(\.(?<format>(json|html|xml|rss)))?'
             * 'spec' => '/ldap/%id%.%format%',
             */
            'ldap' => [
                'type'    => Regex::class,
                'options' => [
                    'regex' => '/ldap', 
                    'defaults' => [
                        'controller' => 'Ldap\Controller\IndexController',
                        'action'     => 'index'
                    ],
                    'spec' => '/ldap'
                ],
                'may_terminate' => true,
                'child_routes' => [
                    'user' => [
                        'type' => Regex::class,
                        'options' => [
                            'regex' => '/user/?(?<action>[a-z]+)?/?(?<params>[\/a-z]+)?',
                            'defaults' => [
                                'controller' => 'Ldap\Controller\UserController',
                                'action' => 'list',
                            ],
                            'spec' => '/ldap/user'
                        ],
                    ],
                ]
            ]
        ],
    ],
    'controllers' => [
        'factories' => [
            \Application\Controller\IndexController::class => InvokableFactory::class,
            \Ldap\Controller\IndexController::class => InvokableFactory::class,
            \Ldap\Controller\UserController::class => InvokableFactory::class,
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
            'layout/layout'           => __DIR__ . '/../view/layout/layout.phtml',
            'error/404'               => __DIR__ . '/../view/error/404.phtml',
            'error/index'             => __DIR__ . '/../view/error/index.phtml',

            /*
             * LDAP
             */
            'ldap/index/index'        => __DIR__ . '/../../Ldap/view/index/index.phtml',
            'ldap/user/list'          => __DIR__ . '/../../Ldap/view/user/list.phtml',
            'ldap/user/create'        => __DIR__ . '/../../Ldap/view/user/create.phtml',
            'ldap/user/update'        => __DIR__ . '/../../Ldap/view/user/update.phtml',
            'ldap/user/view'          => __DIR__ . '/../../Ldap/view/user/view.phtml',
            'ldap/user/delete'        => __DIR__ . '/../../Ldap/view/user/delete.phtml'
        ],
        'template_path_stack' => [
            __DIR__ . '/../view',
        ],
    ]
];

/*
return [
    
    'controllers' => [
        'abstract_factories' => [
            LazyControllerAbstractFactory::class,
        ],
        'factories' => [
            'MyModule\Controller\FooController' => LazyControllerAbstractFactory::class,
        ],
    ],
    
];*/
