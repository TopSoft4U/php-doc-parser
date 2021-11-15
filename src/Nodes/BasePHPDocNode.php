<?php

namespace PhpDocParser\Nodes;

interface BasePHPDocNode
{
    public static function parse(string $content): BasePHPDocNode;

    public function __toString();
}
