<?php
declare(strict_types=1);
namespace Compiler\Lexer;

/**
 * Class Token
 *
 * Represents a lexical token produced by the lexer.
 *
 * Properties:
 * - type: TokenType enum indicating the kind of token.
 * - value: string content of the token.
 * - Position: integer offset of the token's start in the source.
 */
final class Token
{
    public function __construct(
        public TokenType $type,
        public string $value,
        public int $position,
    ) {}
}
