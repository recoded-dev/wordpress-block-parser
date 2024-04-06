<?php

namespace Recoded\WordPressBlockParser\Value;

final class BlockClosing extends Token
{
    /**
     * Create new BlockClosing instance.
     *
     * @param string $namespace
     * @param string $name
     * @param int $startsAt
     * @param int $length
     * @return void
     */
    public function __construct(
        public readonly string $namespace,
        public readonly string $name,
        int $startsAt,
        int $length,
    ) {
        parent::__construct(
            startsAt: $startsAt,
            length: $length,
        );
    }
}
