<?php
declare(strict_types=1);

namespace PomeloProductions\Admin\ACFHelpers\Traits;

use PomeloProductions\Admin\ACFHelpers\Fields\GroupField;
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
    public function addSubField(IsACFFieldContract $subField): HasSubFieldsTrait
    {
        $this->subFields[] = $subField->export();
        return $this;
    }

    /**
     * @param string $layout
     * @return GroupField|static
     */
    public function setLayout(string $layout): HasSubFieldsTrait
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