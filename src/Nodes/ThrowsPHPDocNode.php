<?php

namespace PhpDocParser\Nodes;

class ThrowsPHPDocNode implements BasePHPDocNode
{
    public string $type;
    public string $description;

    public function __construct(string $type, string $description)
    {
        $this->type = $type;
        $this->description = $description;
    }

    public static function parse(string $content): ThrowsPHPDocNode
    {
        $parts = explode(" ", $content, 2);

        $type = $parts[0];

        $description = null;
        if (isset($parts[1])) {
            $description = $parts[1];
        }

        return new self($type, $description);
    }

    public function __toString()
    {
        return implode(" ", array_filter([$this->type, $this->description]));
    }
}
