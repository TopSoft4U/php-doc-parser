<?php

namespace TopSoft4U\PhpDocParser\Nodes;

class CustomPHPDocNode implements BasePHPDocNode
{
    public ?string $tagName = null;
    public string $value;

    public function __construct(string $value)
    {
        $this->value = $value;
    }

    public static function parse(string $content): CustomPHPDocNode
    {
        return new self($content);
    }

    public function __toString()
    {
        return $this->value;
    }
}
