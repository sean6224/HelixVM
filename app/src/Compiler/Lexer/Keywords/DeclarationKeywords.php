<?php
namespace Compiler\Lexer\Keywords;

use Compiler\Lexer\TokenType;

/**
 * Class DeclarationKeywords
 *
 * Provides declaration-related keywords for the lexer.
 * Includes keywords used for variable declarations and function definitions.
 *
 * This class implements KeywordProvider and returns a keyword map
 * where each declaration keyword (like `var`, `const`, `fn`) is mapped
 * to TokenType::KEYWORD.
 */
class DeclarationKeywords implements KeywordProvider
{
    public function getKeywords(): array
    {
        return [
            'var' => TokenType::KEYWORD,
            'const' => TokenType::KEYWORD,
            'let' => TokenType::KEYWORD,
            'fn' => TokenType::KEYWORD,
        ];
    }
}
