<?php
declare(strict_types=1);

namespace Theme\Sections;

use Handlebars\Handlebars;

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
    public static function getACFGroup(array $conditionalLogic) : array
    {
        return array(
            'key' => 'field_5bb80a7be459a',
            'label' => 'Featured Editor',
            'name' => 'featured_editor',
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
                array(
                    'key' => 'field_5bb80ab1e459b',
                    'label' => 'Primary Title',
                    'name' => 'primary_title',
                    'type' => 'text',
                    'instructions' => 'Enter the title for the primary piece',
                    'required' => 1,
                    'conditional_logic' => 0,
                    'wrapper' => array(
                        'width' => '',
                        'class' => '',
                        'id' => '',
                    ),
                    'default_value' => '',
                    'placeholder' => '',
                    'prepend' => '',
                    'append' => '',
                    'maxlength' => '',
                ),
                array(
                    'key' => 'field_5bb80ae9e459c',
                    'label' => 'Primary Subtitle',
                    'name' => 'primary_subtitle',
                    'type' => 'text',
                    'instructions' => 'Optional subtitle to the primary section',
                    'required' => 0,
                    'conditional_logic' => 0,
                    'wrapper' => array(
                        'width' => '',
                        'class' => '',
                        'id' => '',
                    ),
                    'default_value' => '',
                    'placeholder' => '',
                    'prepend' => '',
                    'append' => '',
                    'maxlength' => '',
                ),
                array(
                    'key' => 'field_5bb80b05e459d',
                    'label' => 'Action Text',
                    'name' => 'action_text',
                    'type' => 'text',
                    'instructions' => 'The action text located above the primary title, and within the arrow in mobile layouts',
                    'required' => 1,
                    'conditional_logic' => 0,
                    'wrapper' => array(
                        'width' => '',
                        'class' => '',
                        'id' => '',
                    ),
                    'default_value' => '',
                    'placeholder' => '',
                    'prepend' => '',
                    'append' => '',
                    'maxlength' => '',
                ),
                array(
                    'key' => 'field_5bb80b37e459e',
                    'label' => 'Primary Link',
                    'name' => 'primary_link',
                    'type' => 'text',
                    'instructions' => 'The link related to the primary section',
                    'required' => 1,
                    'conditional_logic' => 0,
                    'wrapper' => array(
                        'width' => '',
                        'class' => '',
                        'id' => '',
                    ),
                    'default_value' => '',
                    'placeholder' => '',
                ),
                array(
                    'key' => 'field_5bb80bade459f',
                    'label' => 'Primary Background Image',
                    'name' => 'primary_background_image',
                    'type' => 'image',
                    'instructions' => '',
                    'required' => 1,
                    'conditional_logic' => 0,
                    'wrapper' => array(
                        'width' => '',
                        'class' => '',
                        'id' => '',
                    ),
                    'return_format' => 'url',
                    'preview_size' => 'featured-image',
                    'library' => 'all',
                    'min_width' => '',
                    'min_height' => '',
                    'min_size' => '',
                    'max_width' => '',
                    'max_height' => '',
                    'max_size' => '',
                    'mime_types' => '',
                ),
                array(
                    'key' => 'field_5bb80bd1e45a0',
                    'label' => 'Second Title',
                    'name' => 'second_title',
                    'type' => 'text',
                    'instructions' => 'The title used for the second featured section.',
                    'required' => 1,
                    'conditional_logic' => 0,
                    'wrapper' => array(
                        'width' => '',
                        'class' => '',
                        'id' => '',
                    ),
                    'default_value' => '',
                    'placeholder' => '',
                    'prepend' => '',
                    'append' => '',
                    'maxlength' => '',
                ),
                array(
                    'key' => 'field_5bb80bf3e45a1',
                    'label' => 'Second Link',
                    'name' => 'second_link',
                    'type' => 'text',
                    'instructions' => 'The link related to the second article',
                    'required' => 1,
                    'conditional_logic' => 0,
                    'wrapper' => array(
                        'width' => '',
                        'class' => '',
                        'id' => '',
                    ),
                    'default_value' => '',
                    'placeholder' => '',
                ),
                array(
                    'key' => 'field_5bb80c1de45a2',
                    'label' => 'Second Background Image',
                    'name' => 'second_background_image',
                    'type' => 'image',
                    'instructions' => 'The image that will be used for the background of the second featured section',
                    'required' => 1,
                    'conditional_logic' => 0,
                    'wrapper' => array(
                        'width' => '',
                        'class' => '',
                        'id' => '',
                    ),
                    'return_format' => 'url',
                    'preview_size' => 'thumbnail',
                    'library' => 'all',
                    'min_width' => '',
                    'min_height' => '',
                    'min_size' => '',
                    'max_width' => '',
                    'max_height' => '',
                    'max_size' => '',
                    'mime_types' => '',
                ),
                array(
                    'key' => 'field_5bb80c58e45a3',
                    'label' => 'Third Title',
                    'name' => 'third_title',
                    'type' => 'text',
                    'instructions' => 'The title of the third featured item',
                    'required' => 1,
                    'conditional_logic' => 0,
                    'wrapper' => array(
                        'width' => '',
                        'class' => '',
                        'id' => '',
                    ),
                    'default_value' => '',
                    'placeholder' => '',
                    'prepend' => '',
                    'append' => '',
                    'maxlength' => '',
                ),
                array(
                    'key' => 'field_5bb80c76e45a4',
                    'label' => 'Third Link',
                    'name' => 'third_link',
                    'type' => 'text',
                    'instructions' => 'The link related to the third section',
                    'required' => 1,
                    'conditional_logic' => 0,
                    'wrapper' => array(
                        'width' => '',
                        'class' => '',
                        'id' => '',
                    ),
                    'default_value' => '',
                    'placeholder' => '',
                ),
                array(
                    'key' => 'field_5bb80c8ae45a5',
                    'label' => 'Third Background Image',
                    'name' => 'third_background_image',
                    'type' => 'image',
                    'instructions' => 'The background image for the third featured section',
                    'required' => 1,
                    'conditional_logic' => 0,
                    'wrapper' => array(
                        'width' => '',
                        'class' => '',
                        'id' => '',
                    ),
                    'return_format' => 'array',
                    'preview_size' => 'thumbnail',
                    'library' => 'all',
                    'min_width' => '',
                    'min_height' => '',
                    'min_size' => '',
                    'max_width' => '',
                    'max_height' => '',
                    'max_size' => '',
                    'mime_types' => '',
                ),
            ),
        );
    }
}