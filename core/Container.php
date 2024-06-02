<?php

class Container
{
    private $bindings = [];

    public function bind($abstract, $concrete)
    {
        $this->bindings[$abstract] = $concrete;
    }

    public function resolve($abstract)
    {
        if (isset($this->bindings[$abstract])) {
            return call_user_func($this->bindings[$abstract], $this);
        }
        throw new Exception("No binding found for {$abstract}");
    }
}
