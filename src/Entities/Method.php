<?php

namespace Helldar\LaravelIdeFacadesHelper\Entities;

use Barryvdh\Reflection\DocBlock;
use Helldar\LaravelIdeFacadesHelper\Traits\Makeable;
use Illuminate\Support\Str;
use ReflectionMethod;
use ReflectionNamedType;
use ReflectionParameter;

final class Method
{
    use Makeable;

    protected $method;

    public function __construct(ReflectionMethod $method)
    {
        $this->method = $method;
    }

    public function getType(): ?string
    {
        $type = null;

        if ($return_type = $this->method->getReturnType()) {
            $type = $return_type instanceof ReflectionNamedType
                ? $return_type->getName()
                : (string) $return_type;
        } else {
            $type = $this->getReturnTypeFromDocBlock();
        }

        return $this->castClassname($type);
    }

    public function getName(): string
    {
        return $this->method->getName();
    }

    public function getParameters()
    {
        $params = [];

        foreach ($this->method->getParameters() as $parameter) {
            $str = $this->castParameterType($parameter) . '$' . $parameter->getName();

            if ($parameter->isOptional() && $parameter->isDefaultValueAvailable()) {
                $default = $this->castParameterValue($parameter->getDefaultValue());

                $str .= " = $default";
            }

            $params[] = $str;
        }

        return $params;
    }

    protected function castParameterType(ReflectionParameter $parameter): string
    {
        if ($class = $parameter->getClass()) {
            return Str::start($class->getName(), '\\') . ' ';
        }

        if ($type = $parameter->getType()) {
            return $type->getName() . ' ';
        }

        return '';
    }

    protected function castParameterValue($value): string
    {
        if (is_bool($value)) {
            return $value ? 'true' : 'false';
        }

        if (is_array($value)) {
            return '[]';
        }

        if (is_null($value)) {
            return 'null';
        }

        if (is_numeric($value)) {
            return $value;
        }

        return "'" . trim($value) . "'";
    }

    protected function castClassname(string $value = null): ?string
    {
        if ($value === 'self' || $value === 'static') {
            return Str::start($this->method->class, '\\');
        }

        return class_exists($value) || interface_exists($value)
            ? Str::start($value, '\\')
            : $value;
    }

    protected function getReturnTypeFromDocBlock(): ?string
    {
        $doc = new DocBlock($this->method);

        return $doc->hasTag('return')
            ? $doc->getTagsByName('return')[0]->getType()
            : null;
    }
}
