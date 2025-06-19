<?php
declare(strict_types=1);
namespace Compiler\Lexer;

interface LexerInterface
{
    public function getNextToken(): Token;
}
