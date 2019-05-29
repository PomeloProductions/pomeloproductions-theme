<?php
declare(strict_types=1);

namespace Theme\Traits;

/**
 * Trait InteractsWithOptionsTrait
 * @package Theme\Traits
 */
trait InteractsWithOptionsTrait
{
    /**
     * @var array
     */
    protected $options = [];

    /**
     * Gets an option for this post based on the name passed in
     *
     * @param $optionName
     * @param $default
     * @return mixed
     */
    public function getOption($optionName, $default)
    {
        return $this->options[$optionName] ?? $default;
    }
}