<?php
declare(strict_types=1);

namespace PomeloProductions\Admin\ACFHelpers\Fields;

/**
 * Class ColorPickerField
 * @package Theme\Admin\ACFHelpers\Fields
 */
class ColorPickerField extends BaseField
{
    /**
     * ColorPickerField constructor.
     * @param string $key
     * @param string $name
     * @param string $instructions
     */
    public function __construct(string $key, string $name, string $instructions)
    {
        parent::__construct('extended-color-picker', $key, $name, $instructions);
    }
}