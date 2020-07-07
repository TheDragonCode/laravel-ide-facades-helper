<?php

namespace Helldar\LaravelIdeFacadesHelper\Services;

use Helldar\LaravelIdeFacadesHelper\Traits\Containable;

abstract class BaseService
{
    use Containable;

    protected function basePath(string $path = '')
    {
        return $this->app()->basePath($path);
    }
}
