<?php

namespace Recoded\WordPressBlockParser;

use Generator;
use IteratorAggregate;
use Recoded\WordPressBlockParser\Tokens\BlockClosing;
use Recoded\WordPressBlockParser\Tokens\BlockOpening;
use Recoded\WordPressBlockParser\Tokens\SelfClosingBlock;

/**
 * @implements \IteratorAggregate<int, \Recoded\WordPressBlockParser\Tokens\Token>
 */
final class Tokenizer implements IteratorAggregate
{
    public const PATTERN = '/<!--\s+(?P<closer>\/)?wp:(?P<namespace>[a-z][a-z0-9_-]*\/)?(?P<name>[a-z][a-z0-9_-]*)\s+(?P<attrs>{(?:(?:[^}]+|}+(?=})|(?!}\s+\/?-->).)*+)?}\s+)?(?P<void>\/)?-->/s';

    private int $currentOffset = 0;

    /**
     * Create a new Tokenizer instance.
     *
     * @param string $content
     * @return void
     */
    public function __construct(
        public readonly string $content,
    ) {
        //
    }

    /**
     * Create a new tokenizer from content string.
     *
     * @param string $content
     * @return self
     */
    public static function create(string $content): self
    {
        return new self($content);
    }

    /**
     * Iterate over the tokens.
     *
     * @return \Generator
     */
    public function getIterator(): Generator
    {
        do {
            $result = preg_match(
                '/<!--\s+(?P<closer>\/)?wp:(?P<namespace>[a-z][a-z0-9_-]*\/)?(?P<name>[a-z][a-z0-9_-]*)\s+(?P<attrs>{(?:(?:[^}]+|}+(?=})|(?!}\s+\/?-->).)*+)?}\s+)?(?P<void>\/)?-->/s',
                $this->content,
                $matches,
                PREG_OFFSET_CAPTURE,
                $this->currentOffset
            );

            if ($result === false || $result === 0) {
                continue;
            }

            [$match, $offset] = $matches[0];

            $length = strlen($match);
            $hasAttributes = isset($matches['attrs']) && $matches['attrs'][1] !== -1;
            /** @var array<string, mixed> $attributes */
            $attributes = $hasAttributes
                ? json_decode($matches['attrs'][0], associative: true)
                : [];
            $namespace = (isset($matches['namespace']) && -1 !== $matches['namespace'][1])
                ? $matches['namespace'][0]
                : 'core/';
            $name = $matches['name'][0];

            if (isset($matches['void']) && $matches['void'][1] !== -1) {
                yield new SelfClosingBlock(
                    namespace: $namespace,
                    name: $name,
                    attributes: $attributes,
                    startsAt: $offset,
                    length: $length,
                );
            } elseif (isset($matches['closer']) && $matches['closer'][1] !== -1) {
                yield new BlockClosing(
                    namespace: $namespace,
                    name: $name,
                    startsAt: $offset,
                    length: $length,
                );
            } else {
                yield new BlockOpening(
                    namespace: $namespace,
                    name: $name,
                    attributes: $attributes,
                    startsAt: $offset,
                    length: $length,
                );
            }

            $this->currentOffset = $offset + $length;
        } while ($result !== false && $result !== 0);
    }
}
