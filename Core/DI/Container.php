<?php

namespace WPBM\Core\DI;

/**
 * Class Container
 * @package WPBM\Core\DI
 */
class Container
{
    /**
     * @var array
     */
    protected $bindings = [];

    /**
     * @var array
     */
    protected $instances = [];

    /**
     * Bind a class or interface to the container.
     *
     * @param string $abstract
     * @param callable|string|null $concrete
     */
    public function bind($abstract, $concrete = null)
    {
        if (is_null($concrete)) {
            $concrete = $abstract;
        }

        $this->bindings[$abstract] = $concrete;
    }

    /**
     * Bind a singleton to the container.
     *
     * @param string $abstract
     * @param callable|string|null $concrete
     */
    public function singleton($abstract, $concrete = null)
    {
        $this->bind($abstract, $concrete);
        $this->instances[$abstract] = null;
    }

    /**
     * Resolve a class or interface from the container.
     *
     * @param string $abstract
     * @return mixed
     * @throws \Exception
     */
    public function make($abstract)
    {
        if (isset($this->instances[$abstract])) {
            return $this->instances[$abstract];
        }

        if (!isset($this->bindings[$abstract])) {
            return $this->resolve($abstract);
        }

        $concrete = $this->bindings[$abstract];

        if (is_callable($concrete)) {
            $object = $concrete($this);
        } else {
            $object = $this->resolve($concrete);
        }

        if (array_key_exists($abstract, $this->instances)) {
            $this->instances[$abstract] = $object;
        }

        return $object;
    }

    /**
     * Automatically resolve a class with dependencies.
     *
     * @param string $class
     * @return mixed
     * @throws \Exception
     */
    protected function resolve($class)
    {
        if (!class_exists($class)) {
            throw new \Exception("Class {$class} does not exist.");
        }

        $reflection = new \ReflectionClass($class);

        if (!$reflection->isInstantiable()) {
            throw new \Exception("Class {$class} is not instantiable.");
        }

        $constructor = $reflection->getConstructor();

        if (is_null($constructor)) {
            return new $class;
        }

        $parameters = $constructor->getParameters();
        $dependencies = array_map(function ($parameter) {
            $dependency = $parameter->getClass();
            if ($dependency) {
                return $this->make($dependency->name);
            }

            if ($parameter->isDefaultValueAvailable()) {
                return $parameter->getDefaultValue();
            }

            throw new \Exception("Cannot resolve dependency {$parameter->name}.");
        }, $parameters);

        return $reflection->newInstanceArgs($dependencies);
    }
}
