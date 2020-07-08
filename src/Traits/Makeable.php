<?php

namespace Helldar\LaravelIdeFacadesHelper\Traits;

trait Makeable
{
    public static function make(...$parameters)
    {
        return new static(...$parameters);
    }
}
