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

class ServerController extends AbstractActionController
{
    public function getServersAjaxAction()
    {
        try {
            $client = (new \GuzzleHttp\Client())->request('GET', "http://tmaid-docker_sw_1:9501");
            $resp = json_decode($client->getBody()->getContents(), true);
            $new = [];
            array_walk($resp, function($v, $k) use (&$new){
                $kr = explode(':', $k)[0];
                $new[$kr] = $v;
            });

            $view = new ViewModel(
                $new
            );
            $view->setTerminal(true); // NO layout

            return $view;
        } catch (\Guzzle\RequestException $e) {
            echo $e->getMessage();
            return null;
        }
    }
}
