<?php

namespace CipeMotion\CommonMark;

use League\CommonMark\Environment;
use League\CommonMark\CommonMarkConverter;
use CipeMotion\CommonMark\Extension\Inline;

class Markdown
{
    /**
     * Get the markdown converter with the CipeMotion inline extension.
     *
     * @param bool $allowHtml
     *
     * @return \League\CommonMark\CommonMarkConverter
     */
    public static function getInlineConverter($allowHtml = false)
    {
        $environment = new Environment();

        $environment->addExtension(new Inline(!$allowHtml));

        return new CommonMarkConverter([
            'safe' => !$allowHtml,
        ], $environment);
    }
}
