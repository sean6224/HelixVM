<?php
namespace Compiler\Lexer;

use Compiler\Lexer\Keywords\KeywordProvider;

/**
 * Class KeywordRegistry
 *
 * Aggregates multiple KeywordProvider instances into a unified keyword map.
 * Provides lookup of token types by keyword strings.
 *
 * Constructor accepts an array of KeywordProvider objects and merges their keyword maps.
 *
 * getTokenType(string $value): returns the TokenType for the given keyword,
 * or TokenType::IDENTIFIER if not found.
 */
final class KeywordRegistry
{
    /** @var array<string, TokenType> */
    private array $keywords = [];

    /**
     * @param KeywordProvider[] $providers
     */
    public function __construct(array $providers)
    {
        foreach ($providers as $provider)
        {
            $this->keywords += $provider->getKeywords();
        }
    }

    public function getTokenType(string $value): TokenType
    {
        return $this->keywords[$value] ?? TokenType::IDENTIFIER;
    }
}
