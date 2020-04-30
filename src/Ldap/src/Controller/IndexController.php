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
    public function indexAction()
    {
        $d = $this->getEvent()->getRouteMatch();
        $p = $d->getParams();

        return new ViewModel();
    }
}
