<?php
/**
 * Created by PhpStorm.
 * User: genertorg
 * Date: 13/07/2017
 * Time: 13:20
 */

namespace Timr\BBCode\Parser;

final class BBCodeParser extends Parser
{
    protected $parsers = [
        'bold' => [
            'type'    => 'normal',
            'pattern' => '/\[b\](.*?)\[\/b\]/s',
            'replace' => '<b>$1</b>',
            'content' => '$1'
        ],
        'italic' => [
            'type'    => 'normal',
            'pattern' => '/\[i\](.*?)\[\/i\]/s',
            'replace' => '<i>$1</i>',
            'content' => '$1'
        ],
        'underline' => [
            'type'    => 'normal',
            'pattern' => '/\[u\](.*?)\[\/u\]/s',
            'replace' => '<u>$1</u>',
            'content' => '$1'
        ],
        'linethrough' => [
            'type'    => 'normal',
            'pattern' => '/\[s\](.*?)\[\/s\]/s',
            'replace' => '<s>$1</s>',
            'content' => '$1'
        ],
        'quote' => [
            'type'    => 'normal',
            'pattern' => '/\[quote\](.*?)\[\/quote\]/s',
            'replace' => '<blockquote>$1</blockquote>',
            'content' => '$1'
        ],
        'link' => [
            'type'    => 'normal',
            'pattern' => '/\[url\](.*?)\[\/url\]/s',
            'replace' => '<a href="$1">$1</a>',
            'content' => '$1'
        ],
        'namedlink' => [
            'type'    => 'normal',
            'pattern' => '/\[url\=(.*?)\](.*?)\[\/url\]/s',
            'replace' => '<a href="$1">$2</a>',
            'content' => '$2'
        ],
        'image' => [
            'type'    => 'normal',
            'pattern' => '/\[img\](.*?)\[\/img\]/s',
            'replace' => '<img src="$1">',
            'content' => '$1'
        ],
        'orderedlistnumerical' => [
            'type'    => 'normal',
            'pattern' => '/\[list=1\](.*?)\[\/list\]/s',
            'replace' => '<ol>$1</ol>',
            'content' => '$1'
        ],
        'orderedlistalpha' => [
            'type'    => 'normal',
            'pattern' => '/\[list=a\](.*?)\[\/list\]/s',
            'replace' => '<ol type="a">$1</ol>',
            'content' => '$1'
        ],
        'unorderedlist' => [
            'type'    => 'normal',
            'pattern' => '/\[list\](.*?)\[\/list\]/s',
            'replace' => '<ul>$1</ul>',
            'content' => '$1'
        ],
        'listitem' => [
            'type'    => 'normal',
            'pattern' => '/\[\*\](.*)/',
            'replace' => '<li>$1</li>',
            'content' => '$1'
        ],
        'code' => [
            'type'    => 'normal',
            'pattern' => '/\[code\](.*?)\[\/code\]/s',
            'replace' => '<code>$1</code>',
            'content' => '$1'
        ],
        'youtube' => [
            'type'    => 'normal',
            'pattern' => '/\[youtube\](.*?)\[\/youtube\]/s',
            'replace' => '<iframe width="560" height="315" src="//www.youtube.com/embed/$1" frameborder="0" allowfullscreen></iframe>',
            'content' => '$1'
        ],
        'sub' => [
            'type'    => 'normal',
            'pattern' => '/\[sub\](.*?)\[\/sub\]/s',
            'replace' => '<sub>$1</sub>',
            'content' => '$1'
        ],
        'sup' => [
            'type'    => 'normal',
            'pattern' => '/\[sup\](.*?)\[\/sup\]/s',
            'replace' => '<sup>$1</sup>',
            'content' => '$1'
        ],
        'small' => [
            'type'    => 'normal',
            'pattern' => '/\[small\](.*?)\[\/small\]/s',
            'replace' => '<small>$1</small>',
            'content' => '$1'
        ]
    ];

    public function stripTags(string $source): string
    {
        foreach ($this->parsers as $name => $parser) {
            $source = $this->searchAndReplace($parser['pattern'] . 'i', $parser['content'], $source);
        }

        return $source;
    }

    public function parse(string $source, $caseInsensitive = null): string
    {
        $caseInsensitive = $caseInsensitive === self::CASE_INSENSITIVE ? true : false;

        foreach ($this->parsers as $name => $parser) {
            $pattern = ($caseInsensitive) ? $parser['pattern'] . 'i' : $parser['pattern'];

            if($parser['type'] == 'normal') {
                $source = $this->searchAndReplace($pattern, $parser['replace'], $source);
            } elseif($parser['type'] == 'callback') {
                $source = $this->searchAndReplaceCallback($pattern, $parser['callback'], $source);
            }
        }

        return $source;
    }
}
