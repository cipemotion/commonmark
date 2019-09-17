<?php

namespace CipeMotion\CommonMark\Inline\Renderer;

use League\CommonMark\HtmlElement;
use League\CommonMark\ElementRendererInterface;
use League\CommonMark\Inline\Element\AbstractInline;
use CipeMotion\CommonMark\Inline\Element\Del as DelElement;
use League\CommonMark\Inline\Renderer\InlineRendererInterface;

class Del implements InlineRendererInterface
{
    /**
     * Render the `del` element.
     *
     * @param DelElement               $inline
     * @param ElementRendererInterface $htmlRenderer
     *
     * @return HtmlElement
     */
    public function render(AbstractInline $inline, ElementRendererInterface $htmlRenderer)
    {
        if (!($inline instanceof DelElement)) {
            throw new \InvalidArgumentException('Incompatible inline type: ' . \get_class($inline));
        }

        $attrs = $inline->getData('attributes', []);

        return new HtmlElement('del', $attrs, $htmlRenderer->renderInlines($inline->children()));
    }
}
