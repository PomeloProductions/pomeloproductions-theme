<?php
declare(strict_types=1);

namespace Theme\Navigation;

/**
 * Class Footer
 * @package Theme\Navigation
 */
class Footer extends BaseNavigation
{
    /**
     * Footer constructor.
     */
    public function __construct()
    {
        parent::__construct('footer', 'Footer Navigation');
    }
}