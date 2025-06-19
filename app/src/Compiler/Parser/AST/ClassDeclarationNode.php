<?php
declare(strict_types=1);
namespace Compiler\Parser\AST;

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
