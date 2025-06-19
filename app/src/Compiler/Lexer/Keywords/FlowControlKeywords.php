<?php
namespace Compiler\Lexer\Keywords;

use Compiler\Lexer\TokenType;

/**
 * Class FlowControlKeywords
 *
 * Provides flow control keywords for the lexer.
 * Includes conditional and loop keywords used to control execution flow.
 *
 * This class implements KeywordProvider and returns a keyword map
 * where each flow control keyword (like `if`, `else`, `while`, `for`) is mapped
 * to TokenType::KEYWORD.
 */
final class FlowControlKeywords implements KeywordProvider
{
    public function getKeywords(): array
    {
        return [
            'if' => TokenType::KEYWORD,
            'else' => TokenType::KEYWORD,
            'while' => TokenType::KEYWORD,
            'for' => TokenType::KEYWORD,
        ];
    }
}
