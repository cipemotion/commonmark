<?php

namespace CipeMotion\CommonMark\Inline\Processor;

use League\CommonMark\Inline\Element\Strong;
use League\CommonMark\Delimiter\DelimiterInterface;
use League\CommonMark\Inline\Element\AbstractStringContainer;
use League\CommonMark\Delimiter\Processor\DelimiterProcessorInterface;

class BoldDelimiter implements DelimiterProcessorInterface
{
    /**
     * {@inheritDoc}
     */
    public function getOpeningCharacter(): string
    {
        return '*';
    }

    /**
     * {@inheritDoc}
     */
    public function getClosingCharacter(): string
    {
        return '*';
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
        $emphasis = new Strong;

        $tmp = $opener->next();

        while ($tmp !== null && $tmp !== $closer) {
            $next = $tmp->next();
            $emphasis->appendChild($tmp);
            $tmp = $next;
        }

        $opener->insertAfter($emphasis);
    }
}
