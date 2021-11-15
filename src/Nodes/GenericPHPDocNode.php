<?php

namespace TopSoft4U\PhpDocParser\Nodes;

class GenericPHPDocNode implements BasePHPDocNode
{
    public string $value;

    public function __construct(string $value)
    {
        $this->value = $value;
    }

    public static function parse(string $content): GenericPHPDocNode
    {
//        $parts = explode(" ", $content, 3);

//        $value        = $parts[1];
//        $description = $parts[2] ?: null;

        return new self($content);
    }

    public function __toString()
    {
        return $this->value;
    }
}
