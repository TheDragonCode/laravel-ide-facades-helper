<?php

namespace Helldar\LaravelIdeFacadesHelper\Commands;

use Helldar\LaravelIdeFacadesHelper\Services\Finder;
use Helldar\LaravelIdeFacadesHelper\Services\Processor;
use Helldar\LaravelIdeFacadesHelper\Traits\Containable;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Config;

final class Generate extends Command
{
    use Containable;

    protected $signature = 'ide-helper:facades';

    protected $description = 'Generate autocompletion for facades';

    /** @var \Helldar\LaravelIdeFacadesHelper\Services\Processor */
    protected $processor;

    /** @var \Helldar\LaravelIdeFacadesHelper\Services\Finder */
    protected $finder;

    /**
     * @param  \Helldar\LaravelIdeFacadesHelper\Services\Finder  $finder
     * @param  \Helldar\LaravelIdeFacadesHelper\Services\Processor  $processor
     *
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function handle(Finder $finder, Processor $processor)
    {
        $this->processor = $processor;
        $this->finder    = $finder;

        $this->prepare();
        $this->generate();
        $this->showMessage();
    }

    protected function prepare()
    {
        $this->finder->in($this->directories());
    }

    /**
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    protected function generate(): void
    {
        $this->processor
                ->items($this->finder->get())
                ->store();
    }

    protected function directories(): array
    {
        return Config::get('ide-helper.facade_locations', ['app']);
    }

    protected function showMessage(): void
    {
        $this->info('Facades information was written to ' . $this->filename());
    }

    protected function filename(): string
    {
        return $this->processor->filename();
    }
}
