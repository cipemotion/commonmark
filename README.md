## CipeMotion CommonMark extensin

### Inline converter

Supports the following inline parsers:

- `_emphasis_` to `<em>emphasis</em>`
- `*bold*` to `<strong>bold</strong>`
- `~deleted~` to `<del>deleted</del>`
- `` `code` `` to `<code>code</code>`
- newlines to paragraphs
- stripping of html (optional)

### Usage

    $converter = \CipeMotion\CommonMark\Markdown::getInlineConverter();
    
    $html = $converter->convertToHtml('This is _awesome_!');
