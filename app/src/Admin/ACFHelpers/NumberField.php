<?php
declare(strict_types=1);

namespace Theme\Admin\ACFHelpers;

/**
 * Class NumberField
 * @package Theme\Admin\ACFHelpers
 */
class NumberField extends BaseField
{
    /**
     * NumberField constructor.
     * @param string $key
     * @param string $name
     * @param string $instructions
     */
    public function __construct(string $key, string $name, string $instructions)
    {
        parent::__construct('number', $key, $name, $instructions);
    }
}