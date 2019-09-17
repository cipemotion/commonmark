<?php

namespace CipeMotion\CommonMark\Inline\Element;

use League\CommonMark\Inline\Element\AbstractInline;

class Del extends AbstractInline
{
    /**
     * {@inheritdoc}
     */
    public function isContainer(): bool
    {
        return true;
    }
}
