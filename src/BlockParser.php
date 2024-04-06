<?php

namespace Recoded\WordPressBlockParser;

use Generator;
use IteratorAggregate;
use LogicException;
use Recoded\WordPressBlockParser\Blocks\Block;
use Recoded\WordPressBlockParser\Blocks\SelfClosingBlock;
use Recoded\WordPressBlockParser\Tokens\BlockClosing;
use Recoded\WordPressBlockParser\Tokens\BlockOpening;
use Recoded\WordPressBlockParser\Tokens\SelfClosingBlock as SelfClosingBlockToken;

/**
 * @implements \IteratorAggregate<int, \Recoded\WordPressBlockParser\Blocks\Block|\Recoded\WordPressBlockParser\Blocks\SelfClosingBlock>
 */
final class BlockParser implements IteratorAggregate
{
    private Tokenizer $tokenizer;

    private int $stackDepth = 0;

    /**
     * Create a new BlockParser instance.
     *
     * @param string $content
     * @return void
     */
    public function __construct(
        public readonly string $content,
    ) {
        $this->tokenizer = Tokenizer::create($content);
    }

    /**
     * Create a new parser from content string.
     *
     * @param string $content
     * @return self
     */
    public static function create(string $content): self
    {
        return new self($content);
    }

    /**
     * Iterate over the blocks.
     *
     * @return \Generator<int, \Recoded\WordPressBlockParser\Blocks\Block|\Recoded\WordPressBlockParser\Blocks\SelfClosingBlock>
     */
    public function getIterator(): Generator
    {
        $opening = null;

        foreach ($this->tokenizer as $token) {
            if ($token instanceof SelfClosingBlockToken && $this->stackDepth === 0) {
                yield new SelfClosingBlock(
                    namespace: $token->namespace,
                    name: $token->name,
                    attributes: $token->attributes,
                );
            } elseif ($token instanceof BlockOpening && $this->stackDepth++ === 0) {
                $opening = $token;
            } elseif ($token instanceof BlockClosing && --$this->stackDepth === 0) {
                if ($opening === null || $opening->namespace !== $token->namespace || $opening->name !== $token->name) {
                    throw new LogicException('Closing token does not correspond with opening');
                }

                $openedAt = $opening->startsAt + $opening->length;

                yield new Block(
                    namespace: $opening->namespace,
                    name: $opening->name,
                    attributes: $opening->attributes,
                    content: substr(
                        $this->content,
                        $openedAt,
                        $token->startsAt - $openedAt,
                    ),
                );
            }
        }
    }
}
