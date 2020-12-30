<?php

namespace Application\Table;

use Laminas\Db\TableGateway\TableGateway;
use Laminas\Db\Sql\Sql;

/*
    TABLE GATEWAY

 public function isInitialized() : bool;
public function initialize() : void;
public function getTable() : string;
public function getAdapter() : AdapterInterface;
public function getColumns() : array;
public function getFeatureSet() Feature\FeatureSet;
public function getResultSetPrototype() : ResultSetInterface;
public function getSql() | Sql\Sql;
public function select(Sql\Where|callable|string|array $where = null) : ResultSetInterface;
public function selectWith(Sql\Select $select) : ResultSetInterface;
public function insert(array $set) : int;
public function insertWith(Sql\Insert $insert) | int;
public function update(
    array $set,
    Sql\Where|callable|string|array $where = null,
    array $joins = null
) : int;
public function updateWith(Sql\Update $update) : int;
public function delete(Sql\Where|callable|string|array $where) : int;
public function deleteWith(Sql\Delete $delete) : int;
public function getLastInsertValue() : int;
 */

 /*
 DRIVER

  public function getDatabasePlatformName(string $nameFormat = self::NAME_FORMAT_CAMELCASE) : string;
    public function checkEnvironment() : bool;
    public function getConnection() : ConnectionInterface;
    public function createStatement(string|resource $sqlOrResource = null) : StatementInterface;
    public function createResult(resource $resource) : ResultInterface;
    public function getPrepareType() :string;
    public function formatParameterName(string $name, $type = null) : string;
    public function getLastGeneratedValue() : mixed;

ADAPTER
https://docs.laminas.dev/laminas-db/adapter/



STATEMENT

    public function getResource() : resource;
    public function prepare($sql = null) : void;
    public function isPrepared() : bool;
    public function execute(null|array|ParameterContainer $parameters = null) : ResultInterface;


    public function setSql(string $sql) : void;
    public function getSql() : string;
    public function setParameterContainer(ParameterContainer $parameterContainer) : void;
    public function getParameterContainer() : ParameterContainer;

RESULT

public function buffer() : void;
    public function isQueryResult() : bool;
    public function getAffectedRows() : int;
    public function getGeneratedValue() : mixed;
    public function getResource() : resource;
    public function getFieldCount() : int;

RESULTSET
https://docs.laminas.dev/laminas-db/result-set/

public function initialize(array|Iterator|IteratorAggregate|ResultInterface $dataSource) : self;
    public function getDataSource() : Iterator|IteratorAggregate|ResultInterface;
    public function getFieldCount() : int;
    public function next() : mixed;
    public function key() : string|int;
    public function current() : mixed;
    public function valid() : bool;
    public function rewind() : void;
    public function count() : int;
    public function toArray() : array;

 */
abstract class AbstractTable extends TableGateway
{
    protected $tableName;

    public function __construct( 
        \Laminas\Db\Adapter\AdapterInterface $adapter,
        $features = null,
        \Laminas\Db\ResultSet\ResultSetInterface $resultSetPrototype = null,
        Sql $sql = null
    )
    {
        $table = static::class;
        $this->tableName = str_replace('Table','',(substr($table,strrpos($table, '\\')+1)));
       
        parent::__construct($this->tableName, $adapter, $features, $resultSetPrototype, $sql);

        // Laminas DDL
        $this->ddl_create($adapter);

        // fixtures
        $fixtureClass = (strstr(__NAMESPACE__,"\\Table", true).'\\Model\\Fixture\\'.$this->tableName.'Fixture');
        if (class_exists($fixtureClass)) {
            new $fixtureClass($this);
        }
    }

    /**
     * Can use ATTACH DATABASE file_name AS database_name;
     */
    // function createTable()
    // {
    //     // Create table
    //     $sqlFile = __DIR__ . '/../Model/schema/'.lcfirst($this->tableName).'.sql';

    //     if (file_exists($sqlFile)) {
    //         $sql = file_get_contents($sqlFile);
    //     } else {
    //         throw new \RuntimeException("Schema \"".lcfirst($this->tableName).".sql\" can't be found");
    //     }
    //     $this->adapter->query($sql)->execute();
    // }

    /**
     * Used to create new table
     */
    function ddl_create($adapter)
    {
        // get entity reflection
        $entityName = strstr(__NAMESPACE__,"\\Table",true) . "\\Model\\".$this->tableName;
        $entity = new \ReflectionClass($entityName);

        // get properties doccoment
        $props = $entity->getProperties();
        $props_docs = [];
        foreach ($props as $pro) {
  
            $props_docs[$pro->getName()] = $this->getParamsFromDoc($pro->getDocComment());

            if (!$pro->getDocComment()) {
                throw new \DomainException("Paramètres '".$pro->getName()."' du model \"{$this->tableName}\" non définis");
            }
        }

        // DDL table
        $ddl = new \Laminas\Db\Sql\Ddl\CreateTable;
        $ddl->setTable($this->tableName);

        // read the properties
        foreach ($props_docs as $name => $doc) {
            $options = explode(' ', $doc);

            // create column 
            $column = ucfirst(strtolower(array_shift($options)));
            $class = "\\Laminas\\Db\\Sql\\Ddl\\Column\\{$column}";
            $ddlColumn = new $class($name);

            // options
            foreach($options as $option) {
                //$ddlColumn->setOption($option);
            }
            $ddl->addColumn($ddlColumn);
        }

        //execute
        $sql = new Sql($adapter);
       
        $adapter->query(
            $sql->getSqlStringForSqlObject($ddl),
            $adapter::QUERY_MODE_EXECUTE
        );
    }

    function fetch(...$var)
    {
        return $this->select(...$var);
    }

    protected function getParamsFromDoc(string $docComment): ?string
    {
        if (!preg_match("/@var\s(.*)\n/", $docComment, $params)) {
            return null;
        }
        return trim($params[1]);
    }
}