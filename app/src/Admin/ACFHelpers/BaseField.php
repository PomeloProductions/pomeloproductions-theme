<?php
declare(strict_types=1);

namespace PomeloProductions\Admin\ACFHelpers;

/**
 * Class BaseField
 * @package Theme\Admin\ACFHelpers
 */
abstract class BaseField
{
    /**
     * @var string
     */
    private $type;

    /**
     * @var string
     */
    private $key;

    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $instructions;

    /**
     * @var bool
     */
    private $required = false;

    /**
     * @var string
     */
    private $defaultValue = '';

    /**
     * WYSIWYGField constructor.
     * @param string $type
     * @param string $key
     * @param string $name
     * @param string $instructions
     */
    public function __construct(string $type, string $key, string $name, string $instructions)
    {
        $this->type = $type;
        $this->key = $key;
        $this->name = $name;
        $this->instructions = $instructions;
    }

    /**
     * Sets the required variable
     *
     * @param bool $required
     * @return BaseField
     */
    public function setRequired(bool $required = true) : BaseField
    {
        $this->required = $required;
        return $this;
    }

    /**
     * Sets the default value and then returns the field
     *
     * @param string $defaultValue
     * @return BaseField
     */
    public function setDefaultValue(string $defaultValue) : BaseField
    {
        $this->defaultValue = $defaultValue;
        return $this;
    }

    /**
     * @return array
     */
    public function export()
    {
        return [
            'key' => $this->key,
            'label' => ucwords(str_replace('_', ' ', $this->name)),
            'name' => $this->name,
            'type' => $this->type,
            'instructions' => $this->instructions,
            'required' => $this->required,
            'conditional_logic' => 0,
            'wrapper' => [
                'width' => '',
                'class' => '',
                'id' => '',
            ],
            'default_value' => $this->defaultValue,
            'tabs' => 'all',
            'toolbar' => 'full',
            'media_upload' => 1,
            'delay' => 0,
        ];
    }
}