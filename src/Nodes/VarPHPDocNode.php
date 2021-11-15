<?php

namespace TopSoft4U\PhpDocParser\Nodes;

class VarPHPDocNode implements BasePHPDocNode
{
    public string $type;
    public ?string $varName;
    public ?string $description;

    public function __construct(string $type, ?string $variableName, ?string $description)
    {
        $this->type = $type;
        $this->varName = $variableName;
        $this->description = $description;
    }

    public static function parse(string $content): VarPHPDocNode
    {
        $parts = explode(" ", $content, 3);

        $type = $parts[0];

        $varName = null;
        if (isset($parts[1])) {
            $varName = str_replace("$", "", $parts[1]);
        }

        $description = null;
        if (isset($parts[2])) {
            $description = $parts[2];
        }

        return new self($type, $varName, $description);
    }

    public function __toString()
    {
        return implode(" ", array_filter([$this->type, $this->varName, $this->description]));
    }
}
