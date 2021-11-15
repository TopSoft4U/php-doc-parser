<?php

namespace TopSoft4U\PhpDocParser;

class PHPDocRawResult
{
    public ?string $description = null;
    /** @var \TopSoft4U\PhpDocParser\Nodes\BasePHPDocNode[] */
    public array $nodes = [];
}
