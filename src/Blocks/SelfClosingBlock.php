<?php

namespace Recoded\WordPressBlockParser\Blocks;

use Recoded\WordPressBlockParser\Tokens\SelfClosingBlock as SelfClosingBlockToken;

final class SelfClosingBlock extends AbstractBlock
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

    /**
     * Get the offset on which the block starts.
     *
     * @return int
     */
    public function getStart(): int
    {
        return $this->token->startsAt;
    }

    /**
     * Get the offset on which the block ends.
     *
     * @return int
     */
    public function getEnd(): int
    {
        return $this->token->startsAt + $this->token->length;
    }
}
