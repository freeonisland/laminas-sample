<?php

namespace Application\Table;

use Laminas\Db\TableGateway\Feature\{MetadataFeature, EventFeature, RowGatewayFeature};
use Laminas\Db\ResultSet\{ResultSet, HydratingResultSet};
use Laminas\EventManager\EventManager;

class ModelTable extends AbstractTable
{
    public function __construct( 
        \Laminas\Db\Adapter\AdapterInterface $adapter,
        $features = null,
        \Laminas\Db\ResultSet\ResultSetInterface $resultSetPrototype = null,
        Sql $sql = null,
        $eventManager = null
    )
    {
        $features = $this->getNewFeature($eventManager);
        $resultSetPrototype = $this->getNewResultSetPrototype();

        parent::__construct($adapter, $features, $resultSetPrototype, $sql);
    }
    
    /**
     * @link https://docs.laminas.dev/laminas-db/table-gateway/#tablegateway-features
     */
    public function getNewFeature($eventManager=null)
    {
        // choose one features
        // for example
        // $metaFeature = new MetadataFeature;
        // $rowGateway = new RowGatewayFeature('id_model');

        // Set table to the event loop
        // One can attach it a listener
        $eventManager->attach('preInsert', function ($event){
            $sqlInsert = $event->getParams()['insert'];
            $sqlInsert->price .= '€'; //reduce size of id
        });

        $eventFeature = new EventFeature($eventManager);
        return $eventFeature;
    }

    public function getNewResultSetPrototype() //: ResultSetInterface
    {
        // choose one resultSet
        $resultSet = new ResultSet;
        // Change return prototype
        // return $resultSet;
        
        $hydrating = new HydratingResultSet(new \Laminas\Hydrator\ArraySerializableHydrator);
        $naming = new \Laminas\Hydrator\NamingStrategy\UnderscoreNamingStrategy; //change "id_model" to "idModel"
        $explode = new \Laminas\Hydrator\Strategy\ExplodeStrategy(',');
        $closure = new \Laminas\Hydrator\Strategy\ClosureStrategy(null,
            function ($value, $object) {
                //extract
                return str_replace('o','<b>o</b>',$value);
            }
        );

        $hydrating->getHydrator()->setNamingStrategy($naming);
        $hydrating->getHydrator()->addStrategy('json', $explode);
        $hydrating->getHydrator()->addStrategy('country', $closure);

        return $hydrating;
    }

    /******************
     * Adding useful methods
     */
    function fetchResults()
    {
        $results = $this->select();
        return $results;
    }

    // or
    function fetchAll()
    {
        $results = $this->select();
        return $results;
    }

    public function get($id) { 
        $id  = (int) $id; 
        $rowset = $this->tableGateway->select(array('id' => $id)); 
        $row = $rowset->current(); 
        if (!$row) { 
           throw new \Exception("Could not find row $id"); 
        } 
        return $row; 
     }  

    public function save(Book $book) {  //sample book
        $data = array ( 
           'author' => $book->author, 
           'title'  => $book->title, 
        );  
        $id = (int) $book->id; 
        if ($id == 0) { 
           $this->tableGateway->insert($data); 
        } else {
           if ($this->getBook($id)) { 
              $this->tableGateway->update($data, array('id' => $id));  
           } else { 
              throw new \Exception('Book id does not exist'); 
           } 
        } 
     } 

}