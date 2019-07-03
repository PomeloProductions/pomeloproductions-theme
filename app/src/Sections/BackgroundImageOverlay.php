<?php
declare(strict_types=1);

namespace PomeloProductions\Sections;

use Handlebars\Handlebars;
use PomeloProductions\Admin\ACFHelpers\Fields\ColorPickerField;
use PomeloProductions\Admin\ACFHelpers\Fields\GroupField;
use PomeloProductions\Admin\ACFHelpers\Fields\ImageField;
use PomeloProductions\Admin\ACFHelpers\Fields\NumberField;
use PomeloProductions\Admin\ACFHelpers\Fields\TextField;
use PomeloProductions\Admin\ACFHelpers\Fields\WYSIWYGField;

/**
 * Class BackgroundImageOverlay
 * @package Theme\Sections
 */
class BackgroundImageOverlay extends BaseSection
{
    /**
     * @var string
     */
    private $id;

    /**
     * @var string
     */
    private $backgroundUrl;

    /**
     * @var string
     */
    private $content;

    /**
     * @var string
     */
    private $color;

    /**
     * @var string
     */
    private $backgroundColor;

    /**
     * @var string
     */
    private $height;

    /**
     * BackgroundImageOverlay constructor.
     * @param string $id
     * @param string $backgroundUrl
     * @param string $content
     * @param string $color
     * @param string $backgroundColor
     * @param string $height
     */
    public function __construct(string $id, string $backgroundUrl, string $content, string $color, string $backgroundColor, string $height)
    {
        $this->id = $id;
        $this->backgroundUrl = $backgroundUrl;
        $this->content = $content;
        $this->color = $color;
        $this->backgroundColor = $backgroundColor;
        $this->height = $height;
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
        $templateVariables['background_url'] = $this->backgroundUrl;
        $templateVariables['content'] = $this->processContentString($this->content);
        $templateVariables['color'] = $this->color;
        $templateVariables['background_color'] = $this->backgroundColor;
        $templateVariables['height'] = $this->height;

        return $templateEngine->render('sections/background-image-overlay', $templateVariables);
    }

    /**
     * Gets the acf fields required for this section
     *
     * @param array $conditionalLogic
     * @return GroupField
     */
    public static function getACFGroup(array $conditionalLogic): GroupField
    {
        $group = new GroupField('field_5bbferg452be459a', 'Background Image Overlay Editor', '');

        $group->setConditionalLogic($conditionalLogic);

        $group->addSubField(
            new TextField('field_hfu67h4b', 'id', 'The optional id for the section if this section should respond to link clicks')
        );
        $group->addSubField(
            (new WYSIWYGField('field_645tgrwihwe43', 'content', 'Enter the text to show above the background'))
            ->setRequired()
        );
        $group->addSubField(
            new NumberField('field_389t4uyfehj', 'height', 'Enter the height of this section in percentage of the site width. (83.3 is the default)')
        );
        $group->addSubField(
            new ColorPickerField('field_645ebvf', 'color', 'Select the color for the text above the background')
        );
        $group->addSubField(
            new ColorPickerField('field_ethoeiebvf', 'background_color', 'Select the color for the text above the background')
        );
        $group->addSubField(
            (new ImageField('field_hg243ie789gj6', 'background_image', 'Set the background image for this section'))
            ->setRequired()
        );

        return $group;
    }
}