<?php

namespace TopSoft4U\PhpDocParser;

class PHPDocResult
{
    public string $description;
    /** @var \TopSoft4U\PhpDocParser\Nodes\BasePHPDocNode[] */
    public array $nodes = [];
}
