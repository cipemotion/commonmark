## CipeMotion CommonMark extension

### Inline converter

The inline syntax is meant for using quick markup in text settings like comments where it doesn't make sense to have a full wysiwig editor but you do want to provide some formatting options to the user using markdown syntax.

Supports the following inline syntax:

- `_emphasis_` to `<em>emphasis</em>`
- `*bold*` to `<strong>bold</strong>`
- `~deleted~` to `<del>deleted</del>`
- `` `code` `` to `<code>code</code>`
- `[link](https://url)` to `<a href="https://url">link</a>`
- `![link](https://url)` to `!<a href="https://url">link</a>` (images are disabled)
- newlines to paragraphs
- stripping of html (can be disabled to allow HTML)

### Usage

```php
// When `$allowHtml` is `true` HTML is _not_ removed in the output, default is false
$converter = \CipeMotion\CommonMark\Markdown::getInlineConverter($allowHtml);

$html = $converter->convertToHtml('This is _awesome_!')->getContent();
// or
$html = (string)$converter->convertToHtml('This is _awesome_!');
```
