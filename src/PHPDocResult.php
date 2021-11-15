<?php

namespace PhpDocParser;

class PHPDocResult
{
    public string $description;
    /** @var \PhpDocParser\Nodes\BasePHPDocNode[] */
    public array $nodes = [];
}
