<?php

namespace TopSoft4U\PhpDocParser\Nodes;

class DeprecatedPHPDocNode implements BasePHPDocNode
{
    public ?string $description;

    public function __construct(?string $description = null)
    {
        $this->description = $description;
    }

    public static function parse(string $content): self
    {
        return new self($content);
    }

    public function __toString()
    {
        return implode(" ", array_filter([$this->description]));
    }
}
