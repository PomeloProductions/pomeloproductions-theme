<?php
declare(strict_types=1);

namespace PomeloProductions;

use PomeloProductions\Admin\RootController;
use PomeloProductions\Templates\BaseTemplate;
use WP_Post;

/**
 * Class ChildTheme
 * @package PomeloProductions
 */
abstract class ChildTheme
{
    /**
     * @var Theme
     */
    private $theme;

    /**
     * ChildTheme constructor.
     * @param Theme $theme
     */
    public function __construct(Theme $theme)
    {
        $this->theme = $theme;
    }

    /**
     * Builds a page template or returns null if the child theme wants the parent theme to handle it
     *
     * @param WP_Post $page
     * @return BaseTemplate|null
     */
    public abstract function buildPageTemplate(WP_Post $page) : ?BaseTemplate;

    /**
     * Runs when the scripts are registered. Returns true if everything is registered,
     * or false if the parent theme should continue registering scripts
     *
     * @return bool
     */
    public function registerScripts(): bool
    {
        return false;
    }
    /**
     * Registers any admin things needed
     */
    public abstract function registerAdmin();
}