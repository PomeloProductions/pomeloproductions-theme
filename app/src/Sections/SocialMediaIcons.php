<?php
declare(strict_types=1);

namespace PomeloProductions\Sections;

use Handlebars\Handlebars;

/**
 * Class SocialMediaIcons
 * @package Theme\Sections
 */
class SocialMediaIcons extends BaseSection
{
    /**
     * @var array
     */
    private $socialLinks;

    /**
     * SocialMediaIcons constructor.
     * @param array $socialLinks
     */
    public function __construct(array $socialLinks)
    {
        $this->socialLinks = $socialLinks;
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
        $templateVariables['social_links'] = $this->socialLinks;

        return $templateEngine->render('sections/social-media-icons', $templateVariables);
    }
}