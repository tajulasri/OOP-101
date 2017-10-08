<?php

namespace Fluent;

use PDO;

class Connector
{
    protected $options = [
        PDO::ATTR_CASE               => PDO::CASE_NATURAL,
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_ORACLE_NULLS       => PDO::NULL_NATURAL,
        PDO::ATTR_STRINGIFY_FETCHES  => false,
        PDO::ATTR_EMULATE_PREPARES   => false,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    ];

    public function getOptions(array $config)
    {
        $options = $config['options'] ?? [];
        return array_diff_key($this->options, $options) + $options;
    }

    public function createConnection($dsn, array $config, array $options)
    {
        $username = $config['username'];
        $password = $config['password'];
        return new PDO($dsn, $username, $password, $options);
    }

    public function getDefaultOptions()
    {
        return $this->options;
    }

    public function setDefaultOptions(array $options)
    {
        $this->options = $options;
    }
}
