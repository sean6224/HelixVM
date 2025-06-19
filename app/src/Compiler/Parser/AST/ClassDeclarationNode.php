<?php
declare(strict_types=1);
namespace Compiler\Parser\AST;

/**
 * Class ClassDeclarationNode
 *
 * Represents a class declaration in the abstract syntax tree (AST).
 *
 * Properties:
 * - name: The name of the class.
 * - members: An array of Node instances representing class members (fields, methods, etc.).
 */
final class ClassDeclarationNode implements Node
{
    public string $name;

    /** @var Node[] List of members of the class (fields, methods, etc.) */
    public array $members;

    public function __construct(string $name, array $members = [])
    {
        $this->name = $name;
        $this->members = $members;
    }

    public function getType(): string
    {
        return 'ClassDeclaration';
    }
}
