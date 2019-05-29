<?php
declare(strict_types=1);

namespace Theme\Sections;

use Handlebars\Handlebars;

/**
 * Class PageTitle
 * @package Theme\Sections
 */
class PageTitle extends BaseSection
{
    /**
     * @var string
     */
    private $pageTitle;

    /**
     * @var string
     */
    private $contentClass;

    /**
     * PageTitle constructor.
     * @param string $pageTitle
     * @param string $contentClass
     */
    public function __construct(string $pageTitle, string $contentClass)
    {
        $this->pageTitle = $pageTitle;
        $this->contentClass = $contentClass;
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
        $templateVariables['content_class'] = $this->contentClass;
        $templateVariables['page_title'] = $this->pageTitle;

        return $templateEngine->render('sections/page-title', $templateVariables);
    }
}