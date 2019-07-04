<?php
declare(strict_types=1);

namespace PomeloProductions\Admin\ACFHelpers\Fields;

use PomeloProductions\Admin\ACFHelpers\Traits\HasSubFieldsTrait;

/**
 * Class RepeaterField
 * @package PomeloProductions\Admin\ACFHelpers\Fields
 */
class RepeaterField extends BaseField
{
    use HasSubFieldsTrait {
        export as exportSubFields;
    }

    /**
     * @var string
     */
    private $collapsedKey;

    /**
     * GroupField constructor.
     * @param string $key
     * @param string $name
     * @param string $instructions
     */
    public function __construct(string $key, string $name, string $instructions)
    {
        parent::__construct('repeater', $key, $name, $instructions);
    }

    /**
     * @param string $collapsedKey
     * @return RepeaterField
     */
    public function setCollapsedKey(string $collapsedKey): RepeaterField
    {
        $this->collapsedKey = $collapsedKey;
        return $this;
    }

    /**
     * @return array
     */
    public function export(): array
    {
        $config = $this->exportSubFields();

        $config['collapsed'] = $this->collapsedKey;

        $config['min'] = 0;
        $config['max'] = 0;

        return $config;
    }
}