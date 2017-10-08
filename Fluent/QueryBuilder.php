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
    protected $columns = '*';

    /**
     * where parameters
     * @var [type]
     */
    protected $where = [];

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

        $this->columns = is_array($columns) ? join(',', $columns) : implode(',', func_get_args());

        return $this;
    }

    public function where($column, $value, $operator = '=')
    {
        $value = is_int($value) ? sprintf("%d", $value) : sprintf("'%s'", $value);
        array_push($this->where, [$column, $operator, $value]);
        return $this;
    }

    /**
     * get result for prepared query
     * @return [type] [description]
     */
    public function get()
    {

        $options = $this->parseWhere();
        $statement = $this->getPrepareSelect($options);
        $query = $this->prepareQuery($statement);
        $query->execute();

        return $query->fetchAll();

    }

    protected function buildWhere()
    {

        $andClause = [];

        array_push($andClause, implode(' ', $this->where[0]));

        foreach (array_slice($this->where, 1) as $column) {

            $paramBuilder = ' and ' . implode(' ', $column);
            array_push($andClause, $paramBuilder);
        }

        return $andClause;
    }

    protected function parseWhere()
    {
        $whereBindings = $this->buildWhere();
        $whereClause = 'where ';

        foreach ($whereBindings as $where) {

            $whereClause .= $where;
        }

        return $whereClause;
    }

    protected function prepareQuery($query)
    {
        return $this->connection->getConnection()->prepare($query);
    }

    protected function getPrepareSelect($options = '')
    {
        return sprintf('select %s from %s %s', $this->columns, $this->table, $options);
    }

}
