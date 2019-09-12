<?php
declare(strict_types=1);

namespace PomeloProductions;

use Handlebars\Handlebars;
use Handlebars\Loader\FilesystemLoader;
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
    protected $theme;

    /**
     * @var Handlebars
     */
    public $templateEngine;

    /**
     * ChildTheme constructor.
     * @param Theme $theme
     */
    public function __construct(Theme $theme)
    {
        $this->theme = $theme;
        $this->templateEngine = new Handlebars([
            'loader' => new FilesystemLoader($this->getTemplatesDirectory()),
            'partials_loader' => new FilesystemLoader($this->getTemplatesDirectory() . '/partials')
        ]);
    }

    /**
     * Builds a page template or returns null if the child theme wants the parent theme to handle it
     *
     * @param WP_Post $page
     * @param $options
     * @return BaseTemplate|null
     */
    public abstract function buildPageTemplate(WP_Post $page, $options) : ?BaseTemplate;

    /**
     * Gets the template directory for the child theme
     *
     * @return string
     */
    public abstract function getTemplatesDirectory() : string;

    /**
     * Allows child themes to modify header variables in any ways
     *
     * @param array $headerVariables
     * @return array
     */
    public function filterHeaderVariables(array $headerVariables): array
    {
        return $headerVariables;
    }

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
     * Allows a child theme to customize the branding line throughout the site
     */
    public function getBrandingName(): ?string
    {
        return null;
    }

    /**
     * Allows the child thing to insert child theme social media links if they want
     *
     * @return string|null
     */
    public function getChildThemeSocialMediaLinks(): ?string
    {
        return null;
    }

    /**
     * Registers any admin things needed
     */
    public abstract function registerAdmin();
}