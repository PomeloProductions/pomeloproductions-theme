<?php
declare(strict_types=1);

namespace Theme\Navigation;

/**
 * Class Main
 * @package Theme\Navigation
 */
class Main extends BaseNavigation
{
    /**
     * Main constructor.
     */
    public function __construct()
    {
        parent::__construct('main', 'Main Navigation');
    }
}