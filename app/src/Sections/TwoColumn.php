<?php
declare(strict_types=1);

namespace PomeloProductions\Sections;

use Handlebars\Handlebars;
use PomeloProductions\Admin\ACFHelpers\TextField;
use PomeloProductions\Admin\ACFHelpers\WYSIWYGField;

/**
 * Class TwoColumn
 * @package Theme\Sections
 */
class TwoColumn extends BaseSection
{
    /**
     * @var string
     */
    private $id;

    /**
     * @var string
     */
    private $topContent;

    /**
     * @var array
     */
    private $columns;

    /**
     * ThreeColumn constructor.
     * @param string $id
     * @param string $topContent
     * @param array $columns
     */
    public function __construct(string $id, ?string $topContent, array $columns)
    {
        $this->id = $id;
        $this->topContent = $topContent;
        $this->columns = $columns;
    }

    /**
     * Renders this particular template
     *
     * @param Handlebars $templateEngine
     * @param array $templateVariables
     * @return string
     */
    public function render(Handlebars $templateEngine, array $templateVariables): string
    {
        $templateVariables['id'] = $this->id;
        $templateVariables['top_content'] = $this->processContentString($this->topContent);

        $columns = [];

        foreach ($this->columns as $column) {
            $layoutClass = $column['layout_class'];

            $columns[] = [
                'column_1' => $this->processContentString($column['column_1']),
                'column_2' => $this->processContentString($column['column_2']),
                'layout_class' => $layoutClass,
                'padding_class' => static::getPaddingClass($layoutClass),
             ];
        }

        $templateVariables['columns'] = $columns;

        return $templateEngine->render('sections/two-column', $templateVariables);
    }

    /**
     * Gets the padding class needed for the layout class
     *
     * @param string $layoutClass
     * @return string
     */
    public static function getPaddingClass(string $layoutClass) : string
    {
        switch ($layoutClass) {
            case 'first-tiny-second-wide':
            case 'first-small-second-wide':
            case 'first-wide-second-small':
                return 'wide-content';

            default:
                return 'narrow-content';
        }
    }

    /**
     *
     *
     * @param array $conditionalLogic
     * @return array
     */
    public static function getACFGroup(array $conditionalLogic) : array
    {
        return array(
            'key' => 'field_5bb7f7e4ffd7a',
            'label' => 'Two Column Editor',
            'name' => 'two_column_editor',
            'type' => 'group',
            'instructions' => 'Input the content for the columns',
            'required' => 0,
            'conditional_logic' => $conditionalLogic,
            'wrapper' => array(
                'width' => '',
                'class' => '',
                'id' => '',
            ),
            'layout' => 'block',
            'sub_fields' => array(
                (new TextField('field_e6rtu67h4b', 'id', 'The optional id for the section if this section should respond to link clicks'))->export(),
                array(
                    'key' => 'field_5bb7f827ffd7b',
                    'label' => 'Top Content',
                    'name' => 'top_content',
                    'type' => 'wysiwyg',
                    'instructions' => 'The content that shows up above the columns',
                    'required' => 0,
                    'conditional_logic' => 0,
                    'wrapper' => array(
                        'width' => '',
                        'class' => '',
                        'id' => '',
                    ),
                    'default_value' => '',
                    'tabs' => 'all',
                    'toolbar' => 'full',
                    'media_upload' => 1,
                    'delay' => 0,
                ),
                array(
                    'key' => 'field_5bb7f878ffd7c',
                    'label' => 'Columns',
                    'name' => 'columns',
                    'type' => 'repeater',
                    'instructions' => 'The columns that appear within this section',
                    'required' => 1,
                    'conditional_logic' => 0,
                    'wrapper' => array(
                        'width' => '',
                        'class' => '',
                        'id' => '',
                    ),
                    'collapsed' => '',
                    'min' => 0,
                    'max' => 0,
                    'layout' => 'block',
                    'button_label' => '',
                    'sub_fields' => static::getRowACFRowFields(),
                ),
            ),
        );
    }

    /**
     * Gets the acf field config for the row
     *
     * @return array
     */
    public static function getRowACFRowFields() : array
    {
        return [
            [
                'key' => 'field_5bb7f8c3ffd7d',
                'label' => 'Layout Style',
                'name' => 'layout_style',
                'type' => 'select',
                'instructions' => 'Select the layout style for this set of columns.',
                'required' => 0,
                'conditional_logic' => 0,
                'wrapper' => array(
                    'width' => '',
                    'class' => '',
                    'id' => '',
                ),
                'choices' => array(
                    'even-spacing' => 'Half and half sizing',
                    'first-small-second-wide' => 'First column small, second column wide',
                    'first-wide-second-small' => 'First column wide, second column small',
                    'first-tiny-second-wide' => 'First column tiny, second column very wide',
                ),
                'default_value' => array(
                ),
                'allow_null' => 0,
                'multiple' => 0,
                'ui' => 0,
                'return_format' => 'value',
                'ajax' => 0,
                'placeholder' => '',
            ], [
                'key' => 'field_5bb7fca60f26d',
                'label' => '',
                'name' => 'row',
                'type' => 'group',
                'instructions' => '',
                'required' => 0,
                'conditional_logic' => 0,
                'wrapper' => array(
                    'width' => '',
                    'class' => '',
                    'id' => '',
                ),
                'layout' => 'table',
                'sub_fields' => [
                    (new WYSIWYGField('field_5bb7f970ffd7e', 'column_1', 'The content for the first column'))->export(),
                    (new WYSIWYGField('field_5bb7f9bbffd7f', 'column_2', 'The content for the second column'))->export(),
                ],
            ],
        ];
    }
}