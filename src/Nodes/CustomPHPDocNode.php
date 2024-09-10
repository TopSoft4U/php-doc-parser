<?php

namespace TopSoft4U\PhpDocParser\Nodes;

class CustomPHPDocNode implements BasePHPDocNode
{
    public ?string $tagName = null;

    public function __construct(public string $value)
    {
    }

    #[\Override]
    public static function parse(string $content): CustomPHPDocNode
    {
        return new self($content);
    }

    #[\Override]
    public function __toString(): string
    {
        return $this->value;
    }
}
