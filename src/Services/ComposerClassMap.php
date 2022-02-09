<?php

namespace DragonCode\LaravelIdeFacadesHelper\Services;

use DragonCode\LaravelIdeFacadesHelper\Traits\Containable;
use Illuminate\Support\Str;
use Symfony\Component\Finder\Finder as SymfonyFinder;
use Symfony\Component\Finder\SplFileInfo;

class ComposerClassMap extends BaseService
{
    use Containable;

    /** @var \Composer\Autoload\ClassLoader */
    protected $composer;

    public function __construct()
    {
        $this->composer = require $this->autoloadPath();
    }

    public function classes(): array
    {
        return array_merge($this->listClasses(), $this->listClassesInPsrMaps());
    }

    protected function listClasses(): array
    {
        return array_map(static function ($path) {
            return realpath($path);
        }, $this->composer->getClassMap());
    }

    protected function listClassesInPsrMaps(): array
    {
        $prefixes = array_merge(
                $this->composer->getPrefixes(),
                $this->composer->getPrefixesPsr4()
        );

        $classes = [];

        foreach ($prefixes as $namespace => $directories) {
            $files = $this->finder()
                ->in($directories)
                ->files()
                ->name('*.php');

            foreach ($files as $file) {
                if ($file instanceof SplFileInfo) {
                    $fqcn = $this->getFullyQualifiedClassNameFromFile($file);

                    $classes[$fqcn] = $file->getRealPath();
                }
            }
        }

        return $classes;
    }

    protected function getFullyQualifiedClassNameFromFile(SplFileInfo $file): string
    {
        return (string) Str::of($file->getRealPath())
            ->after($this->basePath())
            ->replaceFirst('app' . DIRECTORY_SEPARATOR, $this->app()->getNamespace())
            ->replaceLast('.php', '')
            ->trim(' \\')
            ->title();
    }

    protected function finder(): SymfonyFinder
    {
        return new SymfonyFinder();
    }

    protected function autoloadPath()
    {
        return $this->app()->basePath('/vendor/autoload.php');
    }
}
