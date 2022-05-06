<?php

namespace DragonCode\LaravelIdeFacadesHelper\Services;

use DragonCode\LaravelIdeFacadesHelper\Entities\Instance;
use DragonCode\LaravelIdeFacadesHelper\Traits\Containable;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Config;
use stdClass;

class Processor extends BaseService
{
    use Containable;

    /** @var \DragonCode\LaravelIdeFacadesHelper\Entities\Instance[] */
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

    public function filename(): string
    {
        $filename = Config::get('ide-helper.filename');

        return sprintf('%s_facades.%s', $this->filePrefix($filename), $this->extension($filename));
    }

    protected function filePrefix(string $filename): string
    {
        return pathinfo($filename, PATHINFO_FILENAME) ?: '_ide_helper';
    }

    protected function extension(string $filename): string
    {
        return pathinfo($filename, PATHINFO_EXTENSION) ?: 'php';
    }

    /**
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     *
     * @return string
     */
    protected function storePath(): string
    {
        return $this->app()->basePath(
            $this->filename()
        );
    }

    /**
     * @param \Illuminate\Support\Facades\Facade|string $classname
     *
     * @return stdClass
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
