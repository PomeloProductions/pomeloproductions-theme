<?php
declare(strict_types=1);

namespace Theme\Templates;

use Theme\Contracts\CanRenderContentContract;
use Theme\Theme;
use Theme\Traits\CanProcessContentTrait;
use Theme\Traits\InteractsWithOptionsTrait;
use WP_Post;

/**
 * Class BaseTemplate
 * @package Theme\Templates
 */
abstract class BaseTemplate implements CanRenderContentContract
{
    use CanProcessContentTrait, InteractsWithOptionsTrait;

    /**
     * @var Theme
     */
    protected $theme;

    /**
     * @var WP_Post
     */
    protected $page;

    /**
     * BaseTemplate constructor.
     * @param Theme $theme
     * @param WP_Post $page
     * @param $options
     */
    public function __construct(Theme $theme, WP_Post $page, $options)
    {
        $this->theme = $theme;
        $this->page = $page;
        $this->options = $options;
    }

    /**
     * Gets the slug for the page
     *
     * @return string
     */
    public function getSlug() : string
    {
        return $this->page->post_name;
    }

    /**
     * Override this and return false to
     *
     * @return bool
     */
    public function hasHeader(): bool
    {
        return true;
    }
}