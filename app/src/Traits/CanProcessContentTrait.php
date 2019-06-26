<?php
declare(strict_types=1);

namespace PomeloProductions\Traits;

/**
 * Trait CanProcessContentTrait
 * @package Theme\Traits
 */
trait CanProcessContentTrait
{
    /**
     * Processes a content string properly for output
     *
     * @param string $content
     * @return string
     */
    public function processContentString(string $content) : string
    {
        return do_shortcode(apply_filters('the_content', $content));
    }
}