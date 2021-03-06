<?php
declare(strict_types=1);

namespace PomeloProductions\Admin\ACFHelpers\Traits;

use PomeloProductions\Contracts\IsACFFieldContract;

/**
 * Trait HasSubFieldsTrait
 * @package PomeloProductions\Admin\ACFHelpers\Traits
 */
trait HasSubFieldsTrait
{
    /**
     * @var array
     */
    private $subFields = [];

    /**
     * @var string
     */
    private $layout = 'block';

    /**
     * Adds a new sub field to this group
     *
     * @param IsACFFieldContract $subField
     * @return static
     */
    public function addSubField(IsACFFieldContract $subField)
    {
        $this->subFields[] = $subField->export();
        return $this;
    }

    /**
     * @param string $layout
     * @return static
     */
    public function setLayout(string $layout)
    {
        $this->layout = $layout;
        return $this;
    }

    /**
     * @return array
     */
    public function export(): array
    {
        $config = parent::export();

        $config['sub_fields'] = $this->subFields;
        $config['layout'] = $this->layout;

        return $config;
    }
}