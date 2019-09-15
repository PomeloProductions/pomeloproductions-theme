<?php
declare(strict_types=1);

namespace PomeloProductions\Admin\ACFHelpers\Fields;

/**
 * Class PostObjectField
 * @package PomeloProductions\Admin\ACFHelpers\Fields
 */
class PostObjectField extends BaseField
{
    /**
     * @var array
     */
    private $postType;

    /**
     * PostObjectField constructor.
     * @param string $key
     * @param string $name
     * @param string $instructions
     * @param array $postType
     */
    public function __construct(string $key, string $name, string $instructions, array $postType = [])
    {
        parent::__construct('post_object', $key, $name, $instructions);
        $this->postType = $postType;
    }

    /**
     * Makes sure to add the post types field
     *
     * @return array
     */
    public function export(): array
    {
        $field = parent::export();

        $field['post_type'] = $this->postType;
        $field['ui'] = 1;
        $field['return_format'] = 'object';
        $field['taxonomy'] = '';
        $field['multiple'] = 0;

        return array(
            'key' => 'field_5d7ec717cf',
            'label' => 'Page',
            'name' => 'page',
            'type' => 'post_object',
            'instructions' => '',
            'required' => 0,
            'conditional_logic' => 0,
            'wrapper' => array(
                'width' => '',
                'class' => '',
                'id' => '',
            ),
            'post_type' => array(
                0 => 'page',
            ),
            'taxonomy' => '',
            'allow_null' => 0,
            'multiple' => 0,
            'return_format' => 'object',
            'ui' => 1,
        );

        return $field;
    }
}