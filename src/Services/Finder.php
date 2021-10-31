<?php

namespace DragonCode\LaravelIdeFacadesHelper\Services;

use Illuminate\Support\Facades\Facade;
use Illuminate\Support\Str;

class Finder extends BaseService
{
    /** @var \DragonCode\LaravelIdeFacadesHelper\Services\ComposerClassMap */
    protected $composer;

    /** @var array */
    protected $in = [];

    public function __construct(ComposerClassMap $composer)
    {
        $this->composer = $composer;
    }

    /**
     * @param  array|string  $directories
     *
     * @return $this
     */
    public function in($directories = '*'): self
    {
        $this->in = $this->prepareDirectories($directories);

        return $this;
    }

    public function get()
    {
        return array_keys(array_unique($this->filter()));
    }

    protected function filter(): array
    {
        return array_filter($this->composer->classes(), function ($path, $class) {
            return $this->allowPath($path) && $this->allowExtends($class);
        }, ARRAY_FILTER_USE_BOTH);
    }

    protected function allowPath(string $path): bool
    {
        return Str::startsWith($path, $this->in);
    }

    protected function allowExtends(string $class): bool
    {
        return is_subclass_of($class, Facade::class);
    }

    /**
     * @param  array|string  $directories
     *
     * @return array
     */
    protected function prepareDirectories($directories = '*'): array
    {
        if ($directories === '*' || $directories === ['*']) {
            return [$this->basePath()];
        }

        return array_map(function ($directory) {
            return $this->basePath($directory);
        }, $directories);
    }
}
