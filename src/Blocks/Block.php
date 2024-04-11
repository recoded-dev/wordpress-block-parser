<?php

namespace Recoded\WordPressBlockParser\Blocks;

use Recoded\WordPressBlockParser\Tokens\BlockClosing;
use Recoded\WordPressBlockParser\Tokens\BlockOpening;

/**
 * @TODO find better name, block is too generic
 */
final class Block extends AbstractBlock
{
    public readonly string $content;
    public readonly BlockOpening $opening;
    public readonly BlockClosing $closing;

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
        string $namespace,
        string $name,
        array $attributes,
        string $content,
        BlockOpening $opening,
        BlockClosing $closing,
    ) {
        parent::__construct($namespace, $name, $attributes);

        $this->content = $content;
        $this->opening = $opening;
        $this->closing = $closing;
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
