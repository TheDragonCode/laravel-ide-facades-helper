<?php

namespace Helldar\LaravelIdeFacadesHelper\Services;

use Helldar\LaravelIdeFacadesHelper\Entities\Instance;
use Helldar\LaravelIdeFacadesHelper\Traits\Containable;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Config;

final class Processor extends BaseService
{
    use Containable;

    /** @var \Helldar\LaravelIdeFacadesHelper\Entities\Instance[] */
    protected $items = [];

    public function items(array $items): self
    {
        foreach ($items as $item) {
            $this->addItem(
                Instance::make($item)
            );
        }

        return $this;
    }

    /**
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function store()
    {
        file_put_contents(
            $this->storePath(),
            $this->view('laravel-ide-facades-helper::facades', $this->items)
        );
    }

    protected function storePath(): string
    {
        return $this->app()->basePath(
            $this->filename() .
            '_facades.' .
            $this->extension()
        );
    }

    protected function filename(): string
    {
        return Config::get('ide-helper.filename');
    }

    protected function extension(): string
    {
        return Config::get('ide-helper.format');
    }

    /**
     * @param  \Illuminate\Support\Facades\Facade|string  $classname
     *
     * @return \stdClass
     */
    protected function resolve(string $classname)
    {
        return $classname::getFacadeRoot();
    }

    protected function addItem(Instance $instance): void
    {
        $namespace = $instance->getNamespace();

        $this->makeItemsNamespace($namespace);

        $this->items[$namespace][] = $instance;
    }

    protected function makeItemsNamespace(string $namespace): void
    {
        if (! Arr::has($this->items, $namespace)) {
            Arr::set($this->items, $namespace, []);
        }
    }
}
