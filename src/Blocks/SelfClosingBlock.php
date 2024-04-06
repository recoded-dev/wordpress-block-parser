<?php

namespace Recoded\WordPressBlockParser\Blocks;

final class SelfClosingBlock
{
    /**
     * Create new SelfClosingBlock instance.
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
}
