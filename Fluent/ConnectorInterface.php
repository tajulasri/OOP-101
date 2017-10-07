<?php

namespace Fluent;

interface ConnectorInterface
{
    public function connect(array $config);
    public function getConnectorDriver();
}
