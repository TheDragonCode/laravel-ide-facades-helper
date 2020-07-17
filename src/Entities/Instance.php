<?php

namespace Helldar\LaravelIdeFacadesHelper\Entities;

use Helldar\LaravelIdeFacadesHelper\Traits\Containable;
use Helldar\LaravelIdeFacadesHelper\Traits\Makeable;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Str;
use ReflectionClass;
use ReflectionMethod;

final class Instance
{
    use Makeable;
    use Containable;

    /** @var \Illuminate\Support\Facades\Facade */
    protected $facade;

    protected $instance;

    public function __construct($facade)
    {
        $this->facade   = $facade;
        $this->instance = $this->resolve($facade);
    }

    /**
     * @throws \ReflectionException
     *
     * @return \Helldar\LaravelIdeFacadesHelper\Entities\Method[]
     */
    public function methods(): array
    {
        return array_values(array_map(static function (ReflectionMethod $method) {
            return Method::make($method);
        }, $this->getFilteredMethods()));
    }

    public function getNamespace(): string
    {
        return (string) Str::of($this->facade)
            ->beforeLast('\\');
    }

    public function getFacadeBasename(): string
    {
        return class_basename($this->facade);
    }

    public function getInstanceClassname(): string
    {
        return get_class($this->instance);
    }

    /**
     * @throws \ReflectionException
     *
     * @return array
     */
    protected function getFilteredMethods(): array
    {
        return $this->reflect()->getMethods(
            $this->methodsVisibility()
        );
    }

    /**
     * @throws \ReflectionException
     *
     * @return \ReflectionClass
     */
    protected function reflect(): ReflectionClass
    {
        return new ReflectionClass($this->instance);
    }

    protected function resolve($class)
    {
        $obj = $class::getFacadeRoot();

        return new $obj();
    }

    protected function methodsVisibility(): int
    {
        return Config::get('ide-helper.facades_visibility', ReflectionMethod::IS_PUBLIC);
    }
}
