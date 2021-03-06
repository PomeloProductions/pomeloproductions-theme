<?php
declare(strict_types=1);

namespace PomeloProductions\Sections;

use Handlebars\Handlebars;
use PomeloProductions\Admin\ACFHelpers\Fields\GroupField;
use PomeloProductions\Admin\ACFHelpers\Fields\ImageField;
use PomeloProductions\Admin\ACFHelpers\Fields\TextField;

/**
 * Class Video
 * @package Theme\Sections
 */
class Video extends BaseSection
{
    /**
     * @var string
     */
    private $title;

    /**
     * @var string
     */
    private $subtitle;

    /**
     * @var string
     */
    private $videoURL;

    /**
     * @var string
     */
    private $thumbnailURL;

    /**
     * Video constructor.
     * @param string $title
     * @param string $subtitle
     * @param string $videoURL
     * @param string $thumbnailURL
     */
    public function __construct(string $title, string $subtitle, string $videoURL, string $thumbnailURL)
    {
        $this->title = $title;
        $this->subtitle = $subtitle;
        $this->videoURL = $videoURL;
        $this->thumbnailURL = $thumbnailURL;
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
        $templateVariables['title'] = $this->title;
        $templateVariables['subtitle'] = $this->subtitle;
        $templateVariables['video_url'] = $this->videoURL;
        $templateVariables['thumbnail_url'] = $this->thumbnailURL;

        return $templateEngine->render('sections/video', $templateVariables);
    }

    /**
     * Gets an image url based on an attachment id
     *
     * @param int $attachmentId
     * @return string|null
     */
    public static function getThumbnailImageUrl($attachmentId)
    {
        $image = wp_get_attachment_image_src($attachmentId, ['1920', '1080']);

        return $image ? $image[0] : null;
    }

    /**
     * Gets the acf fields required for this section
     *
     * @param array $conditionalLogic
     * @return GroupField
     */
    public static function getACFGroup(array $conditionalLogic) : GroupField
    {
        $field = new GroupField('field_5bregrg452be459a', 'video_editor', '');

        $field->setConditionalLogic($conditionalLogic);

        $field->addSubField(
            new TextField('field_645erihwe43', 'title', 'Enter a title for this video')
        );
        $field->addSubField(
            new TextField('field_6hwe43', 'subtitle', 'Enter a subtitle for this video')
        );
        $field->addSubField(
            (new TextField('field_6hwe4343rfs', 'video_url', 'Enter the url for this video. This url should preferably be a MP4.'))
                ->setRequired()
        );
        $field->addSubField(
            new ImageField('field_43gv3e4ewg', 'thumbnail_url', 'Upload an image to use as the thumbnail')
        );

        return $field;
    }
}