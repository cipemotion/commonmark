<?php

use CipeMotion\CommonMark\Markdown;

class InlineCommonMarkTest extends PHPUnit_Framework_TestCase
{
    /**
     * The markdown converter.
     *
     * @var \League\CommonMark\CommonMarkConverter
     */
    protected $converter;

    /**
     * Setup the test environment.
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();

        $this->converter = Markdown::getInlineConverter();
    }

    public function testEmphasis()
    {
        $this->assertEquals(
            "<p>Simulise is <em>mega</em> awesome!</p>\n",
            $this->converter->convertToHtml('Simulise is _mega_ awesome!')
        );
    }

    public function testBold()
    {
        $this->assertEquals(
            "<p>Simulise is <strong>mega</strong> awesome!</p>\n",
            $this->converter->convertToHtml('Simulise is *mega* awesome!')
        );
    }

    public function testDel()
    {
        $this->assertEquals(
            "<p>Simulise is <del>mega</del> awesome!</p>\n",
            $this->converter->convertToHtml('Simulise is ~mega~ awesome!')
        );
    }

    public function testCode()
    {
        $this->assertEquals(
            "<p>Simulise is <code>\$code</code> awesome!</p>\n",
            $this->converter->convertToHtml('Simulise is `$code` awesome!')
        );
    }

    public function testLink()
    {
        $this->assertEquals(
            "<p>Simulise www.simulise.com/c_pag_h!</p>\n",
            $this->converter->convertToHtml('Simulise www.simulise.com/c_pag_h!')
        );

        $this->assertEquals(
            "<p>Simulise &lt;http://www.simulise.com/c_pag_h&gt;!</p>\n",
            $this->converter->convertToHtml('Simulise <http://www.simulise.com/c_pag_h>!')
        );
    }

    public function testCombined()
    {
        $this->assertEquals(
            "<p><del>Simulise</del> <em>has</em> <strong>awesome</strong> <code>\$code</code>!</p>\n",
            $this->converter->convertToHtml('~Simulise~ _has_ *awesome* `$code`!')
        );
    }

    public function testNewlines()
    {
        $this->assertEquals(
            "<p>Simulise\nis baller!</p>\n",
            $this->converter->convertToHtml("Simulise\nis baller!\n")
        );

        $this->assertEquals(
            "<p>Simulise</p>\n<p>is baller!</p>\n",
            $this->converter->convertToHtml("Simulise\n\nis baller!\n")
        );
    }

    public function testEscapedHtml()
    {
        $this->assertEquals(
            "<p>Simulise &lt;script&gt;alert('XSS');&lt;/script&gt;!</p>\n",
            $this->converter->convertToHtml('Simulise <script>alert(\'XSS\');</script>!')
        );
    }
}
