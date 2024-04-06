<?php

namespace Recoded\WordPressBlockParser\Blocks;

final class Block
{
    /**
     * Create new Block instance.
     *
     * @param string $namespace
     * @param string $name
     * @param array<string, mixed> $attributes
     * @param string $content
     * @return void
     */
    public function __construct(
        public readonly string $namespace,
        public readonly string $name,
        public readonly array $attributes,
        public readonly string $content,
    ) {
        //
    }
}
