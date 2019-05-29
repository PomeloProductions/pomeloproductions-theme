<?php
declare(strict_types=1);

namespace Theme\Admin\ACFHelpers;

/**
 * Class WYSIWYGField
 * @package Theme\Admin\ACFHelpers
 */
class WYSIWYGField extends BaseField
{
    /**
     * WYSIWYGField constructor.
     * @param string $key
     * @param string $name
     * @param string $instructions
     */
    public function __construct(string $key, string $name, string $instructions)
    {
        parent::__construct('wysiwyg', $key, $name, $instructions);
    }
}