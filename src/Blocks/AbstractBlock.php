<?php

namespace Recoded\WordPressBlockParser\Blocks;

abstract class AbstractBlock
{
    /**
     * Create new AbstractBlock instance.
     *
     * @param string $namespace
     * @param string $name
     * @param array<string, mixed> $attributes
     * @return void
     */
    public function __construct(
        public readonly string $namespace,
        public readonly string $name,
        public readonly array $attributes,
    ) {
        //
    }

    /**
     * Get the offset on which the block starts.
     *
     * @return int
     */
    abstract public function getStart(): int;

    /**
     * Get the offset on which the block ends.
     *
     * @return int
     */
    abstract public function getEnd(): int;
}
