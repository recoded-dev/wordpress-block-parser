<?php

namespace Recoded\WordPressBlockParser\Blocks;

abstract class AbstractBlock
{
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
