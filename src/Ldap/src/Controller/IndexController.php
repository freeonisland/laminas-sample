<?php

/**
 * @see       https://github.com/laminas/laminas-mvc-skeleton for the canonical source repository
 * @copyright https://github.com/laminas/laminas-mvc-skeleton/blob/master/COPYRIGHT.md
 * @license   https://github.com/laminas/laminas-mvc-skeleton/blob/master/LICENSE.md New BSD License
 */

declare(strict_types=1);

namespace Ldap\Controller;

use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\View\Model\ViewModel;

use Ldap\Manager\LaminasManager;

class IndexController extends AbstractActionController
{
    /* $this
     * 0 => string (11) "indexAction"
    1 => string (14) "notFoundAction"
    2 => string (10) "onDispatch"
    3 => string (8) "dispatch"
    4 => string (10) "getRequest"
    5 => string (11) "getResponse"
    6 => string (15) "setEventManager"
    7 => string (15) "getEventManager"
    8 => string (8) "setEvent"
    9 => string (8) "getEvent"
    10 => string (16) "getPluginManager"
    11 => string (16) "setPluginManager"
    12 => string (6) "plugin"
    13 => string (6) "__call"
    14 => string (22) "attachDefaultListeners"
    15 => string (19) "getMethodFromAction"
     */
    public function indexAction()
    {
        return new ViewModel();
    }

    /*
     * event
     * 0 => string 'setApplication' (length=14)
  1 => string 'getApplication' (length=14)
  2 => string 'getRouter' (length=9)
  3 => string 'setRouter' (length=9)
  4 => string 'getRouteMatch' (length=13)
  5 => string 'setRouteMatch' (length=13)
  6 => string 'getRequest' (length=10)
  7 => string 'setRequest' (length=10)
  8 => string 'getResponse' (length=11)
  9 => string 'setResponse' (length=11)
  10 => string 'setViewModel' (length=12)
  11 => string 'getViewModel' (length=12)
  12 => string 'getResult' (length=9)
  13 => string 'setResult' (length=9)
  14 => string 'isError' (length=7)
  15 => string 'setError' (length=8)
  16 => string 'getError' (length=8)
  17 => string 'getController' (length=13)
  18 => string 'setController' (length=13)
  19 => string 'getControllerClass' (length=18)
  20 => string 'setControllerClass' (length=18)
  21 => string '__construct' (length=11)
  22 => string 'getName' (length=7)
  23 => string 'getTarget' (length=9)
  24 => string 'setParams' (length=9)
  25 => string 'getParams' (length=9)
  26 => string 'getParam' (length=8)
  27 => string 'setName' (length=7)
  28 => string 'setTarget' (length=9)
  29 => string 'setParam' (length=8)
  30 => string 'stopPropagation' (length=15)
  31 => string 'propagationIsStopped' (length=20)
     */
    public function startAction()
    {
        $d = $this->getEvent()->getRouteMatch();
        //$m = $d->getMatchedRouteName();
        $p = $d->getParams();
        s($p);
        
        return new ViewModel();
    }
}
