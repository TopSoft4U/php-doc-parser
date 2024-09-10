<?php

namespace TopSoft4U\PhpDocParser\Nodes;

class ParamPHPDocNode implements BasePHPDocNode
{
    public array $genericArgs = [];

    public function __construct(public string $type, public string $paramName, public ?string $description = null)
    {
    }

    #[\Override]
    public static function parse(string $content): ParamPHPDocNode
    {
        $parts = explode(" ", $content, 3);

        $type = $parts[0];

        $genericArgs = [];
        $genericStart = mb_strpos($type, "<");
        $genericEnd = mb_strpos($type, ">");
        if ($genericStart !== false && $genericEnd !== false) {
            $generic = mb_substr($type, $genericStart + 1, $genericEnd - $genericStart - 1);
            $genericArgs = explode(",", $generic);
            $type = mb_substr($type, 0, $genericStart) . mb_substr($type, $genericEnd + 1);
        }

        $paramName = str_replace("$", "", $parts[1]);

        $description = null;
        if (isset($parts[2])) {
            $description = $parts[2];
        }

        $paramNode = new self($type, $paramName, $description);
        $paramNode->genericArgs = $genericArgs;

        return $paramNode;
    }

    #[\Override]
    public function __toString(): string
    {
        return implode(" ", array_filter([$this->type, $this->paramName, $this->description]));
    }
}
