<?php

namespace CipeMotion\CommonMark\Inline\Renderer;

use League\CommonMark\Util\Xml;
use League\CommonMark\Inline\Element\Text;
use League\CommonMark\ElementRendererInterface;
use League\CommonMark\Inline\Element\AbstractInline;
use League\CommonMark\Inline\Renderer\InlineRendererInterface;

class TextRenderer implements InlineRendererInterface
{
    /**
     * Should the text be escaped.
     *
     * @var bool
     */
    protected $safe;

    /**
     * TextRenderer constructor.
     *
     * @param bool $safe
     */
    public function __construct($safe = true)
    {
        $this->safe = $safe;
    }

    /**
     * Render the inline text element.
     *
     * @param \League\CommonMark\Inline\Element\Text      $inline
     * @param \League\CommonMark\ElementRendererInterface $htmlRenderer
     *
     * @return string
     */
    public function render(AbstractInline $inline, ElementRendererInterface $htmlRenderer)
    {
        if (!($inline instanceof Text)) {
            throw new \InvalidArgumentException('Incompatible inline type: ' . get_class($inline));
        }

        if ($this->safe) {
            return Xml::escape($inline->getContent());
        }

        return $inline->getContent();
    }
}
