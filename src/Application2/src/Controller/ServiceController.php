<?php

/**
 * @see       https://github.com/laminas/laminas-mvc-skeleton for the canonical source repository
 * @copyright https://github.com/laminas/laminas-mvc-skeleton/blob/master/COPYRIGHT.md
 * @license   https://github.com/laminas/laminas-mvc-skeleton/blob/master/LICENSE.md New BSD License
 */

declare(strict_types=1);

namespace Application\Controller;

use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\View\Model\ViewModel;
use Laminas\ServiceManager\ServiceManager;
use Laminas\ServiceManager\Factory\InvokableFactory;
use Laminas\ServiceManager\AbstractFactory\ReflectionBasedAbstractFactory;
use Laminas\ServiceManager\Proxy\LazyServiceFactory;

class ServiceController extends AbstractActionController
{
    /*
  string(11) "__construct"
  string(17) "getServiceLocator"
  string(3) "get"
  string(5) "build"
  string(3) "has"
  string(16) "setAllowOverride"
  string(16) "getAllowOverride"
  string(9) "configure"
  string(8) "setAlias"
  string(17) "setInvokableClass"
  string(10) "setFactory"
  string(14) "mapLazyService"
  string(18) "addAbstractFactory"
  string(12) "addDelegator"
  string(14) "addInitializer"
  string(10) "setService"
  string(9) "setShared"
     */
   function indexAction()
   { 
       $serviceManager = new ServiceManager([
          'factories' => [
              \stdClass::class => InvokableFactory::class,
              //\Application\Service\DepositService::class => InvokableFactory::class,
              \Application\Service\DepositService::class => ReflectionBasedAbstractFactory::class,
             /* \Application\Service\DepositService::class => function($container, $requestName, $arrayOptions = null) {
                return new \Application\Service\DepositService;
              }*/
            ],
            'shared' => [
                \stdClass::class => true
            ],
            'shared_by_default' => true,
            'aliases' => [
                'depot' => \Application\Service\DepositService::class
            ]
       ]);

       // require ocramius/proxy-manager
       $lazyServiceManager = new ServiceManager([
            'factories' => [
                \Application\Service\SlowService::class => InvokableFactory::class
            ],
            'lazy_services' => [
                'class_map' => [
                    \Application\Service\SlowService::class => \Application\Service\SlowService::class
                ]
            ],
            'delegators' => [
                \Application\Service\SlowService::class => [
                    LazyServiceFactory::class
                ]
            ]
        ]);
       
       $serviceDepot = $serviceManager->get('depot');
       //$serviceDepot->setDepot(5);

       $slow = $lazyServiceManager->get(\Application\Service\SlowService::class);
       //$slow->init();
   }
}
