<?php
declare(strict_types=1);

namespace PomeloProductions\Sections;

use Handlebars\Handlebars;
use PomeloProductions\Admin\ACFHelpers\Fields\GroupField;
use PomeloProductions\Admin\ACFHelpers\Fields\ImageField;
use PomeloProductions\Admin\ACFHelpers\Fields\TextField;

/**
 * Class Featured
 * @package Theme\Sections
 */
class Featured extends BaseSection
{
    /**
     * @var string
     */
    private $primaryTitle;

    /**
     * @var string
     */
    private $primarySubtitle;

    /**
     * @var string
     */
    private $actionText;

    /**
     * @var string
     */
    private $primaryLink;

    /**
     * @var string
     */
    private $primaryBackgroundUrl;

    /**
     * @var string
     */
    private $secondTitle;

    /**
     * @var string
     */
    private $secondLink;

    /**
     * @var string
     */
    private $secondImageURL;

    /**
     * @var string
     */
    private $thirdTitle;

    /**
     * @var string
     */
    private $thirdLink;

    /**
     * @var string
     */
    private $thirdImageURL;

    /**
     * Featured constructor.
     * @param string $primaryTitle
     * @param string $primarySubtitle
     * @param string $actionText
     * @param string $primaryLink
     * @param string $primaryBackgroundUrl
     * @param string $secondTitle
     * @param string $secondLink
     * @param string $secondImageURL
     * @param string $thirdTitle
     * @param string $thirdLink
     * @param string $thirdImageURL
     */
    public function __construct(string $primaryTitle, string $primarySubtitle, string $actionText, string $primaryLink, string $primaryBackgroundUrl,
                                string $secondTitle, string $secondLink, string $secondImageURL, string $thirdTitle, string $thirdLink, string $thirdImageURL)
    {
        $this->primaryTitle = $primaryTitle;
        $this->primarySubtitle = $primarySubtitle;
        $this->actionText = $actionText;
        $this->primaryLink = $primaryLink;
        $this->primaryBackgroundUrl = $primaryBackgroundUrl;
        $this->secondTitle = $secondTitle;
        $this->secondLink = $secondLink;
        $this->secondImageURL = $secondImageURL;
        $this->thirdTitle = $thirdTitle;
        $this->thirdLink = $thirdLink;
        $this->thirdImageURL = $thirdImageURL;
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
        $templateVariables['primary_title'] = $this->primaryTitle;
        $templateVariables['primary_subtitle'] = $this->primarySubtitle;
        $templateVariables['action_text'] = $this->actionText;
        $templateVariables['primary_link'] = $this->primaryLink;
        $templateVariables['primary_background_url'] = $this->primaryBackgroundUrl;

        $templateVariables['second_title'] = $this->secondTitle;
        $templateVariables['second_link'] = $this->secondLink;
        $templateVariables['second_image_url'] = $this->secondImageURL;

        $templateVariables['third_title'] = $this->thirdTitle;
        $templateVariables['third_link'] = $this->thirdLink;
        $templateVariables['third_image_url'] = $this->thirdImageURL;

        return $templateEngine->render('sections/featured', $templateVariables);
    }

    /**
     * Gets an image url based on an attachment id
     *
     * @param int $attachmentId
     * @return string|null
     */
    public static function getSecondaryImageUrl($attachmentId)
    {
        $image = wp_get_attachment_image_src($attachmentId, ['960', '540']);

        return $image ? $image[0] : null;
    }

    /**
     * Gets the acf fields required for this section
     *
     * @param array $conditionalLogic
     * @return array
     */
    public static function getACFGroup(array $conditionalLogic) : GroupField
    {
        $group = new GroupField('field_5bb80a7be459a', 'featured_editor', '');

        $group->setConditionalLogic($conditionalLogic);

        $group->addSubField(
            (new TextField('field_5bb80ab1e459b', 'primary_title', 'Enter the title for the primary piece'))
                ->setRequired()
        );
        $group->addSubField(
            new TextField('field_5bb80ae9e459c', 'primary_subtitle', 'Optional subtitle to the primary section')
        );
        $group->addSubField(
            (new TextField('field_5bb80b05e459d', 'action_text', 'The action text located above the primary title, and within the arrow in mobile layouts'))
                ->setRequired()
        );
        $group->addSubField(
            (new TextField('field_5bb80b37e459e', 'primary_link', 'The link related to the primary section'))
                ->setRequired()
        );
        $group->addSubField(
            (new ImageField('field_5bb80bade459f', 'primary_background_image', ''))
                ->setRequired()
        );

        $group->addSubField(
            (new TextField('field_5bb80bd1e45a0', 'second_title', 'The title used for the second featured section.'))
                ->setRequired()
        );
        $group->addSubField(
            (new TextField('field_5bb80bf3e45a1', 'second_link', 'The link related to the second article'))
                ->setRequired()
        );
        $group->addSubField(
            (new ImageField('field_5bb80c1de45a2', 'second_background_image', 'The image that will be used for the background of the second featured section'))
                ->setRequired()
        );

        $group->addSubField(
            (new TextField('field_5bb80c58e45a3', 'third_title', 'The title used for the third featured section.'))
                ->setRequired()
        );
        $group->addSubField(
            (new TextField('field_5bb80c76e45a4', 'third_link', 'The link related to the third article'))
                ->setRequired()
        );
        $group->addSubField(
            (new ImageField('field_5bb80c8ae45a5', 'third_background_image', 'The image that will be used for the background of the third featured section'))
                ->setRequired()
        );

        return $group;
    }
}