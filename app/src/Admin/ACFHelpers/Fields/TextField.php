<?php
declare(strict_types=1);

namespace PomeloProductions\Admin\ACFHelpers\Fields;

/**
 * Class TextField
 * @package Theme\Admin\ACFHelpers\Fields
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