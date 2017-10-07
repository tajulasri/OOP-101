<?php

namespace Fluent;

use Fluent\Connector;
use Fluent\ConnectorInterface;

class MysqlConnector extends Connector implements ConnectorInterface
{

    public function connect(array $config)
    {
        $dsn = $this->getDsn($config);

        $options = $this->getOptions($config);
        $connection = $this->createConnection($dsn, $config, $options);

        return $connection;
    }

    protected function getDsn(array $config)
    {
        extract($config);

        $dsn = "mysql:host={$host};dbname={$database}";

        if (isset($config['port'])) {

            $dsn .= ";port={$port}";
        }

        return $dsn;
    }

    public function getConnectorDriver()
    {
        return mb_strtolower(static::class);
    }
}
