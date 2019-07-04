<?php
declare(strict_types=1);

namespace PomeloProductions\Sections;

use Handlebars\Handlebars;
use PomeloProductions\Admin\ACFHelpers\Fields\GroupField;
use PomeloProductions\Admin\ACFHelpers\Fields\TextField;
use PomeloProductions\Admin\ACFHelpers\Fields\TrueFalseField;
use PomeloProductions\Admin\ACFHelpers\Fields\WYSIWYGField;

/**
 * Class StandardContent
 * @package Theme\Sections
 */
class StandardContent extends BaseSection
{
    /**
     * @var string
     */
    private $id;

    /**
     * @var string
     */
    private $title;

    /**
     * @var string
     */
    private $subtitle;

    /**
     * @var string
     */
    private $content;

    /**
     * @var boolean
     */
    private $fullWidth;

    /**
     * StandardContent constructor.
     * @param string $id
     * @param string $title
     * @param string $subtitle
     * @param string $content
     * @param bool $fullWidth
     */
    public function __construct(string $id, string $title, string $subtitle, string $content, bool $fullWidth)
    {
        $this->id = $id;
        $this->title = $title;
        $this->subtitle = $subtitle;
        $this->content = $content;
        $this->fullWidth = $fullWidth;
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
        $templateVariables['title'] = $this->title;
        $templateVariables['subtitle'] = $this->subtitle;
        $templateVariables['content'] = $this->processContentString($this->content);
        $templateVariables['full_width'] = $this->fullWidth;

        return $templateEngine->render('sections/standard-content', $templateVariables);
    }

    /**
     *
     *
     * @param array $conditionalLogic
     * @return array
     */
    public static function getACFGroup(array $conditionalLogic) : GroupField
    {
        $field = new GroupField('field_5ber4rg58d7a', 'single_column_editor', 'Input the content for the columns');

        $field->setConditionalLogic($conditionalLogic);

        $field->addSubField(
            new TextField('field_eiurgfth4b', 'id', 'The optional id for the section if this section should respond to link clicks')
        );
        $field->addSubField(
            new TextField('field_5ergffd7b', 'title', 'The optional title for this content section')
        );
        $field->addSubField(
            new TextField('field_5e543d7b', 'subtitle', 'The optional subtitle for this content section')
        );
        $field->addSubField(
            new WYSIWYGField('field_hugrf3i', 'content', 'The main content section that will be displayed')
        );
        $field->addSubField(
            (new TrueFalseField('field_ueerg3498toerhg4tu', 'full_width', 'Do you want this section to be the full width of the screen?'))
                ->setDefaultValue('0')
        );

        return $field;
    }
}