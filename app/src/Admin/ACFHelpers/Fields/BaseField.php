<?php
declare(strict_types=1);

namespace PomeloProductions\Admin\ACFHelpers\Fields;

use PomeloProductions\Contracts\IsACFFieldContract;

/**
 * Class BaseField
 * @package Theme\Admin\ACFHelpers\Fields
 */
abstract class BaseField implements IsACFFieldContract
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
    private $allowNull = true;

    /**
     * @var bool
     */
    private $required = false;

    /**
     * @var null|array
     */
    private $conditionalLogic = null;

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
     * @return BaseField|static
     */
    public function setRequired(bool $required = true) : BaseField
    {
        $this->required = $required;
        return $this;
    }

    /**
     * Sets whether or not this field can be set to null
     *
     * @param bool $allowNull
     * @return BaseField|static
     */
    public function setAllowNull(bool $allowNull = true): BaseField
    {
        $this->allowNull = $allowNull;
        return $this;
    }

    /**
     * @param array|null $conditionalLogic
     * @return BaseField
     */
    public function setConditionalLogic(?array $conditionalLogic): BaseField
    {
        $this->conditionalLogic = $conditionalLogic;
        return $this;
    }

    /**
     * Sets the default value and then returns the field
     *
     * @param string $defaultValue
     * @return BaseField|static
     */
    public function setDefaultValue(string $defaultValue) : BaseField
    {
        $this->defaultValue = $defaultValue;
        return $this;
    }

    /**
     * @return array
     */
    public function export(): array
    {
        return [
            'key' => $this->key,
            'label' => ucwords(str_replace('_', ' ', $this->name)),
            'name' => $this->name,
            'type' => $this->type,
            'instructions' => $this->instructions,
            'required' => $this->required,
            'conditional_logic' => $this->conditionalLogic,
            'wrapper' => [
                'width' => '',
                'class' => '',
                'id' => '',
            ],
            'default_value' => $this->defaultValue,
            'allow_null' => $this->allowNull,
            'tabs' => 'all',
            'toolbar' => 'full',
            'media_upload' => 1,
            'delay' => 0,
        ];
    }
}