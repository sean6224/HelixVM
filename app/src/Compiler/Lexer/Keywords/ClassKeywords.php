<?php
namespace Compiler\Lexer\Keywords;

use Compiler\Lexer\TokenType;

/**
 * Class ClassKeywords
 *
 * Provides class-related keywords for the lexer.
 * These include keywords used for class declarations, inheritance,
 * object instantiation, visibility modifiers, and static members.
 *
 * This class implements KeywordProvider and returns a keyword map
 * where each class-related token (like `cl`, `extends`, `this`) is mapped
 * to TokenType::KEYWORD.
 */
class ClassKeywords implements KeywordProvider
{
    public function getKeywords(): array
    {
        return [
            'cl'     => TokenType::KEYWORD,
            'extends'   => TokenType::KEYWORD,
            'new'       => TokenType::KEYWORD,
            'this'      => TokenType::KEYWORD,
            'super'     => TokenType::KEYWORD,
            'pub'    => TokenType::KEYWORD,
            'private'   => TokenType::KEYWORD,
            'prot' => TokenType::KEYWORD,
            'static'    => TokenType::KEYWORD,
        ];
    }
}
