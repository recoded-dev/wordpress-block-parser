<?php

namespace Recoded\WordPressBlockParser\Blocks;

use Recoded\WordPressBlockParser\Tokens\SelfClosingBlock as SelfClosingBlockToken;

final class SelfClosingBlock
{
    /**
     * Create new SelfClosingBlock instance.
     *
     * @param string $namespace
     * @param string $name
     * @param array<string, mixed> $attributes
     * @param \Recoded\WordPressBlockParser\Tokens\SelfClosingBlock $token
     * @return void
     */
    public function __construct(
        public readonly string $namespace,
        public readonly string $name,
        public readonly array $attributes,
        public readonly SelfClosingBlockToken $token,
    ) {
        //
    }
}
