<?php

namespace Fluent;

class Config
{
    protected $config;

    public function __construct($config = [])
    {
        $this->config = $config;
    }

    public static function make($config)
    {
        return new static($config);
    }

    public function load()
    {
        return $this->config;
    }

    public function __toString()
    {
        return json_encode($this->config);
    }
}
