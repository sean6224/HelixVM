<?php
declare(strict_types=1);
namespace Compiler\Parser\AST;

/**
 * Class MethodDeclarationNode
 *
 * Represents a method declaration within a class in the AST.
 *
 * Properties:
 * - visibility: Visibility modifier as string (e.g., 'pub', 'private', 'prot').
 * - isStatic: Indicates if the method is static.
 * - name: Name of the method.
 * - parameters: Array of parameters for the method.
 * - Body: Array representing the method's body statements.
 */
final class MethodDeclarationNode implements ClassMemberNode
{
    public function __construct(
        public string $visibility,
        public bool $isStatic,
        public string $name,
        public array $parameters,
        public array $body
    ) {
    }

    public function getType(): string
    {
        return 'MethodDeclaration';
    }
}
