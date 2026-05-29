<?php

namespace TopSoft4U\PhpDocParser\Nodes;

class ExtendsPHPDocNode implements BasePHPDocNode
{
    public function __construct(
        public string $parentClass,
        public array $genericArgs = [],
    ) {
    }

    #[\Override]
    public static function parse(string $content): ExtendsPHPDocNode
    {
        $content = trim($content);

        $genericArgs = [];
        $parentClass = $content;

        $genericStart = mb_strpos($content, "<");
        $genericEnd = mb_strrpos($content, ">");
        if ($genericStart !== false && $genericEnd !== false) {
            $parentClass = trim(mb_substr($content, 0, $genericStart));
            $argsStr = mb_substr($content, $genericStart + 1, $genericEnd - $genericStart - 1);
            $genericArgs = array_map("trim", explode(",", $argsStr));
        }

        return new self($parentClass, $genericArgs);
    }

    #[\Override]
    public function __toString(): string
    {
        if ($this->genericArgs) {
            return $this->parentClass . "<" . implode(", ", $this->genericArgs) . ">";
        }
        return $this->parentClass;
    }
}
