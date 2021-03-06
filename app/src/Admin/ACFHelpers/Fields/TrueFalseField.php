<?php
declare(strict_types=1);

namespace PomeloProductions\Admin\ACFHelpers\Fields;

/**
 * Class TrueFalseField
 * @package Theme\Admin\ACFHelpers\Fields
 */
class TrueFalseField extends BaseField
{
    /**
     * TrueFalseField constructor.
     * @param string $key
     * @param string $name
     * @param string $instructions
     */
    public function __construct(string $key, string $name, string $instructions)
    {
        parent::__construct('true_false', $key, $name, $instructions);
    }

    /**
     * @return array
     */
    public function export(): array
    {
        $config = parent::export();

        $config['ui'] = 1;

        return $config;
    }
}