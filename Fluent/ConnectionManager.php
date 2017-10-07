<?php

namespace Fluent;

use Fluent\Config;
use Fluent\ConnectorInterface;

class ConnectionManager
{
    protected $connection;

    protected $config;

    public function __construct(ConnectorInterface $connection, Config $config)
    {
        $this->connection = $connection;
        $this->config = $config->load();
    }

    public static function connect($connection, $config)
    {
        return new static($connection, $config);
    }

    public function getConnection()
    {
        return $this->connection->connect($this->config['database']);
    }
}
