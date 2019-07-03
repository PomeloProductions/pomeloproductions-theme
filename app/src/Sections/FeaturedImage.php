<?php
declare(strict_types=1);

namespace PomeloProductions\Sections;

use Handlebars\Handlebars;
use PomeloProductions\Admin\ACFHelpers\Fields\GroupField;
use PomeloProductions\Admin\ACFHelpers\Fields\ImageField;
use PomeloProductions\Admin\ACFHelpers\Fields\WYSIWYGField;

/**
 * Class FeaturedImage
 * @package Theme\Sections
 */
class FeaturedImage extends BaseSection
{
    /**
     * @var string
     */
    private $pageTitle;

    /**
     * @var string
     */
    private $imageURL;

    /**
     * FeaturedImage constructor.
     * @param string $pageTitle
     * @param string $imageURL
     */
    public function __construct(string $pageTitle, string $imageURL)
    {
        $this->pageTitle = $pageTitle;
        $this->imageURL = $imageURL;
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
        $templateVariables['image_url'] = $this->imageURL;
        $templateVariables['page_title'] = $this->processContentString($this->pageTitle);

        return $templateEngine->render('sections/featured-image', $templateVariables);
    }

    /**
     * Gets the acf fields required for this section
     *
     * @param array $conditionalLogic
     * @return GroupField
     */
    public static function getACFGroup(array $conditionalLogic) : GroupField
    {
        $group = new GroupField('field_hy552be459a', 'Featured Image Editor', '');

        $group->setConditionalLogic($conditionalLogic);

        $group->addSubField(
            new WYSIWYGField('field_regwe43', 'content', 'Enter the content to appear above this image')
        );
        $group->addSubField(
            (new ImageField('field_6herg3', 'image', 'Select the image to appear for this section'))
                ->setRequired()
        );

        return $group;
    }
}