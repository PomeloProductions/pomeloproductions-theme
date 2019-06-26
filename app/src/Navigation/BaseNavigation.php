<?php
declare(strict_types=1);

namespace PomeloProductions\Navigation;

/**
 * Class BaseNavigation
 * @package Theme\Navigation
 */
abstract class BaseNavigation
{
    /**
     * @var string the name of this navigation internally
     */
    private $name;

    /**
     * @var string the name that will be shown to the user
     */
    private $displayName;

    /**
     * @var \WP_Post[]
     */
    private $navigationItems;

    /**
     * BaseNavigation constructor.
     * @param string $name
     * @param string $displayName
     */
    public function __construct(string $name, string $displayName)
    {
        $this->name = $name;
        $this->displayName = $displayName;
    }

    /**
     * Internally registers the navigation menu
     */
    public function registrationNavigation()
    {
        register_nav_menu($this->name, $this->displayName);
    }

    /**
     * @return \WP_Post[] the navigation items in the main menu
     */
    public function getNavigationItems()
    {
        if ($this->navigationItems == null) {

            $navigationLocations = get_nav_menu_locations();

            $this->navigationItems = wp_get_nav_menu_items($navigationLocations[$this->name]);
        }

        return $this->navigationItems;
    }
}