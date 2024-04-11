<?php

namespace Recoded\WordPressBlockParser\Blocks;

use Recoded\WordPressBlockParser\Tokens\BlockClosing;
use Recoded\WordPressBlockParser\Tokens\BlockOpening;

final class Block extends AbstractBlock
{
    /**
     * Create new Block instance.
     *
     * @param string $namespace
     * @param string $name
     * @param array<string, mixed> $attributes
     * @param string $content
     * @param \Recoded\WordPressBlockParser\Tokens\BlockOpening $opening
     * @param \Recoded\WordPressBlockParser\Tokens\BlockClosing $closing
     * @return void
     */
    public function __construct(
        public readonly string $namespace,
        public readonly string $name,
        public readonly array $attributes,
        public readonly string $content,
        public readonly BlockOpening $opening,
        public readonly BlockClosing $closing,
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
        return $this->opening->startsAt;
    }

    /**
     * Get the offset on which the block ends.
     *
     * @return int
     */
    public function getEnd(): int
    {
        return $this->closing->startsAt + $this->closing->length;
    }
}
