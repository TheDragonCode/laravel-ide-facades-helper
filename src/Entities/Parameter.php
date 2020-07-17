<?php

namespace Helldar\LaravelIdeFacadesHelper\Entities;

use Helldar\LaravelIdeFacadesHelper\Services\DocBlock;
use Helldar\LaravelIdeFacadesHelper\Traits\Makeable;
use Illuminate\Support\Str;
use ReflectionParameter;

final class Parameter
{
    use Makeable;

    /** @var \ReflectionParameter */
    protected $parameter;

    /** @var \Helldar\LaravelIdeFacadesHelper\Services\DocBlock */
    protected $doc;

    public function __construct(ReflectionParameter $parameter, DocBlock $doc)
    {
        $this->parameter = $parameter;

        $this->doc = $doc;
    }

    public function getName(): string
    {
        return $this->parameter->getName();
    }

    public function getType(bool $mixed = false): string
    {
        if ($class = $this->parameter->getClass()) {
            return Str::start($class->getName(), '\\') . ' ';
        }

        if ($type = $this->parameter->getType()) {
            return $type->getName() . ' ';
        }

        return $mixed ? 'mixed ' : '';
    }

    public function getValue(): string
    {
        return $this->castParameterValue(
            $this->getDefaultValue()
        );
    }

    public function isOptional(): bool
    {
        return $this->parameter->isOptional();
    }

    public function isDefaultValueAvailable(): bool
    {
        return $this->parameter->isDefaultValueAvailable();
    }

    public function getDefaultValue()
    {
        return $this->parameter->getDefaultValue();
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
}
