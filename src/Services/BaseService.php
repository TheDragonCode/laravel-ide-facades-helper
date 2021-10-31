<?php

namespace DragonCode\LaravelIdeFacadesHelper\Services;

use DragonCode\LaravelIdeFacadesHelper\Traits\Containable;

abstract class BaseService
{
    use Containable;

    protected function basePath(string $path = '')
    {
        return $this->app()->basePath($path);
    }
}
