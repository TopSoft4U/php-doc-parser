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
    public function rawParse(?string $docComment): PHPDocRawResult
    {
        $result = new PHPDocRawResult();

        if (!$docComment) {
            return $result;
        }

        $docComment = str_replace("\r", "", $docComment);
        $docComment = str_replace("/**", "", $docComment);
        $docComment = str_replace("*/", "", $docComment);

        $lines = explode("\n", $docComment);

        $description = [];

        $tagFound = null;

        foreach ($lines as $key => &$line) {
            $line = trim($line);

            if (str_starts_with($line, "*")) {
                $line = mb_substr($line, 1);
                $line = trim($line);
            }

            $tagPos = mb_strpos($line, "@");
            if ($tagPos === false) {
                if ($tagFound) {
                    // Not valid PHP doc content
                    continue;
                }

                // First line of phpdoc and is empty - don't add
                if (!$description && !$line)
                    continue;

                $starPos = mb_strpos($line, "*");
                if ($starPos !== false) {
                    $line = mb_substr($line, $starPos + 1);
                }

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
                case "@see":
                    // Not needed
                    break;
//                case "@template":
//                    $info = $this->parseTemplate($content);
//                    break;
                default:
                    $node = CustomPHPDocNode::parse($content);
                    $node->tagName = $tagName;
                    break;
            }

            if ($node == null) {
                continue;
            }

            $nodes[] = $node;
        }

        // Join all lines, but exclude empty or "\n" or "\r\n" lines from end of array
        $description = array_reverse($description);
        foreach ($description as $key => $line) {
            if ($line) {
                break;
            }
            unset($description[$key]);
        }
        $description = array_reverse($description);

        $result->description = implode("\n", $description);
        $result->nodes = $nodes;
        return $result;
    }

    public function parse(?string $docComment): PHPDocResult
    {
        $parseResult = $this->rawParse($docComment);

        $result = new PHPDocResult();
        $result->description = $parseResult->description;

        foreach ($parseResult->nodes as $node) {
            if ($node instanceof ReturnPHPDocNode) {
                $result->return = $node;
                continue;
            }
            if ($node instanceof VarPHPDocNode) {
                $result->var = $node;
                continue;
            }
            if ($node instanceof ParamPHPDocNode) {
                $result->params[$node->paramName] = $node;
                continue;
            }
            if ($node instanceof ThrowsPHPDocNode) {
                $result->throws[] = $node;
                continue;
            }
            if ($node instanceof CustomPHPDocNode) {
                $result->custom[] = $node;
                continue;
            }
        }

        return $result;
    }

}
