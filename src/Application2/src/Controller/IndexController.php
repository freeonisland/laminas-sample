<?php

/**
 * @see       https://github.com/laminas/laminas-mvc-skeleton for the canonical source repository
 * @copyright https://github.com/laminas/laminas-mvc-skeleton/blob/master/COPYRIGHT.md
 * @license   https://github.com/laminas/laminas-mvc-skeleton/blob/master/LICENSE.md New BSD License
 */

declare(strict_types=1);

namespace Application\Controller;

use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\View\Model\{ViewModel,JsonModel};

use Laminas\Http\Client;
use Laminas\Http\Request;

class IndexController extends AbstractActionController
{
    
    // $this->getEvent()->getRouteMatch()->getParam('swing') => 'plaf
    public function indexAction($params=null)
    {
        return new ViewModel();
    }

    // Use laminas\json module
    public function returnjsonAction()
    {
        //Ajax sample process 
        if ($this->getRequest()->isXmlHttpRequest() || $this->getRequest()->getQuery()->get('showJson') == 1) { 
            $jsonData = array(); 
            $idx = 0; 
        }

        /**
         * Use JsonStrategy
         */
        $view = new JsonModel();
        $view->setTemplate('empty.phtml');
        return $view;
    }

    public function clienthttpAction()
    {
        $request = new Request();
        $request->setUri('http://sample.org');

        $client = new Client();
        $response = $client->send($request);


        $view = new ViewModel();
        $view->setTemplate('empty.phtml');
        return $view;
    }
}
