<?php
declare(strict_types=1);

namespace PomeloProductions\Sections;

use Handlebars\Handlebars;
use PomeloProductions\Admin\ACFHelpers\Fields\GroupField;
use PomeloProductions\Admin\ACFHelpers\Fields\RepeaterField;
use PomeloProductions\Admin\ACFHelpers\Fields\SelectField;
use PomeloProductions\Admin\ACFHelpers\Fields\TextField;
use PomeloProductions\Admin\ACFHelpers\Fields\WYSIWYGField;

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
     * @return GroupField
     */
    public static function getACFGroup(array $conditionalLogic) : GroupField
    {
        $field = new GroupField('field_5bb7f7e4ffd7a', 'two_column_editor', 'Input the content for the columns');

        $field->setConditionalLogic($conditionalLogic);

        $field->addSubField(
            new TextField('field_e6rtu67h4b', 'id', 'The optional id for the section if this section should respond to link clicks')
        );
        $field->addSubField(
            new WYSIWYGField('field_5bb7f827ffd7b', 'Top Content', 'The content that shows up above the columns')
        );

        $columns = new RepeaterField('field_5bb7f878ffd7c', 'columns', 'The columns that appear within this section');
        $columns->setLayout('table');
        $columns->setRequired();

        foreach (static::getRowACFRowFields()as $rowField) {
            $columns->addSubField($rowField);
        }

        $field->addSubField($columns);

        return $field;
    }

    /**
     * Gets the acf field config for the row
     *
     * @return array
     */
    public static function getRowACFRowFields() : array
    {
        return [
            (new SelectField('field_5bb7f8c3ffd7d', 'layout_style', 'Select the layout style for this set of columns.', [
                'even-spacing' => 'Half and half sizing',
                'first-small-second-wide' => 'First column small, second column wide',
                'first-wide-second-small' => 'First column wide, second column small',
                'first-tiny-second-wide' => 'First column tiny, second column very wide',
            ]))
                ->setAllowNull(false),
            (new GroupField('field_5bb7fca60f26d', 'row', ''))
                ->addSubField(
                    new WYSIWYGField('field_5bb7f970ffd7e', 'column_1', 'The content for the first column')
                )
                ->addSubField(
                    new WYSIWYGField('field_5bb7f9bbffd7f', 'column_2', 'The content for the second column')
                )
        ];
    }
}