<?php
declare(strict_types=1);

namespace Theme\Admin\ACFHelpers;

/**
 * Class TextField
 * @package Theme\Admin\ACFHelpers
 */
class TextField extends BaseField
{
    /**
     * TextField constructor.
     * @param string $key
     * @param string $name
     * @param string $instructions
     */
    public function __construct(string $key, string $name, string $instructions)
    {
        parent::__construct('text', $key, $name, $instructions);
    }
}