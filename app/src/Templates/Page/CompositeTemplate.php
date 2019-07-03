<?php
declare(strict_types=1);

namespace PomeloProductions\Templates\Page;

use Handlebars\Handlebars;
use PomeloProductions\Admin\ACFHelpers\ParentGroup;
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
    public static function getACFGroup(): array
    {
        $group = new ParentGroup('group_5bb7daabf102c', 'Composite');
        $group->addLocation([
            [
                'param' => 'page_template',
                'operator' => '==',
                'value' => 'page-composite.php',
            ],
        ]);
        $group->addField(static::getACFField());

        return $group->export();
    }
}