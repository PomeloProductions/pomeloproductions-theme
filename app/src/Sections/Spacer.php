<?php
declare(strict_types=1);

namespace Theme\Sections;

use Handlebars\Handlebars;
use Theme\Admin\ACFHelpers\NumberField;

/**
 * Class Spacer
 * @package Theme\Sections
 */
class Spacer extends BaseSection
{
    /**
     * @var float
     */
    private $pixels;

    /**
     * Spacer constructor.
     * @param $pixels
     */
    public function __construct(float $pixels)
    {
        $this->pixels = $pixels;
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
        $templateVariables['pixels'] = $this->pixels;

        return $templateEngine->render('sections/spacer', $templateVariables);
    }

    /**
     * @param array $conditionalLogic
     * @return array
     */
    public static function getACFGroup(array $conditionalLogic) : array
    {
        return array(
            'key' => 'field_5berbe58d7a',
            'label' => 'Spacer',
            'name' => 'spacer_editor',
            'type' => 'group',
            'instructions' => 'Set the spacing amount in pixels.',
            'required' => 0,
            'conditional_logic' => $conditionalLogic,
            'wrapper' => array(
                'width' => '',
                'class' => '',
                'id' => '',
            ),
            'layout' => 'block',
            'sub_fields' => array(
                (new NumberField('field_5ergefd7b', 'pixels', ''))->export(),
            ),
        );
    }
}