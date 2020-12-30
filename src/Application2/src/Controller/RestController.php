<?php

/**
 * @see       https://github.com/laminas/laminas-mvc-skeleton for the canonical source repository
 * @copyright https://github.com/laminas/laminas-mvc-skeleton/blob/master/COPYRIGHT.md
 * @license   https://github.com/laminas/laminas-mvc-skeleton/blob/master/LICENSE.md New BSD License
 */

declare(strict_types=1);

namespace Application\Controller;

use Laminas\Mvc\Controller\AbstractRestfulController;
use Laminas\View\Model\{ViewModel,JsonModel};

class RestController extends AbstractRestfulController
{
    public function getList()
    {
        $this->response->setStatusCode(200);
        
        $model = new JsonModel([
            
        ]);
        $model->setVariables([
            'data' => 'bla b la cars'
        ]);

        $this->getResponse()->getHeaders()->addHeaderLine('Content-Type', 'application/json, charset=UTF-8');
        $model->setTemplate("application/rest/a.phtml");
        return $model;
    }

    /**
     * Must use a workaround!!!!!
     * http://docker:82/rest?id=8 doesn't work (take "?id" as a key)
     * http://docker:82/rest?api&id=8 did!
     */
    public function get($id)
    {
        $this->response->setStatusCode(200);
        
        $model = new JsonModel;
        $model->setVariable('data', 8);
        
        /*
         * Json strategy set in Module.php !
         */

        $model->setTemplate("application/rest/a.phtml");
        return $model;
    }
}
