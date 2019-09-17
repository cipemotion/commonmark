<?php

namespace CipeMotion\CommonMark;

use League\CommonMark\Environment;
use League\CommonMark\CommonMarkConverter;
use CipeMotion\CommonMark\Extension\InlineExtension;

class Markdown
{
    /**
     * Get the markdown converter with the CipeMotion inline extension.
     *
     * @param bool $allowHtml
     *
     * @return \League\CommonMark\CommonMarkConverter
     */
    public static function getInlineConverter($allowHtml = false): CommonMarkConverter
    {
        $environment = new Environment;

        $environment->addExtension(new InlineExtension(!$allowHtml));

        return new CommonMarkConverter([
            'html_input' => $allowHtml ? 'allow' : 'strip',
        ], $environment);
    }
}
