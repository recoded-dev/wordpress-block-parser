<?php

namespace Recoded\WordPressBlockParser;

use Recoded\WordPressBlockParser\Blocks\AbstractBlock;
use Stringable;

final class BlockReplacer implements Stringable
{
    private string $replacedContent;
    private int $offsetDifference = 0;

    /**
     * Create a new BlockReplacer instance.
     *
     * @param string $content
     * @return void
     */
    public function __construct(
        public readonly string $content,
    ) {
        $this->replacedContent = $content;
    }

    /**
     * Create a new replacer from content string.
     *
     * @param string $content
     * @return self
     */
    public static function create(string $content): self
    {
        return new self($content);
    }

    /**
     * Replace the given block in the content.
     *
     * @param \Recoded\WordPressBlockParser\Blocks\AbstractBlock $block
     * @param string $replacement
     * @return $this
     */
    public function replace(AbstractBlock $block, string $replacement): self
    {
        $from = $block->getStart() + $this->offsetDifference;
        $to = $block->getEnd() + $this->offsetDifference;

        $this->replacedContent = substr($this->replacedContent, 0, $from)
            . $replacement
            . substr($this->replacedContent, $to);

        $this->offsetDifference += strlen($replacement) - ($to - $from);

        return $this;
    }

    /**
     * Get the replaced content.
     *
     * @return string
     */
    public function __toString(): string
    {
        return $this->replacedContent;
    }
}
