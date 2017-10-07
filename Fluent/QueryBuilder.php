<?php

namespace Fluent;

use Fluent\ConnectionManager;

class QueryBuilder
{
    /**
     * Connection
     * @var ConnectionManager
     */
    private $connection;

    /**
     * table
     * @var string
     */
    protected $table;

    /**
     * selected columns
     * @var [type]
     */
    protected $columns;

    /**
     * query
     * @var [type]
     */
    protected $query;

    public function __construct(ConnectionManager $connection)
    {
        $this->connection = $connection;
    }

    /**
     * instantiate new builder with connection
     * @param  [type] $connection [description]
     * @return [type]             [description]
     */
    public static function on($connection)
    {
        return new static($connection);
    }

    /**
     * set table name
     * @param  [type] $table [description]
     * @return [type]        [description]
     */
    public function table($table)
    {
        $this->table = isset($table) ? $table : '';
        return $this;
    }

    /**
     * set columns selected
     * @param  array  $columns [description]
     * @return [type]          [description]
     */
    public function select($columns = ['*'])
    {
        $this->columns = is_array($columns) ? $columns : func_get_args();
        return $this;
    }

    /**
     * get result for prepared query
     * @return [type] [description]
     */
    public function get()
    {
        $query = $this->prepareQuery();
        $query->execute();

        return $query->fetchAll(\PDO::FETCH_ASSOC);

    }

    protected function prepareQuery()
    {
        return $this->connection->getConnection()->prepare($this->getPrepareSelect());
    }

    protected function getPrepareSelect()
    {
        $selectecColumns = is_array($this->columns) ? implode(',', $this->columns) : $this->columns;
        $selectPrepare = sprintf('select %s from %s', $selectecColumns, $this->table);
        return $selectPrepare;
    }

}
