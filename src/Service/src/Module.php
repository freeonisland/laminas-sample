<?php

/**
 * @see       https://github.com/laminas/laminas-mvc-skeleton for the canonical source repository
 * @copyright https://github.com/laminas/laminas-mvc-skeleton/blob/master/COPYRIGHT.md
 * @license   https://github.com/laminas/laminas-mvc-skeleton/blob/master/LICENSE.md New BSD License
 */

declare(strict_types=1);

namespace Service;

use Laminas\ModuleManager\Feature\{ConfigProviderInterface, ServiceProviderInterface, ControllerPluginProviderInterface};
use Interop\Container\ContainerInterface;

use Laminas\Router\Http\Literal;
use Laminas\Router\Http\Segment;

/**
 *  Configuration in global.php
 * - keep for legacy knowledge before autoload
 */

class Module implements ServiceProviderInterface, ConfigProviderInterface, ControllerPluginProviderInterface
{
    public function getConfig() : array
    {
        return (new ConfigProvider)();
    }

    public function getControllerConfig()
    {
        /*'controllers' => [
        'abstract_factories' => [
            #https://docs.laminas.dev/laminas-mvc/cookbook/automating-controller-factories/
            \Laminas\Mvc\Controller\LazyControllerAbstractFactory::class
        ]
    ],*/
    }

    /**
     * Expected to return \Laminas\ServiceManager\Config object or array to
     * seed such an object.
     *
     * @return array|\Laminas\ServiceManager\Config
     */
    public function getControllerPluginConfig()
    {
        return [
            /**
             * Can be used if plugin called by
             * <<controller>> ->plugin(\Service\Plugin\LogPlugin::class)
             */
            /**
             * Laminas-DI no invoked for custom plugins
             *      need to do it manually
             */
            'abstract_factories' => [
                new \Laminas\ServiceManager\AbstractFactory\ReflectionBasedAbstractFactory
            ],
            'aliases' => [
                'log' => \Service\Plugin\LogPlugin::class
            ],
            /**
             * Can't use Service Plugin with auto-wire
             *      because af PLuginManager->validate()
             */
            'services' => [ 
            ],
            
            /**
             * No-autowire 
             *  - classic way
             */
            'factories' => [
                /*'log' => function(\Laminas\ServiceManager\ServiceManager $serviceManager) {
                    return new \Service\Plugin\LogPlugin($serviceManager->get(\Service\Service\LogService::class));
                }*/
            ]
        ];
    }

    /**
     * Use of Laminas\Di
     * \Laminas\Di\Container\AutowireFactory::class,
     * 
     * No need factories anymore
     * - keep only for sample :how it was before autowire
     * 
     * recupère par <<controller>>->getServiceManager()->get('alpha_plot')
     */
    public function getServiceConfig() 
    {
        /**
         * Keep only for info
         *   use of autowire!
         */

       /* 'service_manager' => [
            'abstract_factories' => [
                /**
                 * NO NEED
                 *
                //\Laminas\ServiceManager\AbstractFactory\ReflectionBasedAbstractFactory::class,
            ],
        ],*/

        return [
            # 'service_manager' => [
            'services'           => [],
            'invokables'         => [],
            'factories'          => [
                'invoke'        => InvokableFactory::class,
                'get_en_data'   => function(ContainerInterface $container, $requestedName) {
                    return '3en_version';
                },
                'en_to_fr'      => function(ContainerInterface $container, $requestedName) {
                    $data = $container->get('get_en_data');
                    return new class($data) {
                        private $data;
                        function __construct($data) {$this->data = $data;}
                        function __toString() {return preg_replace('/en/','fr',$this->data);}
                    };
                }
            ],
            'abstract_factories' => [],
            'delegators'         => [],
            'aliases'            => [],
            'initializers'       => [],
            'lazy_services'      => [],
            'shared'             => [],
            'shared_by_default'  => false,

            /*'factories' => [
                Model\UserModel::class => \Laminas\Di\Container\AutowireFactory::class,
                /*Service\DataService::class => function(ServiceManager $container){
                    return new Service\DataService;
                }
            ]*/

            /*'factories' => [
                 'logging' => function(\Laminas\ServiceManager\ServiceManager $container) {
                    $foo = new Service\LogService;
                    return $foo;
                },
                //ReflectionBasedAbstractFactory::class,
                Listener\LogListener::class => function($serviceManager) {
                    return new Listener\LogListener($serviceManager->get('logging'));
                }
                Service\LogService::class => function($serviceManager) {
                    return new 
                }
                Model\UserModel::class => \Laminas\Di\Container\AutowireFactory::class,
                Service\DataService::class => function(ServiceManager $container){
                    return new Service\DataService;
                }
            ],*/
        ];
    }
}
