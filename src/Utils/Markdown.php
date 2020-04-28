<?php
namespace App\Utils;

/**
 * There is showdown and some other libs
 * But we need something simple at first, so here we go.
 * This 
 * @author lpu8er
 */
class Markdown {
    use tFactory;
    
    /**
     * 
     * @param string $content
     * @return string
     */
    public static function instant(string $content): string {
        return static::factory()->parse($content);
    }
    
    /**
     * 
     * @param string $content
     * @param bool $alreadySanitized
     * @return string
     */
    public function parse(string $content, bool $alreadySanitized = false): string {
        if(!$alreadySanitized) { $content = htmlspecialchars($content); }
        // @TODO
        return $content;
    }
}
