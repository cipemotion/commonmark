<?php

namespace CipeMotion\CommonMark;

use League\CommonMark\Util\HtmlFilter;
use League\CommonMark\MarkdownConverter;
use League\CommonMark\Environment\Environment;
use CipeMotion\CommonMark\Extension\InlineExtension;

class Markdown
{
    /**
     * Get the markdown converter with the CipeMotion inline extension.
     *
     * @param bool $allowHtml
     *
     * @return \League\CommonMark\MarkdownConverter
     */
    public static function getInlineConverter(bool $allowHtml = false): MarkdownConverter
    {
        $environment = new Environment([
            'html_input' => $allowHtml ? HtmlFilter::ALLOW : HtmlFilter::STRIP,
        ]);

        $environment->addExtension(new InlineExtension);

        return new MarkdownConverter($environment);
    }
}
