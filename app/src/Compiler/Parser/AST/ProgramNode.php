<?php
declare(strict_types=1);
namespace Compiler\Parser\AST;

/**
 * Class ProgramNode
 * Represents the root node of the AST containing all top-level statements.
 *
 * Properties:
 * - statements: Array of AST nodes representing program statements.
 */
final class ProgramNode implements Node
{
    public function __construct(
        public array $statements = []
    ) {
    }

    public function getType(): string
    {
        return 'Program';
    }
}