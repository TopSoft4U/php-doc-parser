<?php

namespace TopSoft4U\PhpDocParser;

class FindTagResult
{
    public string $tag;
    public int $offset;

    public function __construct(string $tag, int $offset)
    {
        $this->tag = $tag;
        $this->offset = $offset;
    }

    public static function Find(string $comment, int $offset = 0): ?FindTagResult
    {
        $startPos = mb_strpos($comment, "@", $offset);
        if ($startPos === false) {
            return null;
        }

        $endPos = mb_strpos($comment, "@", $startPos + 1);
        $isLastTag = $endPos === false;

        $tag = mb_substr($comment, $startPos, $isLastTag ? null : $endPos);
        $tag = trim($tag);
        $newOffset = $isLastTag ? mb_strlen($comment) : $endPos;

        return new static($tag, $newOffset);
    }
}
