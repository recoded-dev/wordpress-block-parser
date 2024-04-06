<?php

namespace Recoded\WordPressBlockParser\Tokens;

abstract class Token
{
    /**
     * Create new Token instance.
     *
     * @param int $startsAt
     * @param int $length
     * @return void
     */
    public function __construct(
        public readonly int $startsAt,
        public readonly int $length,
    ) {
        //
    }
}
