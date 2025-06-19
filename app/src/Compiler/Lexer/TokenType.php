<?php
namespace Compiler\Lexer;

/**
 * Enum TokenType
 *
 * Defines all possible token types recognized by the lexer.
 *
 * Cases:
 * - EOF: End of file/input.
 * - IDENTIFIER: Names such as variables, function names, etc.
 * - NUMBER: Numeric literals.
 * - STRING: String literals.
 * - OPERATOR: Operators like +, -, ==, etc.
 * - PUNCTUATION: Symbols like ;, (, ), {, }, etc.
 * - KEYWORD: Reserved language keywords.
 * - COMMENT: Comments (line or block).
 * - WHITESPACE: Whitespace characters.
 * - BOOLEAN: Boolean literals (true, false).
 * - NULL: Null literal.
 * - UNKNOWN: Unrecognized tokens.
 */
enum TokenType: string
{
    case EOF = 'EOF';
    case IDENTIFIER = 'IDENTIFIER';
    case NUMBER = 'NUMBER';
    case STRING = 'STRING';
    case OPERATOR = 'OPERATOR';
    case PUNCTUATION = 'PUNCTUATION';
    case KEYWORD = 'KEYWORD';
    case COMMENT = 'COMMENT';
    case WHITESPACE = 'WHITESPACE';
    case BOOLEAN = 'BOOLEAN';
    case NULL = 'NULL';
    case UNKNOWN = 'UNKNOWN';
}