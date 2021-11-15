<?php

namespace TopSoft4U\PhpDocParser;

use TopSoft4U\PhpDocParser\Nodes\BasePHPDocNode;
use TopSoft4U\PhpDocParser\Nodes\CustomPHPDocNode;
use TopSoft4U\PhpDocParser\Nodes\ParamPHPDocNode;
use TopSoft4U\PhpDocParser\Nodes\ReturnPHPDocNode;
use TopSoft4U\PhpDocParser\Nodes\ThrowsPHPDocNode;
use TopSoft4U\PhpDocParser\Nodes\VarPHPDocNode;

class PHPDocParser
{
    public function parse(?string $docComment)
    {
        if (!$docComment) {
            return [];
        }

        $docComment = str_replace("\r", "", $docComment);
        $lines = explode("\n", $docComment);
        $lines = array_slice($lines, 1, count($lines) - 2);

        $description = [];

        $tagFound = null;

        foreach ($lines as $key => &$line) {
            $line = trim($line);

            $tagPos = mb_strpos($line, "@");
            if ($tagPos == false) {
                if ($tagFound) {
                    // Not valid PHP doc content
                    continue;
                }

                $starPos = mb_strpos($line, "*");
                if ($starPos === false) {
                    continue;
                }

                $line = mb_substr($line, $starPos + 1);
                $line = trim($line);
                $description[] = $line;

                // Remove parsed description
                unset($lines[$key]);
                continue;
            }

            $tagFound = true;
            $line = mb_substr($line, $tagPos);
        }

        $comment = implode("\n", $lines);

        $nodes = [];
        $offset = 0;
        while ($tagInfo = FindTagResult::Find($comment, $offset)) {
            $offset = $tagInfo->offset;
            $tag = $tagInfo->tag;

            [$tagName, $content] = explode(" ", $tag, 2);
            if ($tagName[0] != "@") {
                // Invalid tag
                continue;
            }

            /** @var BasePHPDocNode $node */
            $node = null;
            switch ($tagName) {
                case "@param":
                    $node = ParamPHPDocNode::parse($content);
                    break;
                case "@return":
                    $node = ReturnPHPDocNode::parse($content);
                    break;
                case "@var":
                    $node = VarPHPDocNode::parse($content);
                    break;
                case "@throws":
                    $node = ThrowsPHPDocNode::parse($content);
                    break;
//                case "@template":
//                    $info = $this->parseTemplate($content);
//                    break;
                default:
                    $node = CustomPHPDocNode::parse($content);
                    break;
            }

            if ($node == null) {
                continue;
            }

            $nodes[] = $node;
        }

        $result = new PHPDocResult();
        $result->description = implode("\n", $description);
        $result->nodes = $nodes;
        return $result;
    }
}
