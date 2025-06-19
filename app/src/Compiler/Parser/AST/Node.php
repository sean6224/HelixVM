<?php
namespace Compiler\Parser\AST;
/**
 * Interface Node
 *
 * Represents a node in the Abstract Syntax Tree (AST) used by the compiler parser.
 * Each node should implement this interface to define its type.
 */
interface Node
{
    public function getType(): string;
}