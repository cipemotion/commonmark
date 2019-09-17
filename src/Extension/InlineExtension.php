<?php

namespace CipeMotion\CommonMark\Extension;

use League\CommonMark\Extension\ExtensionInterface;
use League\CommonMark\Block\Element as BlockElement;
use League\CommonMark\Inline\Parser as InlineParser;
use League\CommonMark\Block\Renderer as BlockRenderer;
use League\CommonMark\Inline\Element as InlineElement;
use League\CommonMark\ConfigurableEnvironmentInterface;
use League\CommonMark\Inline\Renderer as InlineRenderer;
use CipeMotion\CommonMark\Inline\Element as CustomElement;
use CipeMotion\CommonMark\Inline\Renderer as CustomRenderer;
use CipeMotion\CommonMark\Inline\Processor as CustomProcessor;

final class InlineExtension implements ExtensionInterface
{
    /**
     * Should we render safely and strip out any HTML.
     *
     * @var bool
     */
    protected $safe;

    /**
     * InlineExtension constructor.
     *
     * @param bool $safe
     */
    public function __construct($safe = true)
    {
        $this->safe = $safe;
    }

    /**
     * {@inheritDoc}
     */
    public function register(ConfigurableEnvironmentInterface $environment): void
    {
        $environment->setConfig([
            'html_input' => $this->safe ? 'strip' : 'allow',
        ]);

        // Add included elements and renderers
        $environment
            ->addBlockRenderer(BlockElement\Document::class, new BlockRenderer\DocumentRenderer)
            ->addBlockRenderer(BlockElement\Paragraph::class, new BlockRenderer\ParagraphRenderer)
            ->addInlineParser(new InlineParser\EntityParser)
            ->addInlineParser(new InlineParser\EscapableParser)
            ->addInlineParser(new InlineParser\NewlineParser)
            ->addInlineParser(new InlineParser\BacktickParser)
            ->addInlineParser(new InlineParser\OpenBracketParser)
            ->addInlineParser(new InlineParser\CloseBracketParser)
            ->addInlineRenderer(InlineElement\Newline::class, new InlineRenderer\NewlineRenderer)
            ->addInlineRenderer(InlineElement\Code::class, new InlineRenderer\CodeRenderer)
            ->addInlineRenderer(InlineElement\Link::class, new InlineRenderer\LinkRenderer)
            ->addInlineRenderer(InlineElement\Strong::class, new InlineRenderer\StrongRenderer)
            ->addInlineRenderer(InlineElement\Text::class, new InlineRenderer\TextRenderer)
            ->addInlineRenderer(InlineElement\Emphasis::class, new InlineRenderer\EmphasisRenderer);

        // Add custom elements en renderers
        $environment
            ->addDelimiterProcessor(new CustomProcessor\DelDelimiter)
            ->addDelimiterProcessor(new CustomProcessor\BoldDelimiter)
            ->addDelimiterProcessor(new CustomProcessor\EmphasisDelimiter)
            ->addInlineRenderer(CustomElement\Del::class, new CustomRenderer\Del);
    }
}
