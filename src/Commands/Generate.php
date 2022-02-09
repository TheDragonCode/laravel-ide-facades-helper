<?php

namespace DragonCode\LaravelIdeFacadesHelper\Commands;

use DragonCode\LaravelIdeFacadesHelper\Services\Finder;
use DragonCode\LaravelIdeFacadesHelper\Services\Processor;
use DragonCode\LaravelIdeFacadesHelper\Traits\Containable;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Config;

class Generate extends Command
{
    use Containable;

    protected $signature = 'ide-helper:facades';

    protected $description = 'Generate autocompletion for facades';

    /** @var \DragonCode\LaravelIdeFacadesHelper\Services\Processor */
    protected $processor;

    /** @var \DragonCode\LaravelIdeFacadesHelper\Services\Finder */
    protected $finder;

    /**
     * @param \DragonCode\LaravelIdeFacadesHelper\Services\Finder $finder
     * @param \DragonCode\LaravelIdeFacadesHelper\Services\Processor $processor
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
