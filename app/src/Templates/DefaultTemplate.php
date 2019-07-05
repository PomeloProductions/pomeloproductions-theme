<?php
declare(strict_types=1);

namespace PomeloProductions\Templates;

use Handlebars\Handlebars;

/**
 * Class DefaultTemplate
 * @package Theme\Templates
 */
class DefaultTemplate extends BaseTemplate
{
    /**
     * Renders this particular template
     *
     * @param Handlebars $templateEngine
     * @param array $templateVariables
     * @return string
     */
    public function render(Handlebars $templateEngine, array $templateVariables): string
    {
        $templateVariables['page_title'] = $this->page->post_title;
        $templateVariables['page_content'] = $this->processContentString($this->page->post_content);
        return $templateEngine->render('default', $templateVariables);
    }
}