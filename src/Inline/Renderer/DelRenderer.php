<?php

namespace CipeMotion\CommonMark\Inline\Renderer;

use League\CommonMark\Util\Xml;
use League\CommonMark\HtmlElement;
use CipeMotion\CommonMark\Inline\Element\Del;
use League\CommonMark\ElementRendererInterface;
use League\CommonMark\Inline\Element\AbstractInline;
use League\CommonMark\Inline\Renderer\InlineRendererInterface;

class DelRenderer implements InlineRendererInterface
{
    /**
     * Render the del.
     *
     * @param \CipeMotion\CommonMark\Inline\Element\Del   $inline
     * @param \League\CommonMark\ElementRendererInterface $htmlRenderer
     *
     * @return \League\CommonMark\HtmlElement
     */
    public function render(AbstractInline $inline, ElementRendererInterface $htmlRenderer)
    {
        if (!($inline instanceof Del)) {
            throw new \InvalidArgumentException('Incompatible inline type: ' . get_class($inline));
        }

        $attrs = [];

        foreach ($inline->getData('attributes', []) as $key => $value) {
            $attrs[$key] = Xml::escape($value, true);
        }

        return new HtmlElement('del', $attrs, $htmlRenderer->renderInlines($inline->children()));
    }
}
