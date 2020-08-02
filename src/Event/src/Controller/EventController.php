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


use Laminas\EventManager\{
    EventManager,
    EventManagerInterface,
    EventManagerAwareInterface,
    SharedEventManager
};


class EventController extends AbstractActionController  
{           
    protected $ll;

    public function __construct(\Event\Listener\LogListener $ll)
    {
        $this->ll = $ll;
    }

    public function indexAction()
    {
        $em = new \Event\EventManager\MyEventManager($this->getEventManager());
        $this->plugin('log')->log('call plugin log');
        
        $logListener =  $this->ll;

        $em->attach('database.action', $logListener, -100);
        $em->trigger('database.action');

        $em->attach('*', $logListener);
        //$em->attach('my_event', $logListener);

        $em->attach(\Event\Event\OrderEvent::NAME, new \Event\Listener\OrderListener);

        $specific_customer_order = new class {function getOrderName() {return 'Foo order name';}};
        $em->triggerEvent(new \Event\Event\OrderEvent($specific_customer_order));
    }

    /**
     * custom events
     */
    public function customAction()
    {
        $events = new EventManager;

        $l1 = new \Event\Listener\SampleListener;
        //$l2 = new \Event\Listener\SampleTwoListener;

        $events->attach('*', $l1);
        $events->attach('my_event', $l2);

        $em = $this->getEventManager()->trigger('event.database.action');

        $mvcEvent = $this->getEvent();
        $em = $this->getEventManager();
        $pm = $this->getPluginManager(); 
        $app = $mvcEvent->getApplication();
        $s = $app->getServiceManager();

    }
}







