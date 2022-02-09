<?php

namespace DragonCode\LaravelIdeFacadesHelper\Entities;

use DragonCode\LaravelIdeFacadesHelper\Services\DocBlock;
use DragonCode\Support\Concerns\Makeable;
use DragonCode\Support\Facades\Helpers\Boolean;
use DragonCode\Support\Facades\Helpers\Instance as InstanceHelper;
use Illuminate\Support\Str;
use ReflectionParameter;

class Parameter
{
    use Makeable;

    /** @var ReflectionParameter */
    protected $parameter;

    /** @var \DragonCode\LaravelIdeFacadesHelper\Services\DocBlock */
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
        if ($type = $this->parameter->getType()) {
            $name = $type->getName();

            return InstanceHelper::exists($name)
                    ? Str::start($name, '\\') . ' '
                    : $name . ' ';
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

    public function isVariadic(): bool
    {
        return $this->parameter->isVariadic();
    }

    public function getDefaultValue()
    {
        return $this->parameter->getDefaultValue();
    }

    protected function castParameterValue($value): string
    {
        if (is_bool($value)) {
            return Boolean::convertToString($value);
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
