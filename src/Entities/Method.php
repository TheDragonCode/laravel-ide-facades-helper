<?php

namespace DragonCode\LaravelIdeFacadesHelper\Entities;

use DragonCode\LaravelIdeFacadesHelper\Services\DocBlock;
use DragonCode\Support\Concerns\Makeable;
use Illuminate\Support\Str;
use ReflectionMethod;
use ReflectionNamedType;
use ReflectionParameter;

class Method
{
    use Makeable;

    protected $method;

    /** @var \DragonCode\LaravelIdeFacadesHelper\Services\DocBlock */
    protected $doc;

    public function __construct(ReflectionMethod $method)
    {
        $this->method = $method;

        $this->doc = $this->getDocBlock($method);
    }

    public function getType(): ?string
    {
        if ($return_type = $this->method->getReturnType()) {
            $type = $return_type instanceof ReflectionNamedType
                    ? $return_type->getName()
                    : (string) $return_type;
        } else {
            $type = $this->doc->getReturnType();
        }

        return $this->castClassname($type);
    }

    public function getName(): string
    {
        return $this->method->getName();
    }

    public function getDescription(): ?string
    {
        return $this->doc->getSummary();
    }

    /**
     * @return \DragonCode\LaravelIdeFacadesHelper\Entities\Parameter[]
     */
    public function parameters()
    {
        return array_map(function (ReflectionParameter $parameter) {
            return Parameter::make($parameter, $this->doc);
        }, $this->getParameters());
    }

    public function join(bool $with_types = false): ?string
    {
        $params = [];

        foreach ($this->parameters() as $parameter) {
            $variadic = $parameter->isVariadic() ? '...' : '';

            if (! $with_types) {
                $params[] = $variadic . '$' . $parameter->getName();

                continue;
            }

            $str = $parameter->getType() . $variadic . '$' . $parameter->getName();

            if ($parameter->isOptional() && $parameter->isDefaultValueAvailable()) {
                $str .= ' = ' . $parameter->getValue();
            }

            $params[] = $str;
        }

        return implode(', ', $params);
    }

    protected function castClassname(?string $value = null): ?string
    {
        if ($value === 'self' || $value === 'static') {
            return Str::start($this->method->class, '\\');
        }

        return class_exists($value) || interface_exists($value)
                ? Str::start($value, '\\')
                : $value;
    }

    protected function getParameters()
    {
        return $this->method->getParameters();
    }

    protected function getDocBlock(ReflectionMethod $method): DocBlock
    {
        return DocBlock::make(
            $method->getDocComment() ?: null
        );
    }
}
