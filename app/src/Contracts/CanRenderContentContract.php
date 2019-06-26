<?php
declare(strict_types=1);

namespace PomeloProductions\Contracts;

use Handlebars\Handlebars;

/**
 * Interface CanRenderContentContract
 * @package Theme\Contracts
 */
interface CanRenderContentContract
{
    /**
     * Renders this particular template
     *
     * @param Handlebars $templateEngine
     * @param array $templateVariables
     * @return string
     */
    public function render(Handlebars $templateEngine, array $templateVariables) : string;

    /**
     * Processes a content string properly for output
     *
     * @param string $content
     * @return string
     */
    public function processContentString(string $content) : string;
}