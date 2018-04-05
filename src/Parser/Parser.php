<?php
/**
 * Created by PhpStorm.
 * User: genertorg
 * Date: 13/07/2017
 * Time: 12:16
 */

namespace Timr\BBCode\Parser;

class Parser
{
    /**
     * Static case insensitive flag to enable
     * case insensitivity when parsing BBCode.
     */
    const CASE_INSENSITIVE = 0;

    protected $parsers = [];

    protected function searchAndReplace(string $pattern, string $replace, string $source): string
    {
        while (preg_match($pattern, $source)) {
            $source = preg_replace($pattern, $replace, $source);
        }

        return $source;
    }

    protected function searchAndReplaceCallback(string $pattern, callable $callback, string $source): string
    {
        while (preg_match($pattern, $source)) {
            $source = preg_replace_callback($pattern, $callback, $source);
        }

        return $source;
    }

    public function only($only = null)
    {
        $only = is_array($only) ? $only : func_get_args();

        $this->parsers = array_intersect_key($this->parsers, array_flip((array) $only));

        return $this;
    }

    public function except($except = null)
    {
        $except = is_array($except) ? $except : func_get_args();

        $this->parsers = array_diff_key($this->parsers, array_flip((array) $except));

        return $this;
    }

    public function addParser(string $name, string $pattern, string $replace, string $content)
    {
        $this->parsers[$name] = [
            'type'    => 'normal',
            'pattern' => $pattern,
            'replace' => $replace,
            'content' => $content,
        ];
    }

    public function addCallbackParser(string $name, string $pattern, callable $callback, string $content)
    {
        $this->parsers[$name] = [
            'type'    => 'callback',
            'pattern' => $pattern,
            'callback' => $callback,
            'content' => $content
        ];
    }
}
