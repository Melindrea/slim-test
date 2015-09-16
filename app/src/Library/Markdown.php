<?php

namespace Lees\Library;

use \Michelf\MarkdownExtra;
use \Michelf\SmartyPantsTypographer;

class Markdown
{
    public static function transform($text)
    {
        $html = SmartyPantsTypographer::defaultTransform(
            MarkdownExtra::defaultTransform($text)
        );
        $config = \HTMLPurifier_Config::createDefault();
        $purifier = new \HTMLPurifier($config);
        return $purifier->purify($html);
    }
}
