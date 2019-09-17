<?php

namespace CipeMotion\CommonMark\Inline\Processor;

use League\CommonMark\Inline\Element\Emphasis;
use League\CommonMark\Delimiter\DelimiterInterface;
use League\CommonMark\Inline\Element\AbstractStringContainer;
use League\CommonMark\Delimiter\Processor\DelimiterProcessorInterface;

class EmphasisDelimiter implements DelimiterProcessorInterface
{
    /**
     * {@inheritDoc}
     */
    public function getOpeningCharacter(): string
    {
        return '_';
    }

    /**
     * {@inheritDoc}
     */
    public function getClosingCharacter(): string
    {
        return '_';
    }

    /**
     * {@inheritDoc}
     */
    public function getMinLength(): int
    {
        return 1;
    }

    /**
     * {@inheritDoc}
     */
    public function getDelimiterUse(DelimiterInterface $opener, DelimiterInterface $closer): int
    {
        return 1;
    }

    /**
     * {@inheritDoc}
     */
    public function process(AbstractStringContainer $opener, AbstractStringContainer $closer, int $delimiterUse)
    {
        $emphasis = new Emphasis;

        $tmp = $opener->next();

        while ($tmp !== null && $tmp !== $closer) {
            $next = $tmp->next();
            $emphasis->appendChild($tmp);
            $tmp = $next;
        }

        $opener->insertAfter($emphasis);
    }
}
