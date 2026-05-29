<?php

namespace TopSoft4U\PhpDocParser;

use TopSoft4U\PhpDocParser\Nodes\DeprecatedPHPDocNode;
use TopSoft4U\PhpDocParser\Nodes\ExtendsPHPDocNode;
use TopSoft4U\PhpDocParser\Nodes\ReturnPHPDocNode;
use TopSoft4U\PhpDocParser\Nodes\TemplatePHPDocNode;
use TopSoft4U\PhpDocParser\Nodes\VarPHPDocNode;

class PHPDocResult
{
    public ?string $description = null;

    /**
     * @var \TopSoft4U\PhpDocParser\Nodes\ParamPHPDocNode[]
     */
    public array $params = [];
    /**
     * @var \TopSoft4U\PhpDocParser\Nodes\ThrowsPHPDocNode[]
     */
    public array $throws = [];

    public ?VarPHPDocNode $var = null;
    public ?ReturnPHPDocNode $return = null;
    public ?DeprecatedPHPDocNode $deprecated = null;

    /**
     * @var \TopSoft4U\PhpDocParser\Nodes\TemplatePHPDocNode[]
     */
    public array $templates = [];

    /**
     * @var \TopSoft4U\PhpDocParser\Nodes\ExtendsPHPDocNode[]
     */
    public array $extends = [];

    /**
     * @var \TopSoft4U\PhpDocParser\Nodes\CustomPHPDocNode[]
     */
    public array $custom = [];
}
