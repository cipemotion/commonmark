<?php

namespace CipeMotion\CommonMark\Extension;

use League\CommonMark\Block\Parser as BlockParser;
use League\CommonMark\Inline\Parser as InlineParser;
use League\CommonMark\Block\Renderer as BlockRenderer;
use League\CommonMark\Inline\Renderer as InlineRenderer;
use League\CommonMark\Inline\Processor as InlineProcessor;
use League\CommonMark\Extension\Extension as CommonmarkExtension;
use CipeMotion\CommonMark\Inline\Parser as CipeMotionInlineParser;
use CipeMotion\CommonMark\Inline\Renderer as CipeMotionInlineRenderer;
use CipeMotion\CommonMark\Inline\Processor as CipeMotionInlineProcessor;

class Inline extends CommonmarkExtension
{
    /**
     * Should we render safely.
     *
     * @var bool
     */
    protected $safe;

    /**
     * Inline constructor.
     *
     * @param bool $safe
     */
    public function __construct($safe = true)
    {
        $this->safe = $safe;
    }

    /**
     * Returns a list of block renderers to add to the existing list.
     *
     * The list keys are the block class names which the corresponding value (renderer) will handle.
     *
     * @return BlockRenderer\BlockRendererInterface[]
     */
    public function getBlockRenderers()
    {
        return [
            'League\CommonMark\Block\Element\Document'  => new BlockRenderer\DocumentRenderer(),
            'League\CommonMark\Block\Element\Paragraph' => new BlockRenderer\ParagraphRenderer(),
        ];
    }

    /**
     * Returns a list of inline parsers to add to the existing list.
     *
     * @return InlineParser\InlineParserInterface[]
     */
    public function getInlineParsers()
    {
        return [
            new InlineParser\NewlineParser(),
            new InlineParser\BacktickParser(),
            new InlineParser\EscapableParser(),
            new InlineParser\EntityParser(),
            new CipeMotionInlineParser\EmphasisParser(),
            new InlineParser\CloseBracketParser(),
            new InlineParser\OpenBracketParser(),
        ];
    }

    /**
     * Returns a list of inline processors to add to the existing list.
     *
     * @return InlineProcessor\InlineProcessorInterface[]
     */
    public function getInlineProcessors()
    {
        return [
            new CipeMotionInlineProcessor\EmphasisProcessor(),
        ];
    }

    /**
     * Returns a list of inline renderers to add to the existing list.
     *
     * The list keys are the inline class names which the corresponding value (renderer) will handle.
     *
     * @return InlineRenderer\InlineRendererInterface[]
     */
    public function getInlineRenderers()
    {
        return [
            'League\CommonMark\Inline\Element\Code'     => new InlineRenderer\CodeRenderer(),
            'League\CommonMark\Inline\Element\Emphasis' => new InlineRenderer\EmphasisRenderer(),
            'League\CommonMark\Inline\Element\Image'    => new InlineRenderer\LinkRenderer(),
            'League\CommonMark\Inline\Element\Link'     => new InlineRenderer\LinkRenderer(),
            'League\CommonMark\Inline\Element\Newline'  => new InlineRenderer\NewlineRenderer(),
            'League\CommonMark\Inline\Element\Strong'   => new InlineRenderer\StrongRenderer(),
            'CipeMotion\CommonMark\Inline\Element\Del'  => new CipeMotionInlineRenderer\DelRenderer(),
            'League\CommonMark\Inline\Element\Text'     => new CipeMotionInlineRenderer\TextRenderer($this->safe),
        ];
    }

    /**
     * Returns the name of the extension
     *
     * @return string
     */
    public function getName()
    {
        return 'cipemotion-inline';
    }
}
