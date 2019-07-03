<?php
declare(strict_types=1);

namespace PomeloProductions\Templates\Page;

use Handlebars\Handlebars;
use PomeloProductions\Templates\BaseTemplate;

/**
 * Class SplashTemplate
 * @package Theme\Templates\Page
 */
class SplashTemplate extends BaseTemplate
{
    /**
     * This page does not have a header
     *
     * @return bool
     */
    public function hasHeader(): bool
    {
        return false;
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
        $templateVariables['page_content'] = $this->processContentString($this->page->post_content);

        return $templateEngine->render('page/splash', $templateVariables);
    }
}