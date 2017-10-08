## Basic Database connection using Object Oriented

1. `composer dump-autoload`

### Basic Usages

> Create Connection


```php
<?php

require __DIR__ . '/vendor/autoload.php';

use Fluent\Config;
use Fluent\ConnectionManager;
use Fluent\MysqlConnector;
use Fluent\QueryBuilder;

$config = [

    'database' => [

        'driver'   => 'mysql',
        'database' => 'testing',
        'username' => 'root',
        'password' => 'root',
        'host'     => '127.0.0.1',
        'port'     => '3306',
    ],
];

$connection = Fluent\ConnectionManager::connect(
        new MysqlConnector(), 
        Config::make($config)
    );

```


> Begin Querying


### Select basic

```php
$users = QueryBuilder::on($connection)
->table('users')->get();

```


### Select Specific columns

```php
$users = QueryBuilder::on($connection)
->table('users')
->select('email','is_activated')
->get();

```


### Where clause Basic
```php
$users = QueryBuilder::on($connection)
->table('users')
->select('email','is_activated')
->where('email','sample@yahoo.com')
->get();

```


### Where clause Chaining
```php
$users = QueryBuilder::on($connection)
->table('users')
->select('email','is_activated')
->where('email','sample@yahoo.com')
->where('is_activated',false)
->where('created_at','2017-01-01','>')
->get();

```


### Create new Driver

> Driver Factory


```php
<?php

namespace Fluent;

use Fluent\Connector;
use Fluent\ConnectorInterface;

class PostgresSqlConnector extends Connector implements ConnectorInterface
{
    public function connect(array $config)
    {
        //build up your logic here
    }

    public function getConnectorDriver()
    {
        return mb_strtolower(static::class);
    }
}
```

2. Fire up our new driver
```php

$connection = Fluent\ConnectionManager::connect(
        new PostgresSqlConnector(), 
        Config::make($config)
    );

    
```