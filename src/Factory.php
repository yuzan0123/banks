<?php

namespace Xyu\Banks;

use Xyu\Banks\Exception\CcbException;

class Factory
{
    protected $config;

    protected $drivers;

    public function __construct($config)
    {
        $this->config = $config;
    }

    public function make(string $name = null, array $config = null)
    {
        $name = $name ?? 'ccb';

        if (empty($this->config[$name])) {
            throw new CcbException("Undefined {$name} configuration");
        }

        $config = $config ?? $this->config[$name];

        if (!isset($config['debug'])) {
            $config['debug'] = $this->config['debug'] ?? false;
        }

        return $this->drivers[$name] ?? $this->drivers[$name] = new BankApp($config);
    }

    public function __call($name, $arguments)
    {
        $app = $this->make();

        if (method_exists($app, $name)) {
            return call_user_func_array([$app, $name], $arguments);
        }

        throw new CcbException("Undefined {$name} method!");
    }
}