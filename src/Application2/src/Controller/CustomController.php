<?php

/**
 * @see       https://github.com/laminas/laminas-mvc-skeleton for the canonical source repository
 * @copyright https://github.com/laminas/laminas-mvc-skeleton/blob/master/COPYRIGHT.md
 * @license   https://github.com/laminas/laminas-mvc-skeleton/blob/master/LICENSE.md New BSD License
 */

declare(strict_types=1);

namespace Application\Controller;

use Laminas\Mvc\Controller\AbstractRestfulController;
use Laminas\View\Model\ViewModel;
use Laminas\Stdlib;

class CustomController implements Stdlib\DispatchableInterface
{
    public function dispatch(Stdlib\RequestInterface $request, Stdlib\ResponseInterface $response = null)
    {
        return $response->setContent('5');
    }
}
