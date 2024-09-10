<?php

namespace TopSoft4U\PhpDocParser\Nodes;

class GenericPHPDocNode implements BasePHPDocNode
{
    public function __construct(public string $value)
    {
    }

    #[\Override]
    public static function parse(string $content): GenericPHPDocNode
    {
//        $parts = explode(" ", $content, 3);

//        $value        = $parts[1];
//        $description = $parts[2] ?: null;

        return new self($content);
    }

    #[\Override]
    public function __toString(): string
    {
        return $this->value;
    }
}
