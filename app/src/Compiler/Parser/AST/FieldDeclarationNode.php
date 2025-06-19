<?php
declare(strict_types=1);
namespace Compiler\Parser\AST;

/**
 * Class FieldDeclarationNode
 *
 * Represents a field (property) declaration in a class within the AST.
 *
 * Properties:
 * - visibility: Visibility modifier as string (e.g., 'pub', 'private', 'prot').
 * - isStatic: Boolean flag indicating if the field is static.
 * - name: Name of the field.
 * - value: Initial value assigned to the field (mixed type).
 */
final class FieldDeclarationNode implements ClassMemberNode
{
    public function __construct(
        public string $visibility,
        public bool $isStatic,
        public string $name,
        public mixed $value
    ) {
    }

    public function getType(): string
    {
        return 'FieldDeclaration';
    }
}
