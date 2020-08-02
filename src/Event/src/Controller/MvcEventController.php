<?php

/**
 * @see       https://github.com/laminas/laminas-mvc-skeleton for the canonical source repository
 * @copyright https://github.com/laminas/laminas-mvc-skeleton/blob/master/COPYRIGHT.md
 * @license   https://github.com/laminas/laminas-mvc-skeleton/blob/master/LICENSE.md New BSD License
 */

declare(strict_types=1);

namespace Event\Controller;

use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\View\Model\ViewModel;
use Stat\Model\UserModel;

use Laminas\EventManager\EventManager;
use Laminas\EventManager\EventManagerInterface;
use Laminas\EventManager\EventManagerAwareInterface;
use Laminas\EventManager\SharedEventManager;


class MvcEventController extends AbstractActionController
{
   
    public function indexAction()
    {
        $mvcEvent = $this->getEvent();
        $em = $this->getEventManager();
        $pm = $this->getPluginManager(); 
        $app = $mvcEvent->getApplication();

        $s = $app->getServiceManager();

        $em->attach('try.service.launched', new \Event\Listener\SampleListener);

        //d($s->get('tchouklot')->tryService($em));

    //    dm($em);

   //     d($s->get('Config'));
      //  dm($s->getAlls());
      //  dm($this->getRequest());
        //dm($mvcEvent->getRequest());
        //dm($mvcEvent->getRouter());

    }
}







