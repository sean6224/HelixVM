<?php
namespace Compiler\Lexer\Keywords;

use Compiler\Lexer\TokenType;

/**
 * Class LiteralKeywords
 *
 * Provides literal keywords for the lexer.
 * Includes boolean and null literals recognized by the language.
 *
 * This class implements KeywordProvider and returns a keyword map
 * where literals like `true` and `false` are mapped to TokenType::BOOLEAN,
 * and `null` is mapped to TokenType::NULL.
 */
final class LiteralKeywords implements KeywordProvider
{
    public function getKeywords(): array
    {
        return [
            'true' => TokenType::BOOLEAN,
            'false' => TokenType::BOOLEAN,
            'null' => TokenType::NULL,
        ];
    }
}