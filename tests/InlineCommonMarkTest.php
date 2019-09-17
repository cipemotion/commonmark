<?php

use PHPUnit\Framework\TestCase;
use CipeMotion\CommonMark\Markdown;

class InlineCommonMarkTest extends TestCase
{
    public function caseProvider(): array
    {
        return [
            [
                'Simulise is _mega_ awesome!',
                "<p>Simulise is <em>mega</em> awesome!</p>\n",
            ],
            [
                'Simulise is *mega* awesome!',
                "<p>Simulise is <strong>mega</strong> awesome!</p>\n",
            ],
            [
                'Simulise is ~mega~ awesome!',
                "<p>Simulise is <del>mega</del> awesome!</p>\n",
            ],
            [
                'Simulise is `$code` awesome!',
                "<p>Simulise is <code>\$code</code> awesome!</p>\n",
            ],
            [
                'Simulise [site](www.simulise.com/c_pag_h)!',
                "<p>Simulise <a href=\"www.simulise.com/c_pag_h\">site</a>!</p>\n",
            ],
            [
                'Simulise [site](https://www.simulise.com/c_pag_h)!',
                "<p>Simulise <a href=\"https://www.simulise.com/c_pag_h\">site</a>!</p>\n",
            ],
            [
                'Simulise ![site](www.simulise.com/c_pag_h)!',
                "<p>Simulise !<a href=\"www.simulise.com/c_pag_h\">site</a>!</p>\n",
            ],
            [
                'Simulise www.simulise.com/c_pag_h!',
                "<p>Simulise www.simulise.com/c_pag_h!</p>\n",
            ],
            [
                'Simulise <http://www.simulise.com/c_pag_h>!',
                "<p>Simulise &lt;http://www.simulise.com/c_pag_h&gt;!</p>\n",
            ],
            [
                '~Simulise~ _has_ *awesome* `$code`!',
                "<p><del>Simulise</del> <em>has</em> <strong>awesome</strong> <code>\$code</code>!</p>\n",
            ],
            [
                "Simulise\nis baller!\n",
                "<p>Simulise\nis baller!</p>\n",
            ],
            [
                "Simulise\n\nis baller!\n",
                "<p>Simulise</p>\n<p>is baller!</p>\n",
            ],
            [
                'Simulise <script>alert(\'XSS\');</script>!',
                "<p>Simulise &lt;script&gt;alert('XSS');&lt;/script&gt;!</p>\n",
            ],
        ];
    }

    /** @dataProvider caseProvider */
    public function test_custom_inline_converter(string $markdown, string $expected)
    {
        $converter = Markdown::getInlineConverter();

        $this->assertEquals($expected, $converter->convertToHtml($markdown));
    }
}
