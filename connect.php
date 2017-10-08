<?php

require __DIR__ . '/vendor/autoload.php';

use Fluent\Config;
use Fluent\ConnectionManager;
use Fluent\MysqlConnector;
use Fluent\QueryBuilder;

$config = [

    'database' => [

        'driver'   => 'mysql',
        'database' => 'dadu_binary',
        'username' => 'root',
        'password' => 'root',
        'host'     => '127.0.0.1',
        'port'     => '3306',
    ],
];

$connection = Fluent\ConnectionManager::connect(new MysqlConnector(), Config::make($config));

$users = QueryBuilder::on($connection)
    ->table('users')
    ->select(['email', 'id'])
    ->where('id', 1)
    ->get();

print_r($users);
