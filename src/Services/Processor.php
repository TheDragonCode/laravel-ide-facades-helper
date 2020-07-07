<?php

namespace Helldar\LaravelIdeFacadesHelper\Services;

use Helldar\LaravelIdeFacadesHelper\Entities\Instance;
use Helldar\LaravelIdeFacadesHelper\Traits\Containable;
use Illuminate\Support\Facades\Config;

final class Processor extends BaseService
{
    use Containable;

    /** @var \Helldar\LaravelIdeFacadesHelper\Entities\Instance[] */
    protected $items = [];

    public function items(array $items): self
    {
        $this->items = array_map(static function ($class) {
            return new Instance($class);
        }, $items);

        return $this;
    }

    /**
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function run()
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
     * @param  string|\Illuminate\Support\Facades\Facade  $classname
     *
     * @return \stdClass
     */
    protected function resolve(string $classname)
    {
        return $classname::getFacadeRoot();
    }
}
