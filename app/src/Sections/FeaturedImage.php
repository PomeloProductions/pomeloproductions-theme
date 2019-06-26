<?php
declare(strict_types=1);

namespace PomeloProductions\Sections;

use Handlebars\Handlebars;
use PomeloProductions\Admin\ACFHelpers\ImageField;
use PomeloProductions\Admin\ACFHelpers\WYSIWYGField;

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
     * @return array
     */
    public static function getACFGroup(array $conditionalLogic) : array
    {
        return array(
            'key' => 'field_hy552be459a',
            'label' => 'Featured Image Editor',
            'name' => 'featured_image_editor',
            'type' => 'group',
            'instructions' => '',
            'required' => 0,
            'conditional_logic' => $conditionalLogic,
            'wrapper' => array(
                'width' => '',
                'class' => '',
                'id' => '',
            ),
            'layout' => 'block',
            'sub_fields' => array(
                (new WYSIWYGField('field_regwe43', 'content', 'Enter the content to appear above this image'))->export(),
                (new ImageField('field_6herg3', 'image', 'Select the image to appear for this section'))->setRequired()->export(),
            ),
        );
    }
}