<?php

namespace CipeMotion\CommonMark\Delimiter\Processor;

use League\CommonMark\Delimiter\DelimiterInterface;
use League\CommonMark\Node\Inline\AbstractStringContainer;
use League\CommonMark\Delimiter\Processor\DelimiterProcessorInterface;

final class SingleCharacterDelimiterProcessor implements DelimiterProcessorInterface
{
    /** @psalm-readonly */
    private string $char;

    /** @psalm-readonly */
    private string $nodeClass;

    /**
     * @param string $char      The character to use
     * @param string $nodeClass The node class name
     */
    public function __construct(string $char, string $nodeClass)
    {
        $this->char      = $char;
        $this->nodeClass = $nodeClass;
    }

    public function getOpeningCharacter(): string
    {
        return $this->char;
    }

    public function getClosingCharacter(): string
    {
        return $this->char;
    }

    public function getMinLength(): int
    {
        return 1;
    }

    public function getDelimiterUse(DelimiterInterface $opener, DelimiterInterface $closer): int
    {
        return 1;
    }

    public function process(AbstractStringContainer $opener, AbstractStringContainer $closer, int $delimiterUse): void
    {
        if ($delimiterUse === 1) {
            $node = new $this->nodeClass($this->char);
        } else {
            return;
        }

        $next = $opener->next();
        while ($next !== null && $next !== $closer) {
            $tmp = $next->next();
            $node->appendChild($next);
            $next = $tmp;
        }

        $opener->insertAfter($node);
    }
}
