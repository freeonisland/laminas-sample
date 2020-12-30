<?php

/**
 * @see       https://github.com/laminas/laminas-mvc-skeleton for the canonical source repository
 * @copyright https://github.com/laminas/laminas-mvc-skeleton/blob/master/COPYRIGHT.md
 * @license   https://github.com/laminas/laminas-mvc-skeleton/blob/master/LICENSE.md New BSD License
 */

declare(strict_types=1);

namespace EventSample\Controller;

use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\View\Model\ViewModel;
use Laminas\EventManager\SharedEventManager;

use EventSample\EventsAware\GreeterEventsAware;
use EventSample\EventsManager\MyEventsManager;
use EventSample\EventListener\{DisplayListener, MailerListener, LoggingListener, ThreeListenerAggregate};

class EventController extends AbstractActionController
{
    public function indexAction()
    {
        $greeterEventsAware = new GreeterEventsAware;

        /*
         * attache a name to the listener 
         * 1 - use attach listener option
         */
        $greeterEventsAware->getEventManager()->attach('*', new DisplayListener, 5); //priority
        $greeterEventsAware->getEventManager()->attach('mail', new MailerListener);
        $greeterEventsAware->getEventManager()->attach('log', new LoggingListener, 3);

        /**
         * Or use
         * 2 - Listener aggregate option
         */
        $greeterEventsAware->getEventManager()->clearListeners('*'); //remove all

        $aggregate = new ThreeListenerAggregate();
        $aggregate->attach( $greeterEventsAware->getEventManager() );

        // trigger message !
        $greeterEventsAware->trigger_three('Message running');

         /*
         * Sample
         */
        //$greeterEventsAware->getEventManager()->attach('greet', new DisplayListener);
        $greeterEventsAware->trigger_greet("Greeter!");

        echo ' - - - - - - - - - - - <br/><br/>';

        /**
         * Shared SAMPLE
         */
        $shared = new SharedEventManager; //attach, detach, get and clear listener
        $shared->attach('ID_mylogging', 'event_myname_logon', new DisplayListener);
        $shared->attach('ID_ClassName', 'event_triggered_within_class', new DisplayListener);
        $shared->attach('ID_ClassName', 'event_onlyforclass', new DisplayListener);

        // Only this one will get launched !
        $listener = new DisplayListener;
        $shared->attach('TRY_TO_ID', 'event_triggered_within_class', $listener);

        $events = new MyEventsManager($shared);
        $events->setIdentifiers(['ID_mylogging', 'TRY_TO_ID']); //autorized identifiers

        // try to send greeter
        $greeterEventsAware->setEventManager( $events );
        $greeterEventsAware->trigger_greet("Greeter shared!"); //send specific event within authorized identifiers

        // add shared listener
        $greeterEventsAware->getEventManager()->getSharedManager()->detach($listener, 'TRY_TO_ID', 'event_triggered_within_class');
        $greeterEventsAware->trigger_greet(" - send nothing -"); 

        // clear all
        $greeterEventsAware->getEventManager()->getSharedManager()->clearListeners('TRY_TO_ID');
    }
}
