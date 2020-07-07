<?php

namespace Helldar\LaravelIdeFacadesHelper\Entities;

use ReflectionClass;
use ReflectionProperty;

final class Instance
{
    public $classname;

    protected $reflection;

    /**
     * Instance constructor.
     *
     * @param  string  $classname
     *
     * @throws \ReflectionException
     */
    public function __construct(string $classname)
    {
        $this->classname = $classname;

        $this->reflection = new ReflectionClass($classname);
    }

    /**
     * @return array|\ReflectionProperty[]
     */
    public function properties(): array
    {
        return $this->reflection->getProperties(
            ReflectionProperty::IS_PUBLIC
        );
    }

    /**
     * @return array|\ReflectionMethod[]
     */
    public function methods(): array
    {
        return array_values(array_filter($this->reflection->getMethods(), function ($method) {
            return ! in_array($method->getName(), [
                'resolved',
                'spy',
                'partialMock',
                'shouldReceive',
                'swap',
                'getFacadeRoot',
                'clearResolvedInstance',
                'clearResolvedInstances',
                'getFacadeApplication',
                'setFacadeApplication',
                '__callStatic',
            ]);
        }));
    }
}
