<?php

use TopSoft4U\PhpDocParser\PHPDocParser;

require_once "ExampleClass.php";

$refClass = new ReflectionClass("ExampleClass");
$prop = $refClass->getProperty("prop");

$phpDoc = $prop->getDocComment();

$parser = new PHPDocParser();
$result = $parser->parse($phpDoc);

var_dump($result);
