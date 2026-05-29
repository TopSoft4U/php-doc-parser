<?php

namespace TopSoft4U\PhpDocParser\Nodes;

class TemplatePHPDocNode implements BasePHPDocNode
{
    public function __construct(
        public string $name,
        public ?string $bound = null,
    ) {
    }

    #[\Override]
    public static function parse(string $content): TemplatePHPDocNode
    {
        $content = trim($content);

        $name = $content;
        $bound = null;

        if (preg_match('/^(\w+)\s+of\s+(\S+)/', $content, $matches)) {
            $name = $matches[1];
            $bound = $matches[2];
        } elseif (preg_match('/^(\w+)/', $content, $matches)) {
            $name = $matches[1];
        }

        return new self($name, $bound);
    }

    #[\Override]
    public function __toString(): string
    {
        return $this->bound ? "$this->name of $this->bound" : $this->name;
    }
}
