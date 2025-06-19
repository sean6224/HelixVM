<?php
namespace Compiler\Lexer\Keywords;

interface KeywordProvider
{
    /** @return array<string, string> */
    public function getKeywords(): array;
}
