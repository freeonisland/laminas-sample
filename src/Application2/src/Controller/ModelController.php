<?php

declare(strict_types=1);

namespace Application\Controller;

use Laminas\View\Model\ViewModel;
use Laminas\Mvc\Controller\AbstractActionController;
use Application\Table\ModelTable;


class ModelController extends AbstractActionController
{
    protected $table, $services;

    public function __construct(ModelTable $table, \Laminas\ServiceManager\ServiceManager $services)
    {
        $this->table = $table;
        $this->services = $services;
    }

    
    public function indexAction()
    {
        $res = $this->table->fetchResults();
        $view = new ViewModel(['data'=>$res]);

        return $view;
    }
}