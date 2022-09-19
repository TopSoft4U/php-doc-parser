<?php

namespace TopSoft4U\PhpDocParser;

use TopSoft4U\PhpDocParser\Nodes\ReturnPHPDocNode;
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

    /**
     * @var \TopSoft4U\PhpDocParser\Nodes\CustomPHPDocNode[]
     */
    public array $custom = [];
//    public ?TemplatePHPDocNode $template = null;
}
