<?php

namespace PhpDocParser\Nodes;

class ParamPHPDocNode implements BasePHPDocNode
{
    public string $type;
    public string $paramName;
    public ?string $description;

    public function __construct(string $type, string $paramName, ?string $description)
    {
        $this->type = $type;
        $this->paramName = $paramName;
        $this->description = $description;
    }

    public static function parse(string $content): ParamPHPDocNode
    {
        $parts = explode(" ", $content, 3);

        $type = $parts[0];
        $paramName = str_replace("$", "", $parts[1]);

        $description = null;
        if (isset($parts[2])) {
            $description = $parts[2];
        }

        return new self($type, $paramName, $description);
    }

    public function __toString()
    {
        return implode(" ", array_filter([$this->type, $this->paramName, $this->description]));
    }
}
