<?php
declare(strict_types=1);

namespace PomeloProductions\Sections;

use Handlebars\Handlebars;
use PomeloProductions\Admin\ACFHelpers\Fields\GroupField;
use PomeloProductions\Admin\ACFHelpers\Fields\TextField;
use PomeloProductions\Admin\ACFHelpers\Fields\WYSIWYGField;

/**
 * Class ThreeColumn
 * @package Theme\Sections
 */
class ThreeColumn extends BaseSection
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
     * @var string
     */
    private $column1;

    /**
     * @var string
     */
    private $column2;

    /**
     * @var string
     */
    private $column3;

    /**
     * ThreeColumn constructor.
     * @param string $id
     * @param string $topContent
     * @param string $column1
     * @param string $column2
     * @param string $column3
     */
    public function __construct(string $id, string $topContent, string $column1, string $column2, string  $column3)
    {
        $this->id = $id;
        $this->topContent = $topContent;
        $this->column1 = $column1;
        $this->column2 = $column2;
        $this->column3 = $column3;
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
        $templateVariables['column_1'] = $this->processContentString($this->column1);
        $templateVariables['column_2'] = $this->processContentString($this->column2);
        $templateVariables['column_3'] = $this->processContentString($this->column3);

        return $templateEngine->render('sections/three-column', $templateVariables);
    }

    /**
     * The acf group for the three column template
     *
     * @param array $conditionalLogic
     * @return GroupField
     */
    public static function getACFGroup(array $conditionalLogic) : GroupField
    {
        $field = new GroupField('field_5breherb7f7e4ffd7a', 'three_column_editor', 'Input the content for the columns');

        $field->setConditionalLogic($conditionalLogic);

        $field->addSubField(
            new TextField('field_eiuhfu67h4b', 'id', 'The optional id for the section if this section should respond to link clicks')
        );
        $field->addSubField(
            new WYSIWYGField('field_5bregb7f827ffd7b', 'Top Content', 'The content that shows up above the columns')
        );

        $columns = new GroupField('field_5bb7f5460f26d', 'row', '');
        $columns->setLayout('table');

        $columns->addSubField(
            new WYSIWYGField('field_ntrbb7f970ffd7e', 'column_1', 'The content for the first column')
        );
        $columns->addSubField(
            new WYSIWYGField('field_rnr7f9bbffd7f', 'column_2', 'The content for the second column')
        );
        $columns->addSubField(
            new WYSIWYGField('field_rtrhf9bbhjf', 'column_3', 'The content for the third column')
        );

        $field->addSubField($columns);

        return $field;
    }
}