<?php

namespace DragonCode\LaravelIdeFacadesHelper\Services;

use Helldar\Support\Concerns\Makeable;
use phpDocumentor\Reflection\DocBlockFactory;

class DocBlock
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
