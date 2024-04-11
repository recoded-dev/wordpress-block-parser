<?php

namespace Tests;

use LogicException;
use Recoded\WordPressBlockParser\BlockParser;
use Recoded\WordPressBlockParser\Blocks\Block;
use Recoded\WordPressBlockParser\Blocks\SelfClosingBlock;
use Recoded\WordPressBlockParser\Tokens\BlockClosing;
use Recoded\WordPressBlockParser\Tokens\BlockOpening;
use Recoded\WordPressBlockParser\Tokens\SelfClosingBlock as SelfClosingBlockToken;

final class BlockParserTest extends TestCase
{
    public function test_it_parses_blocks(): void
    {
        $parser = BlockParser::create(<<<HTML
<!-- wp:paragraph -->
    <!-- wp:paragraph -->
    Test
    <!-- /wp:paragraph -->
<!-- /wp:paragraph -->
<!-- wp:paragraph /-->
HTML);

        self::assertEquals([
            new Block(
                namespace: 'core/',
                name: 'paragraph',
                attributes: [],
                content: '
    <!-- wp:paragraph -->
    Test
    <!-- /wp:paragraph -->
',
                opening: new BlockOpening(
                    namespace: 'core/',
                    name: 'paragraph',
                    attributes: [],
                    startsAt: 0,
                    length: 21,
                ),
                closing: new BlockClosing(
                    namespace: 'core/',
                    name: 'paragraph',
                    startsAt: 84,
                    length: 22,
                ),
            ),
            new SelfClosingBlock(
                namespace: 'core/',
                name: 'paragraph',
                attributes: [],
                token: new SelfClosingBlockToken(
                    namespace: 'core/',
                    name: 'paragraph',
                    attributes: [],
                    startsAt: 107,
                    length: 22,
                ),
            ),
        ], iterator_to_array($parser));
    }

    public function test_it_throws_when_ending_mismatches(): void
    {
        $parser = BlockParser::create(<<<HTML
<!-- wp:paragraph -->
Foo
<!-- /wp:p -->
HTML);

        self::expectExceptionObject(new LogicException('Closing token does not correspond with opening'));
        iterator_to_array($parser);
    }
}
