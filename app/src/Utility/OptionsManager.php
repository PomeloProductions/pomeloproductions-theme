<?php
declare(strict_types=1);

namespace Theme\Utility;

/**
 * Class OptionsManager
 * @package Theme\Utility
 */
class OptionsManager
{
    /**
     * The name for the array of options saved in the database
     */
    const OPTION_PREFIX = 'pomelo_options';

    /**
     * The loaded theme options
     * @var array
     */
    private $themeOptions;

    /**
     * OptionManager constructor.
     */
    public function __construct()
    {
        $this->themeOptions = get_option(static::OPTION_PREFIX);
    }

    /**
     * @param $name
     * @return array|string|null
     */
    public function getOption($name)
    {
        return $this->themeOptions[$name] ?? null;
    }
}