<?php
declare(strict_types=1);
namespace Compiler\Lexer;

use Compiler\Lexer\Keywords\BuiltinFunctionKeywords;
use Compiler\Lexer\Keywords\ClassKeywords;
use Compiler\Lexer\Keywords\DeclarationKeywords;
use Compiler\Lexer\Keywords\FlowControlKeywords;
use Compiler\Lexer\Keywords\LiteralKeywords;
use RuntimeException;

/**
 * Class ConcreteLexer
 *
 * Concrete implementation of BaseLexer performing lexical analysis.
 * Use KeywordRegistry to recognize keywords from multiple providers.
 *
 * Supports:
 * - Whitespace skipping
 * - String literals with escape sequences
 * - Identifiers and keywords resolution
 * - Numeric literals (integers and floats)
 * - Operators (single and two-character)
 * - Punctuation tokens
 * - Unknown character handling
 */
final class ConcreteLexer extends BaseLexer
{
    private KeywordRegistry $keywordRegistry;

    public function __construct(string $source)
    {
        parent::__construct($source);
        $this->keywordRegistry = new KeywordRegistry
        (
            [
                new FlowControlKeywords(),
                new LiteralKeywords(),
                new DeclarationKeywords(),
                new BuiltinFunctionKeywords(),
                new ClassKeywords(),
            ]
        );
    }

    public function getNextToken(): Token
    {
        while ($this->currentChar !== null)
        {
            if (ctype_space($this->currentChar))
            {
                $this->skipWhitespace();
                continue;
            }

            if ($this->currentChar === '/' && $this->peek() === '/')
            {
                $this->skipLineComment();
                continue;
            }

            if ($this->currentChar === '/' && $this->peek() === '*')
            {
                $this->skipBlockComment();
                continue;
            }

            if ($this->currentChar === '"' || $this->currentChar === "'")
            {
                return $this->readString();
            }

            if (ctype_alpha($this->currentChar) || $this->currentChar === '_')
            {
                return $this->readIdentifierOrKeyword();
            }

            if (ctype_digit($this->currentChar))
            {
                return $this->readNumber();
            }

            if ($this->isOperatorStart($this->currentChar))
            {
                return $this->readOperator();
            }

            $pos = $this->pos;
            if ($this->isPunctuation($this->currentChar))
            {
                $value = $this->currentChar;
                $this->advance();
                return new Token(TokenType::PUNCTUATION, $value, $pos);
            }

            // Unknown character skipping
            $unknownChar = $this->currentChar;
            $this->advance();
            return new Token(TokenType::UNKNOWN, $unknownChar, $pos);
        }

        return new Token(TokenType::EOF, '', $this->pos);
    }

    private function readIdentifierOrKeyword(): Token
    {
        $pos = $this->pos;
        $result = '';

        while ($this->currentChar !== null && (ctype_alnum($this->currentChar)
                || $this->currentChar === '_'))
        {
            $result .= $this->currentChar;
            $this->advance();
        }

        $tokenType = $this->keywordRegistry->getTokenType($result);
        return new Token($tokenType, $result, $pos);
    }

    private function readNumber(): Token
    {
        $pos = $this->pos;
        $numStr = '';
        $hasDot = false;

        while ($this->currentChar !== null && (ctype_digit($this->currentChar)
                || (!$hasDot && $this->currentChar === '.')))
        {
            if ($this->currentChar === '.')
            {
                $hasDot = true;
            }
            $numStr .= $this->currentChar;
            $this->advance();
        }

        return new Token(TokenType::NUMBER, $numStr, $pos);
    }

    private function readString(): Token
    {
        $pos = $this->pos;
        $quoteType = $this->currentChar;
        $this->advance();
        $result = '';

        while ($this->currentChar !== null && $this->currentChar !== $quoteType)
        {
            if ($this->currentChar === '\\')
            {
                $this->advance();
                if ($this->currentChar !== null)
                {
                    $escapedChar = $this->escapeChar($this->currentChar);
                    $result .= $escapedChar;
                    $this->advance();
                    continue;
                }
                break;
            }
            $result .= $this->currentChar;
            $this->advance();
        }

        if ($this->currentChar === $quoteType)
        {
            $this->advance();
        } else {
            throw new RuntimeException("Unterminated string literal at position $pos");
        }

        return new Token(TokenType::STRING, $result, $pos);
    }

    private function escapeChar(string $char): string
    {
        return match ($char) {
            'n' => "\n",
            'r' => "\r",
            't' => "\t",
            '\\' => '\\',
            '"' => '"',
            "'" => "'",
            default => $char,
        };
    }

    private function isOperatorStart(string $char): bool
    {
        $ops = ['+', '-', '*', '/', '=', '<', '>', '!', '&', '|', '^', '%'];
        return in_array($char, $ops, true);
    }

    private function readOperator(): Token
    {
        $pos = $this->pos;
        $result = $this->currentChar;
        $this->advance();

        $twoCharOps = ['==', '!=', '<=', '>=', '&&', '||', '+=', '-=', '*=', '/='];
        $peekChar = $this->currentChar;

        if ($peekChar !== null && in_array($result . $peekChar, $twoCharOps, true))
        {
            $result .= $peekChar;
            $this->advance();
        }

        return new Token(TokenType::OPERATOR, $result, $pos);
    }

    private function isPunctuation(string $char): bool
    {
        $punct = [';', '(', ')', '{', '}', ',', '.', '[', ']'];
        return in_array($char, $punct, true);
    }

    private function skipLineComment(): void
    {
        while ($this->currentChar !== null && $this->currentChar !== "\n")
        {
            $this->advance();
        }
        $this->advance();
    }

    private function skipBlockComment(): void
    {
        $this->advance(); // skip '/'
        $this->advance(); // skip '*'

        while ($this->currentChar !== null)
        {
            if ($this->currentChar === '*' && $this->peek() === '/')
            {
                $this->advance();
                $this->advance();
                break;
            }
            $this->advance();
        }
    }
}
