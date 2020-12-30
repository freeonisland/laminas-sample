<?php

/**
 * @see       https://github.com/laminas/laminas-mvc-skeleton for the canonical source repository
 * @copyright https://github.com/laminas/laminas-mvc-skeleton/blob/master/COPYRIGHT.md
 * @license   https://github.com/laminas/laminas-mvc-skeleton/blob/master/LICENSE.md New BSD License
 */

declare(strict_types=1);

namespace Application;

use Laminas\ModuleManager\Feature\{ConfigProviderInterface, ControllerProviderInterface, BootstrapListenerInterface};
use Laminas\EventManager\EventInterface;
use Laminas\ServiceManager\Factory\InvokableFactory;
use Laminas\ServiceManager\AbstractFactory\ReflectionBasedAbstractFactory;

use Laminas\Router\Http\Literal;
use Laminas\Router\Http\Segment;

class Module implements ConfigProviderInterface, ControllerProviderInterface, BootstrapListenerInterface
{
    public function getConfig(): array
    {
        $config = array_merge(
            $this->dependencies(),
            $this->getControllerConfig(),
            $this->getRouterConfig(),
            $this->getViewManagerConfig()
        );
        return $config;
    }

    /**
     * Passing class dependencies
     */
    public function dependencies()
    {
        return [
            'dependencies' => [
                'auto' => [
                    "types" => [
                        \Application\Table\ModelTable::class => [
                            "parameters" => [
                                'adapter' => 'BlobAdapter', 
                                'resultSetPrototype' => \Laminas\Db\ResultSet\ResultSet::class,

                                /**
                                 * Error dependencyresolver: can't take default value
                                 * Fix: inject directly NULL
                                 * @link https://docs.laminas.dev/laminas-di/config/#type-preferences
                                 */
                                'sql' => new \Laminas\Di\Resolver\ValueInjection(null),
                                'eventManager' => 'EventManager'
                            ]
                        ],
                        \Application\Table\AccessLogTable::class => [
                            "parameters" => [
                                'adapter' => 'BlobAdapter', 
                                'resultSetPrototype' => \Laminas\Db\ResultSet\ResultSet::class,
                                'sql' => new \Laminas\Di\Resolver\ValueInjection(null)
                            ]
                        ]
                    ]
                ],
            ],
        ];
    }

    /**
     * Bootstraping
     */
    public function onBootstrap(EventInterface $e)
    {
        $app     = $e->getApplication();
        $config  = $app->getConfig();
        $service = $app->getServiceManager();
        $view    = $app->getServiceManager()->get('ViewHelperManager'); // Laminas\View\HelperPluginManager
        $eventManager = $app->getEventManager();

        /**
         * MENU
         */
        $bootstrap = new Listener\MenuViewListener;
        $eventManager->attach('render', $bootstrap);


        // Register a "render" event, at high priority (so it executes prior
        // to the view attempting to render)
        $app = $e->getApplication();
        
        $app->getEventManager()->attach('render', [$this, 'registerJsonStrategy'], 222); //attache JsonStrategy on Application:RENDER

        /**
         * Custom one
         */
    //    $this->myCustomJsonStrategy($e);
    }

    /**
     * @param  MvcEvent $e The MvcEvent instance
     * @return void
     */
    public function registerJsonStrategy(\Laminas\Mvc\MvcEvent $e)
    {
        $ctrl = $e->getApplication()->getMvcEvent()->getRouteMatch()->getParam('controller');
        if(!$ctrl) return;

        if (!strpos($ctrl, 'Rest')) {
            return;
        }

        $app          = $e->getTarget();
        $locator      = $app->getServiceManager();
        $view         = $locator->get('Laminas\View\View');
        $jsonStrategy = $locator->get('ViewJsonStrategy');

        // Attach strategy, which is a listener aggregate, at high priority
        $jsonStrategy->attach($view->getEventManager(), 111); //Attache Json aggregate(select & injectResponse)) to View:Render & Response
    }

    // public function myCustomJsonStrategy(\Laminas\Mvc\MvcEvent $e)
    // {
    //    /* $ctrl = $e->getApplication()->getMvcEvent()->getRouteMatch()->getParam('controller');
        
    //     if (!strpos($ctrl, 'Rest')) {
    //         return;
    //     }*/

    //     $viewEvents = $e->getApplication()->getServiceManager()->get('Laminas\View\View')->getEventManager();

    //     // Attach directly to ViewEvent, without Mvc "render"
    //     $viewEvents->attach(\Laminas\View\ViewEvent::EVENT_RESPONSE, function (EventInterface $e) {
    //         $e->getResponse()->getHeaders()->addHeaderLine("Content-Type", 'application/json');
    //     }, 777);
    // }


    public function getControllerConfig(): array 
    {
        return [
            'controllers' => [
                'aliases' => [
                    //a part
                    'access' => Controller\AccessLogController::class,

                    // core tutorial
                    'auth' => Controller\AuthController::class,
                    'index' => Controller\IndexController::class,
                    'form' => Controller\FormController::class,
                    'model' => Controller\ModelController::class,
                    'server' => Controller\ServerController::class, 
                    'service' => Controller\ServiceController::class,
                    'session' => Controller\SessionController::class,
                    'rest' => Controller\RestController::class,
                ],
                "factories" => [
                    Controller\ModelController::class => function($container) {
                        return new Controller\ModelController($container->get(Table\ModelTable::class), $container);
                    }
                ]
            ]
        ];
    }

    public function getRouterConfig(): array 
    {
        return [
            'router' => [
                'routes' => [
                    'home' => [
                        'type'    => Literal::class,
                        'options' => [
                            'route'    => '/',
                            'defaults' => [
                                'controller' => Controller\IndexController::class, 
                                'action'     => 'index'
                            ],
                        ],
                    ],
                    'rest' => [
                        'type'    => Segment::class,
                        'options' => [
                            'route'    => '/rest',
                            'defaults' => [
                                'controller' => Controller\RestController::class,
                            ],
                        ],
                    ],
                    'controller_aliases' => [
                        'type'    => Segment::class,
                        'options' => [
                            'route'    => '/:controller[/:action[/:params]]',
                            'constraints' => [
                                'controller' => "(?!rest)[a-z]+"
                            ],
                            'defaults' => [
                                'action'     => 'index'
                            ],
                        ],
                    ],
                ],
            ],
        ];
    }

    public function getViewManagerConfig(): array
    {
        return [
            // The following are used to configure view helper manager
            // Should be compatible with Laminas\ServiceManager\Config.
            'view_helpers' => [
                'aliases' => [
                    'link' => View\Helper\LinkHelper::class
                ],
                'factories' => [
                    View\Helper\LinkHelper::class => InvokableFactory::class
                ]
            ],

            
            
            'view_manager' => [
                'display_not_found_reason' => true,
                'display_exceptions'       => true,
                'doctype'                  => 'HTML5',
                'not_found_template'       => 'error/404',
                'exception_template'       => 'error/index',
                'template_map' => [
                    'error/404'               => __DIR__ . '/../view/error/404.phtml',
                    'error/index'             => __DIR__ . '/../view/error/index.phtml',
                ],
                'template_path_stack' => [
                    __DIR__ . '/../view',
                ],
                'default_template_suffix' => 'phtml',
                'layout' => 'layout/layout',

                // for all the module
                'strategies' => [
                    'ViewJsonStrategy', //works only with JsonModel()
                ],
            ],
        ];
    }
}
