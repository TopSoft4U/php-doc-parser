<?php

namespace TopSoft4U\PhpDocParser\Nodes;

class DeprecatedPHPDocNode implements BasePHPDocNode
{
    public function __construct(public ?string $description = null)
    {
    }

    #[\Override]
    public static function parse(string $content): self
    {
        return new self($content);
    }

    #[\Override]
    public function __toString(): string
    {
        return implode(" ", array_filter([$this->description]));
    }
}
