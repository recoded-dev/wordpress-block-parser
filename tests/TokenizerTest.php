<?php

namespace Tests;

use Recoded\WordPressBlockParser\Tokenizer;
use Recoded\WordPressBlockParser\Value\BlockClosing;
use Recoded\WordPressBlockParser\Value\BlockOpening;
use Recoded\WordPressBlockParser\Value\SelfClosingBlock;

final class TokenizerTest extends TestCase
{
    public function test_it_tokenizes_opening_tags(): void
    {
        $tokenizer = Tokenizer::create(<<<HTML
<!-- wp:paragraph -->
HTML);

        self::assertEquals([new BlockOpening(
            namespace: 'core/',
            name: 'paragraph',
            attributes: [],
            startsAt: 0,
            length: 21,
        )], iterator_to_array($tokenizer));
    }
    public function test_it_tokenizes_opening_tags_with_attributes(): void
    {
        $tokenizer = Tokenizer::create(<<<HTML
<!-- wp:paragraph {"foo": "bar"} -->
HTML);

        self::assertEquals([new BlockOpening(
            namespace: 'core/',
            name: 'paragraph',
            attributes: [
                'foo' => 'bar',
            ],
            startsAt: 0,
            length: 36,
        )], iterator_to_array($tokenizer));
    }

    public function test_it_tokenizes_closing_tags(): void
    {
        $tokenizer = Tokenizer::create(<<<HTML
<!-- /wp:paragraph -->
HTML);

        self::assertEquals([new BlockClosing(
            namespace: 'core/',
            name: 'paragraph',
            startsAt: 0,
            length: 22,
        )], iterator_to_array($tokenizer));
    }

    public function test_it_tokenizes_self_closing_blocks(): void
    {
        $tokenizer = Tokenizer::create(<<<HTML
<!-- wp:paragraph /-->
HTML);

        self::assertEquals([new SelfClosingBlock(
            namespace: 'core/',
            name: 'paragraph',
            attributes: [],
            startsAt: 0,
            length: 22,
        )], iterator_to_array($tokenizer));
    }

    public function test_it_tokenizes_self_closing_blocks_with_attributes(): void
    {
        $tokenizer = Tokenizer::create(<<<HTML
<!-- wp:paragraph {"foo": "bar"} /-->
HTML);

        self::assertEquals([new SelfClosingBlock(
            namespace: 'core/',
            name: 'paragraph',
            attributes: [
                'foo' => 'bar',
            ],
            startsAt: 0,
            length: 37,
        )], iterator_to_array($tokenizer));
    }
}
