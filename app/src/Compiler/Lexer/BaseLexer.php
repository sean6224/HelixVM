<?php
declare(strict_types=1);
namespace Compiler\Lexer;

/**
 * Class BaseLexer
 *
 * Abstract base class for lexers.
 * Provides common functionality for lexical analysis such as
 * managing source input, current position, and character iteration.
 *
 * Implements LexerInterface.
 *
 * Key methods:
 * - advance(): moves to the next character in the source.
 * - peek (int $offset = 1): it looks ahead by given offset without advancing.
 * - skipWhitespace(): skips whitespace characters.
 */
abstract class BaseLexer implements LexerInterface
{
    protected string $source;
    protected int $pos = 0;
    protected ?string $currentChar;
    protected int $length;

    public function __construct(string $source)
    {
        $this->source = $source;
        $this->length = strlen($source);
        $this->currentChar = $this->length > 0 ? $source[0] : null;
    }

    protected function advance(): void
    {
        $this->pos++;
        $this->currentChar = $this->pos < $this->length ? $this->source[$this->pos] : null;
    }

    protected function peek(int $offset = 1): ?string
    {
        $peekPos = $this->pos + $offset;
        return $peekPos < $this->length ? $this->source[$peekPos] : null;
    }

    protected function skipWhitespace(): void
    {
        while ($this->currentChar !== null && ctype_space($this->currentChar))
        {
            $this->advance();
        }
    }

    abstract public function getNextToken(): Token;
}
