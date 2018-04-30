<?php

namespace CipeMotion\CommonMark\Inline\Parser;

use League\CommonMark\Environment;
use League\CommonMark\Util\RegexHelper;
use League\CommonMark\Util\Configuration;
use League\CommonMark\Delimiter\Delimiter;
use League\CommonMark\Inline\Element\Text;
use League\CommonMark\InlineParserContext;
use League\CommonMark\EnvironmentAwareInterface;
use League\CommonMark\Inline\Parser\AbstractInlineParser;

class EmphasisParser extends AbstractInlineParser implements EnvironmentAwareInterface
{
    /**
     * The configuration.
     *
     * @var \League\CommonMark\Util\Configuration
     */
    protected $config;

    /**
     * EmphasisParser constructor.
     *
     * @param array $newConfig
     */
    public function __construct(array $newConfig = [])
    {
        $this->config = new Configuration([
            'use_tilde'      => true,
            'use_asterisk'   => true,
            'use_underscore' => true,
            'enable_em'      => true,
            'enable_del'     => true,
            'enable_strong'  => true,
        ]);
        $this->config->mergeConfig($newConfig);
    }

    /**
     * Set the environment.
     *
     * @param \League\CommonMark\Environment $environment
     */
    public function setEnvironment(Environment $environment)
    {
        $this->config->mergeConfig($environment->getConfig());
    }

    /**
     * Get the characters we are matching for.
     *
     * @return string[]
     */
    public function getCharacters()
    {
        if (!$this->config->getConfig('enable_em') &&
            !$this->config->getConfig('enable_del') &&
            !$this->config->getConfig('enable_strong')
        ) {
            return [];
        }

        $chars = [];

        if ($this->config->getConfig('use_tilde')) {
            $chars[] = '~';
        }

        if ($this->config->getConfig('use_asterisk')) {
            $chars[] = '*';
        }

        if ($this->config->getConfig('use_underscore')) {
            $chars[] = '_';
        }

        return $chars;
    }

    /**
     * @param InlineParserContext $inlineContext
     *
     * @return bool
     */
    public function parse(InlineParserContext $inlineContext)
    {
        $character = $inlineContext->getCursor()->getCharacter();

        if (!in_array($character, $this->getCharacters())) {
            return false;
        }

        $numDelims  = 0;
        $cursor     = $inlineContext->getCursor();
        $charBefore = $cursor->peek(-1);

        if ($charBefore === null) {
            $charBefore = "\n";
        }

        while ($cursor->peek($numDelims) === $character) {
            ++$numDelims;
        }

        // Skip single delims if emphasis is disabled
        if ($numDelims === 1 && !$this->config->getConfig('enable_em')) {
            return false;
        }

        $cursor->advanceBy($numDelims);

        $charAfter = $cursor->getCharacter();
        if ($charAfter === null) {
            $charAfter = "\n";
        }

        $afterIsWhitespace   = preg_match('/\pZ|\s/u', $charAfter);
        $afterIsPunctuation  = preg_match(RegexHelper::REGEX_PUNCTUATION, $charAfter);
        $beforeIsWhitespace  = preg_match('/\pZ|\s/u', $charBefore);
        $beforeIsPunctuation = preg_match(RegexHelper::REGEX_PUNCTUATION, $charBefore);

        $leftFlanking = $numDelims > 0 && !$afterIsWhitespace &&
                        !($afterIsPunctuation &&
                          !$beforeIsWhitespace &&
                          !$beforeIsPunctuation);

        $rightFlanking = $numDelims > 0 && !$beforeIsWhitespace &&
                         !($beforeIsPunctuation &&
                           !$afterIsWhitespace &&
                           !$afterIsPunctuation);

        if ($character === '_') {
            $canOpen  = $leftFlanking && (!$rightFlanking || $beforeIsPunctuation);
            $canClose = $rightFlanking && (!$leftFlanking || $afterIsPunctuation);
        } else {
            $canOpen  = $leftFlanking;
            $canClose = $rightFlanking;
        }

        $node = new Text($cursor->getPreviousText(), [
            'delim'           => true,
            'emphasis_config' => $this->config,
        ]);
        $inlineContext->getContainer()->appendChild($node);

        // Add entry to stack to this opener
        $delimiter = new Delimiter($character, $numDelims, $node, $canOpen, $canClose);
        $inlineContext->getDelimiterStack()->push($delimiter);

        return true;
    }
}
