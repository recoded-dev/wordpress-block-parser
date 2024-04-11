<?php

namespace Tests;

use Recoded\WordPressBlockParser\BlockParser;
use Recoded\WordPressBlockParser\BlockReplacer;

final class BlockReplacerTest extends TestCase
{
    public function test_it_replaces_blocks(): void
    {
        $parser = BlockParser::create($content = <<<HTML
<!-- wp:paragraph -->
    <!-- wp:paragraph -->
    Test
    <!-- /wp:paragraph -->
<!-- /wp:paragraph -->
<!-- wp:paragraph /-->
HTML);

        $blocks = iterator_to_array($parser);

        $replaced = (string) BlockReplacer::create($content)
            ->replace($blocks[0], 'foo')
            ->replace($blocks[1], 'bar');

        self::assertEquals('foo
bar', $replaced);
    }
}
