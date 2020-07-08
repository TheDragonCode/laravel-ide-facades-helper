<?php

namespace Helldar\LaravelIdeFacadesHelper\Traits;

use Illuminate\Container\Container;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory as ViewFactory;

trait Containable
{
    /**
     * Get the available container instance.
     *
     * @param  string|null  $abstract
     * @param  array  $parameters
     *
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     *
     * @return \Illuminate\Contracts\Foundation\Application|mixed
     */
    protected function app($abstract = null, array $parameters = []): Application
    {
        return is_null($abstract)
            ? Container::getInstance()
            : $this->containerMake($abstract, $parameters);
    }

    /**
     * @param  string  $view
     * @param $items
     *
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     *
     * @return string
     */
    protected function view(string $view, $items): string
    {
        $version = $this->version();

        return $this
            ->containerMake(ViewFactory::class)
            ->make($view, compact('version', 'items'))
            ->render();
    }

    /**
     * @param  null  $abstract
     * @param  array  $parameters
     *
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     *
     * @return mixed|object
     */
    protected function containerMake($abstract = null, array $parameters = [])
    {
        return Container::getInstance()->make($abstract, $parameters);
    }

    protected function version(): string
    {
        return $this->app()->version();
    }
}
