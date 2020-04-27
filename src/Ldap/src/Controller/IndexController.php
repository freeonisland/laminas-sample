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
}
