<?php
declare(strict_types=1);

namespace PomeloProductions\Admin\ACFHelpers\Fields;

/**
 * Class WYSIWYGField
 * @package Theme\Admin\ACFHelpers\Fields
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

    /**
     * Makes sure to set media upload to true
     *
     * @return array
     */
    public function export(): array
    {
        $config = parent::export();

        $config['media_upload'] = true;

        return $config;
    }
}