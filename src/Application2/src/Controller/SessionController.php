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

use Laminas\Http\Client;
use Laminas\Http\Cookies;
use Laminas\Http\Header\Cookie;
use Laminas\Http\Header\SetCookie;
use Laminas\Http\Request;

class SessionController extends AbstractActionController
{
    protected $container;
    protected $session_container;
    protected $session_manager;

    public function __construct(
       // \Laminas\Session\Container $session_container,
        \Laminas\Session\SessionManager $session_manager,
        \Laminas\ServiceManager\ServiceManager $container
    )
    {
      //  $this->session_container = $session_container;
        $this->session_manager = $session_manager;
        $this->container = $container;
    }

    /**
     * Try cookies
     */
    public function cookieAction()
    {
        $cookies = new Cookies;
        $response = $this->getResponse();

        $sc = SetCookie::fromString(
            'Set-Cookie: flavorOne9=chocolate%20chips'
        );
        $this->getResponse()->getHeaders()->addHeader($sc);
        
        setcookie("test2", "value2", time()+999, "/");

        $view = new ViewModel();
        $view->setTemplate('empty.phtml');
        return $view;
    }

    /**
     * Try sessions
     * @link https://www.php.net/manual/fr/session.configuration.php
     */
    public function sessionAction()
    {
        /*$config = new \Laminas\Session\Config\SessionConfig;
        $config->setOptions([
            'name' => 'laminas',
        //    'cookie_domain' => 'docker:82',
            'serialize_handler' => 'php',
            'save_handler' => 'files'
        ]);
        $manager = new \Laminas\Session\SessionManager($config);
        \Laminas\Session\Container::setDefaultManager($manager);*/

        $manager = ($this->container->get(\Laminas\Session\SessionManager::class));
        $manager->setStorage(new \Laminas\Session\Storage\SessionArrayStorage);
        $container = new \Laminas\Session\Container;

        //d($_SESSION, $_COOKIE);
        if( !$container->try_using_it ) {
            $container->try_using_it = 9;
        }
        echo $container->try_using_it++;

        $view = new ViewModel();
        $view->setTemplate('empty.phtml');
        return $view;
    }
}
