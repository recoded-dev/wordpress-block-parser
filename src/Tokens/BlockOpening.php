<?php

namespace Recoded\WordPressBlockParser\Tokens;

final class BlockOpening extends Token
{
    /**
     * Create new BlockOpening instance.
     *
     * @param string $namespace
     * @param string $name
     * @param array<string, mixed> $attributes
     * @param int $startsAt
     * @param int $length
     * @return void
     */
    public function __construct(
        public readonly string $namespace,
        public readonly string $name,
        public readonly array $attributes,
        int $startsAt,
        int $length,
    ) {
        parent::__construct(
            startsAt: $startsAt,
            length: $length,
        );
    }
}
