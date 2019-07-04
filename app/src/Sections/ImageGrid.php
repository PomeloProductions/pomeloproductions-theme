<?php
declare(strict_types=1);

namespace PomeloProductions\Sections;

use Handlebars\Handlebars;
use PomeloProductions\Admin\ACFHelpers\Fields\GroupField;
use PomeloProductions\Admin\ACFHelpers\Fields\ImageField;
use PomeloProductions\Admin\ACFHelpers\Fields\RepeaterField;
use PomeloProductions\Admin\ACFHelpers\Fields\SelectField;
use PomeloProductions\Admin\ACFHelpers\Fields\TextField;
use PomeloProductions\Admin\ACFHelpers\Fields\TrueFalseField;
use PomeloProductions\Admin\ACFHelpers\Fields\URLField;

/**
 * Class ImageGrid
 * @package Theme\Sections
 */
class ImageGrid extends BaseSection
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
    private $content;

    /**
     * @var array
     */
    private $rows;

    /**
     * @var bool
     */
    private $carousel;

    /**
     * ImageGrid constructor.
     * @param string $title
     * @param array $rows
     * @param string|null $subtitle
     * @param bool $carousel
     * @param string|null $content
     */
    public function __construct(?string $title, array $rows,
                                string $subtitle = null, bool $carousel = false, string $content = null)
    {
        $this->title = $title;
        $this->rows = $rows;
        $this->subtitle = $subtitle;
        $this->carousel = $carousel;
        $this->content = $content;
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
        $templateVariables['content'] = $this->content;
        $templateVariables['rows'] = $this->rows;
        $templateVariables['carousel'] = $this->carousel;

        return $templateEngine->render('sections/image-grid', $templateVariables);
    }

    /**
     * Gets an image url based on an attachment id
     *
     * @param int $attachmentId
     * @return string|null
     */
    public static function getImageUrl($attachmentId)
    {
        $image = wp_get_attachment_image_src($attachmentId, ['588', '588']);

        return $image ? $image[0] : null;
    }

    /**
     * Gets all acf fields for this section
     *
     * @param array $conditionalLogic
     * @return array
     */
    public static function getACFGroup(array $conditionalLogic) : GroupField
    {
        $field = new GroupField('field_5bb7e5be2a99f', 'image_grid_editor', 'Configure this image grid');
        $field->setConditionalLogic($conditionalLogic);

        $field->addSubField(new TextField('field_5bb7e7e62a9a1', 'title', 'Enter the title for the gird, or leave blank if you do not want one.'));
        $field->addSubField(new TextField('field_5bb7e848fa1f8', 'subtitle', ''));
        $field->addSubField(
            (new TrueFalseField('field_rueghowugh', 'carousel', ''))
                ->setDefaultValue('0')
        );

        $imageRepeater = new RepeaterField('field_5bb7e85ffa1f9', 'image_rows', '');

        $imageRepeater->setLayout('table');
        $imageRepeater->setRequired();

        $imageRepeater->addSubField(
            (new SelectField('field_5bb7e8d1e2ea3', 'row_layout', 'Select the layout for this row', [
                2 => 'Two images across',
                3 => 'Three images across',
                4 => 'Four Images across',
            ]))
                ->setRequired()
                ->setAllowNull(false)
        );

        $imageRepeater->addSubField(
            (new ImageField('field_5bb7e926e2ea4', 'first_image', 'Select the first image to show. You should probably only use square images.'))
                ->setRequired()
        );
        $imageRepeater->addSubField(
            new URLField('field_5bb7f148c9dd7', 'first_image_link', 'Enter an optional link to take the user to when they click on the image.')
        );

        $imageRepeater->addSubField(
            (new ImageField('field_5bb7e991e2ea5', 'second_image', 'Select the second image to show. You should probably only use square images.'))
                ->setRequired()
        );
        $imageRepeater->addSubField(
            new URLField('field_5bb7f1adc9dd8', 'second_image_link', 'Enter an optional link to take the user to when they click on the image.')
        );

        $imageRepeater->addSubField(
            (new ImageField('field_5bb7e9afe2ea6', 'third_image', 'Select the third image to show. You should probably only use square images.'))
                ->setRequired()
                ->setConditionalLogic([
                    [
                        [
                            'field' => 'field_5bb7e8d1e2ea3',
                            'operator' => '==',
                            'value' => '3',
                        ],
                    ],
                    [
                        [
                            'field' => 'field_5bb7e8d1e2ea3',
                            'operator' => '==',
                            'value' => '4',
                        ],
                    ]
                ])
        );
        $imageRepeater->addSubField(
            (new URLField('field_5bb7f1c6c9dd9', 'third_image_link', 'Enter an optional link to take the user to when they click on the image.'))
                ->setConditionalLogic([
                    [
                        [
                            'field' => 'field_5bb7e8d1e2ea3',
                            'operator' => '==',
                            'value' => '3',
                        ],
                    ],
                    [
                        [
                            'field' => 'field_5bb7e8d1e2ea3',
                            'operator' => '==',
                            'value' => '4',
                        ],
                    ]
                ])
        );

        $imageRepeater->addSubField(
            (new ImageField('field_5bb7e9e2e2ea8', 'forth_image', 'Select the forth image to show. You should probably only use square images.'))
                ->setRequired()
                ->setConditionalLogic([
                    [
                        [
                            'field' => 'field_5bb7e8d1e2ea3',
                            'operator' => '==',
                            'value' => '4',
                        ],
                    ]
                ])
        );
        $imageRepeater->addSubField(
            (new URLField('field_5bb7f273c9ddc', 'forth_image_link', 'Enter an optional link to take the user to when they click on the image.'))
                ->setConditionalLogic([
                    [
                        [
                            'field' => 'field_5bb7e8d1e2ea3',
                            'operator' => '==',
                            'value' => '4',
                        ],
                    ]
                ])
        );

        $field->addSubField($imageRepeater);

        return $field;
    }
}