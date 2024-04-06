<?php

namespace Tests;

use LogicException;
use Recoded\WordPressBlockParser\BlockParser;
use Recoded\WordPressBlockParser\Blocks\Block;
use Recoded\WordPressBlockParser\Blocks\SelfClosingBlock;

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
            ),
            new SelfClosingBlock(
                namespace: 'core/',
                name: 'paragraph',
                attributes: [],
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
