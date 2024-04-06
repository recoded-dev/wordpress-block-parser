<?php

namespace Recoded\WordPressBlockParser\Value;

final class SelfClosingBlock extends Token
{
    /**
     * Create new SelfClosingBlock instance.
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
