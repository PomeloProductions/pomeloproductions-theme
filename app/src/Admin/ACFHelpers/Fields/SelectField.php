<?php
declare(strict_types=1);

namespace PomeloProductions\Admin\ACFHelpers\Fields;

/**
 * Class SelectField
 * @package PomeloProductions\Admin\ACFHelpers\Fields
 */
class SelectField extends BaseField
{
    /**
     * @var array
     */
    private $choices;

    /**
     * @var string
     */
    private $returnValue;

    /**
     * SelectField constructor.
     * @param string $key
     * @param string $name
     * @param string $instructions
     * @param array $choices
     */
    public function __construct(string $key, string $name, string $instructions, array $choices)
    {
        parent::__construct('select', $key, $name, $instructions);
        $this->choices = $choices;
    }

    /**
     * Sets the return value format this field will send back
     *
     * @param string $returnValue
     * @return SelectField
     */
    public function setReturnValue(string $returnValue): SelectField
    {
        $this->returnValue = $returnValue;
        return $this;
    }

    /**
     * Makes sure to set the custom config needed for a select field
     *
     * @return array
     */
    public function export(): array
    {
        $config = parent::export();

        $config['return_value'] = $this->returnValue;
        $config['choices'] = $this->choices;

        return $config;
    }
}