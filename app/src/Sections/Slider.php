<?php
declare(strict_types=1);

namespace PomeloProductions\Sections;

use Handlebars\Handlebars;
use PomeloProductions\Admin\ACFHelpers\TextField;
use PomeloProductions\Admin\ACFHelpers\TrueFalseField;

/**
 * Class Slider
 * @package Theme\Sections
 */
class Slider extends BaseSection
{
    /**
     * @var string
     */
    private $sliderShortCode;

    /**
     * @var bool
     */
    private $featuredStyle;

    /**
     * Slider constructor.
     * @param string $sliderShortCode
     * @param bool $featuredStyle
     */
    public function __construct(string $sliderShortCode, bool $featuredStyle)
    {
        $this->sliderShortCode = $sliderShortCode;
        $this->featuredStyle = $featuredStyle;
    }

    /**
     * Renders this particular template
     *
     * @param Handlebars $templateEngine
     * @param array $templateVariables
     * @return string
     */
    public function render(Handlebars $templateEngine, array $templateVariables = []): string
    {
        $templateVariables['slider'] = $this->processContentString($this->sliderShortCode);

        $templateVariables['featured_style'] = $this->featuredStyle;

        return $templateEngine->render('sections/slider', $templateVariables);
    }

    /**
     * Gets the acf fields required for this section
     *
     * @param array $conditionalLogic
     * @return array
     */
    public static function getACFGroup(array $conditionalLogic) : array
    {
        return array(
            'key' => 'field_rehegrg452be459a',
            'label' => 'Slider Editor',
            'name' => 'slider_editor',
            'type' => 'group',
            'instructions' => '',
            'required' => 0,
            'conditional_logic' => $conditionalLogic,
            'wrapper' => array(
                'width' => '',
                'class' => '',
                'id' => '',
            ),
            'layout' => 'block',
            'sub_fields' => array(
                (new TextField('field_6gegrgwe43', 'slider_shortcode', 'Enter the short code needed for the slider'))
                    ->setRequired()
                    ->export(),
                (new TrueFalseField('field_ueorhg4tu', 'featured_style', 'Do you want this slider to be displayed in the featured slider style?'))
                    ->setDefaultValue('1')
                    ->export(),
            ),
        );
    }
}