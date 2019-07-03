<?php
declare(strict_types=1);

namespace PomeloProductions\Admin\ACFHelpers\Fields;

use PomeloProductions\Admin\ACFHelpers\Traits\HasSubFieldsTrait;

/**
 * Class GroupField
 * @package PomeloProductions\Admin\ACFHelpers\Fields
 */
class GroupField extends BaseField
{
    use HasSubFieldsTrait;

    /**
     * GroupField constructor.
     * @param string $key
     * @param string $name
     * @param string $instructions
     */
    public function __construct(string $key, string $name, string $instructions)
    {
        parent::__construct('group', $key, $name, $instructions);
    }
}