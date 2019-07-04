<?php
declare(strict_types=1);

namespace PomeloProductions\Sections;

use Handlebars\Handlebars;
use PomeloProductions\Admin\ACFHelpers\Fields\GroupField;
use PomeloProductions\Admin\ACFHelpers\Fields\NumberField;

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
     * @return GroupField
     */
    public static function getACFGroup(array $conditionalLogic) : GroupField
    {
        $field = new GroupField('field_5berbe58d7a', 'spacer_editor', 'Set the spacing amount in pixels.');

        $field->setConditionalLogic($conditionalLogic);
        $field->addSubField(new NumberField('field_5ergefd7b', 'pixels', ''));

        return $field;
    }
}