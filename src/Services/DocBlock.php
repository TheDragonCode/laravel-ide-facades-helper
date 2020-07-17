<?php

namespace Helldar\LaravelIdeFacadesHelper\Services;

use Helldar\LaravelIdeFacadesHelper\Traits\Makeable;
use phpDocumentor\Reflection\DocBlockFactory;

final class DocBlock
{
    use Makeable;

    /** @var \phpDocumentor\Reflection\DocBlock */
    protected $doc;

    public function __construct(string $docblock = null)
    {
        $this->doc = $this->factory()->create(
            $docblock ?: '/** */'
        );
    }

    public function getSummary(): ?string
    {
        return $this->doc->getSummary();
    }

    public function getReturnType(): ?string
    {
        return $this->doc->hasTag('return')
            ? $this->doc->getTagsByName('return')[0]->getName()
            : null;
    }

    protected function factory(): DocBlockFactory
    {
        return DocBlockFactory::createInstance();
    }
}
