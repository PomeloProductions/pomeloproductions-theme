<?php
declare(strict_types=1);

namespace PomeloProductions\Admin\ACFHelpers;

use PomeloProductions\Contracts\IsACFFieldContract;

/**
 * Class Group
 * @package PomeloProductions\Admin\ACFHelpers
 */
class ParentGroup implements IsACFFieldContract
{
    /**
     * @var string
     */
    private $key;

    /**
     * @var string
     */
    private $title;

    /**
     * @var string
     */
    private $description = '';

    /**
     * @var array
     */
    private $locations = [];

    /**
     * @var array
     */
    private $fields = [];

    /**
     * Group constructor.
     * @param string $key
     * @param string $title
     */
    public function __construct(string $key, string $title)
    {
        $this->key = $key;
        $this->title = $title;
    }

    /**
     * @param string $description
     */
    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    /**
     * Adds a location to this group
     *
     * @param array $location
     * @return ParentGroup
     */
    public function addLocation(array $location): ParentGroup
    {
        $this->locations[] = $location;
        return $this;
    }

    /**
     * Makes sure to show this on every page
     *
     * @return ParentGroup
     */
    public function showOnAllPages(): ParentGroup
    {
        $this->locations = [
            [
                [
                    'param' => 'post_type',
                    'operator' => '!=',
                    'value' => 'post',
                ],
            ],
            [
                [
                    'param' => 'post_type',
                    'operator' => '!=',
                    'value' => 'page',
                ],
            ]
        ];

        return $this;
    }

    /**
     * Adds a field to the configuration
     *
     * @param IsACFFieldContract $field
     * @return ParentGroup
     */
    public function addField(IsACFFieldContract $field): ParentGroup
    {
        $this->fields[] = $field->export();
        return $this;
    }

    /**
     * Exports the group to be used within ACF
     *
     * @return array
     */
    public function export(): array
    {
        return [
            'key' => $this->key,
            'title' => $this->title,
            'fields' => $this->fields,
            'location' => $this->locations,
            'menu_order' => 0,
            'position' => 'normal',
            'style' => 'seamless',
            'label_placement' => 'top',
            'instruction_placement' => 'label',
            'hide_on_screen' => array(
                0 => 'the_content',
                1 => 'excerpt',
                2 => 'comments',
                3 => 'featured_image',
            ),
            'active' => 1,
            'description' => $this->description,
        ];
    }
}