<?php

namespace CipeMotion\CommonMark\Extension;

use League\CommonMark as Core;
use League\CommonMark\Extension\CommonMark;
use League\CommonMark\Extension\ExtensionInterface;
use League\CommonMark\Node\Inline as InlineElement;
use League\CommonMark\Renderer\Block as BlockRenderer;
use League\CommonMark\Renderer\Inline as InlineRenderer;
use League\CommonMark\Environment\EnvironmentBuilderInterface;
use League\CommonMark\Extension\Strikethrough as StrikethroughExtension;
use CipeMotion\CommonMark\Delimiter\Processor\SingleCharacterDelimiterProcessor;

final class InlineExtension implements ExtensionInterface
{
    public function register(EnvironmentBuilderInterface $environment): void
    {
        $environment
            ->addInlineParser(new Core\Parser\Inline\NewlineParser, 200)
            ->addInlineParser(new CommonMark\Parser\Inline\BacktickParser, 150)
            ->addInlineParser(new CommonMark\Parser\Inline\EscapableParser, 80)
            ->addInlineParser(new CommonMark\Parser\Inline\EntityParser, 70)
            ->addInlineParser(new CommonMark\Parser\Inline\CloseBracketParser, 30)
            ->addInlineParser(new CommonMark\Parser\Inline\OpenBracketParser, 20)
            ->addRenderer(InlineElement\Text::class, new InlineRenderer\TextRenderer)
            ->addRenderer(InlineElement\Newline::class, new InlineRenderer\NewlineRenderer)
            ->addRenderer(Core\Node\Block\Document::class, new BlockRenderer\DocumentRenderer)
            ->addRenderer(Core\Node\Block\Paragraph::class, new BlockRenderer\ParagraphRenderer)
            ->addRenderer(CommonMark\Node\Inline\Code::class, new CommonMark\Renderer\Inline\CodeRenderer)
            ->addRenderer(CommonMark\Node\Inline\Link::class, new CommonMark\Renderer\Inline\LinkRenderer)
            ->addRenderer(CommonMark\Node\Inline\Strong::class, new CommonMark\Renderer\Inline\StrongRenderer)
            ->addRenderer(CommonMark\Node\Inline\Emphasis::class, new CommonMark\Renderer\Inline\EmphasisRenderer)
            ->addRenderer(StrikethroughExtension\Strikethrough::class, new StrikethroughExtension\StrikethroughRenderer)
            ->addDelimiterProcessor(new SingleCharacterDelimiterProcessor('_', CommonMark\Node\Inline\Emphasis::class))
            ->addDelimiterProcessor(new SingleCharacterDelimiterProcessor('*', CommonMark\Node\Inline\Strong::class))
            ->addDelimiterProcessor(new SingleCharacterDelimiterProcessor('~', StrikethroughExtension\Strikethrough::class));
    }
}
