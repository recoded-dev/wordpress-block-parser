<?php

namespace Recoded\WordPressBlockParser\Blocks;

use Recoded\WordPressBlockParser\Tokens\BlockClosing;
use Recoded\WordPressBlockParser\Tokens\BlockOpening;

final class Block
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
}
