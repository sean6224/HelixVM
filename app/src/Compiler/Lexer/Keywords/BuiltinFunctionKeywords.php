<?php
namespace Compiler\Lexer\Keywords;

use Compiler\Lexer\TokenType;

/**
 * Class BuiltinFunctionKeywords
 *
 * Provides built-in function keywords for the lexer.
 * These are high-level language constructs that behave like functions
 * but are recognized as keywords during lexical analysis.
 *
 * This class implements KeywordProvider and returns a keyword map
 * where each built-in function (like `print`, `input`) is mapped
 * to TokenType::KEYWORD.
 */
class BuiltinFunctionKeywords implements KeywordProvider
{
    public function getKeywords(): array
    {
        return [
            'print' => TokenType::KEYWORD,
            'input' => TokenType::KEYWORD,
        ];
    }
}