<?php
declare(strict_types=1);

namespace PomeloProductions\Templates\Page;

use Handlebars\Handlebars;
use PomeloProductions\Templates\BaseTemplate;
use PomeloProductions\Templates\Traits\HasCompositeSectionTrait;

/**
 * Class CompositeTemplate
 * @package Theme\Templates\Page
 */
class CompositeTemplate extends BaseTemplate
{
    use HasCompositeSectionTrait;

    /**
     * Renders this particular template
     *
     * @param Handlebars $templateEngine
     * @param array $templateVariables
     * @return string
     */
    public function render(Handlebars $templateEngine, array $templateVariables): string
    {
        $templateVariables['sections'] = $this->renderPageSections($templateEngine, $templateVariables);

        $templateVariables['page_content'] = $this->processContentString($this->page->post_content);

        return $templateEngine->render('page/composite', $templateVariables);
    }

    /**
     * Gets all acf fields needed for this template
     *
     * @return array
     */
    public static function getACFGroup()
    {
        return array(
            'key' => 'group_5bb7daabf102c',
            'title' => 'Composite',
            'fields' => array(
                static::getACFField(),
            ),
            'location' => array(
                array(
                    array(
                        'param' => 'page_template',
                        'operator' => '==',
                        'value' => 'page-composite.php',
                    ),
                ),
            ),
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
            'description' => '',
        );
    }
}