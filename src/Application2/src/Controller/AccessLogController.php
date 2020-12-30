<?php

declare(strict_types=1);

namespace Application\Controller;

use Laminas\View\Model\ViewModel;
use Laminas\Mvc\Controller\AbstractActionController;
use Application\Model\AccessLogTable;

use Laminas\Db\TableGateway\Feature\{MetadataFeature, EventFeature, RowGatewayFeature};
use Laminas\Db\ResultSet\{ResultSet, HydratingResultSet};

class AccesslogController extends AbstractActionController
{
    protected $table, $services;

    public function __construct(AccessLogTable $table, \Laminas\ServiceManager\ServiceManager $services)
    {
        $this->table = $table;
        $this->services = $services;
      //  $this->setNewAdapter();
    }

    // public function setNewAdapter()
    // {
    //     $em = $this->getEventManager();

    //     $metaFeature = new MetadataFeature;
    //     $eventFeature = new EventFeature($em);
    //     $rowGateway = new RowGatewayFeature('id');

    //     $resultSet = new ResultSet;
    //     $hydrating = new HydratingResultSet;

    //     $this->table = new AccessLogTable(
    //         $this->services->get('BlobAdapter'),
    //         $metaFeature,
    //         $resultSet
    //     );
    // }

    public function logAction()
    {
        $res = $this->table->fetch();
        
        $view = new ViewModel($res);
        $view->setTemplate("application/access/empty");

        return $view;
    }
}