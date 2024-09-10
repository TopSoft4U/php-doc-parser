<?php

namespace TopSoft4U\PhpDocParser\Nodes;

class ReturnPHPDocNode implements BasePHPDocNode
{
    public function __construct(public string $type, public ?string $description = null)
    {
    }

    #[\Override]
    public static function parse(string $content): ReturnPHPDocNode
    {
        $parts = explode(" ", $content, 2);

        $type = $parts[0];

        $description = null;
        if (isset($parts[1])) {
            $description = $parts[1];
        }

        return new self($type, $description);
    }

    #[\Override]
    public function __toString(): string
    {
        return implode(" ", array_filter([$this->type, $this->description]));
    }
}
