<?php
declare(strict_types=1);

namespace PomeloProductions\Sections;

use Handlebars\Handlebars;
use PomeloProductions\Admin\ACFHelpers\TextField;
use PomeloProductions\Admin\ACFHelpers\TrueFalseField;

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
    public static function getACFGroup(array $conditionalLogic) : array
    {
        return array(
            'key' => 'field_5bb7e5be2a99f',
            'label' => 'Image Grid Editor',
            'name' => 'image_grid_editor',
            'type' => 'group',
            'instructions' => 'Configure this image grid',
            'required' => 0,
            'conditional_logic' => $conditionalLogic,
            'wrapper' => array(
                'width' => '',
                'class' => '',
                'id' => '',
            ),
            'layout' => 'block',
            'sub_fields' => array(
                (new TextField('field_5bb7e7e62a9a1', 'title', 'Enter the title for the gird, or leave blank if you do not want one.'))
                    ->export(),
                (new TextField('field_5bb7e848fa1f8', 'subtitle', ''))
                    ->export(),
                (new TrueFalseField('field_rueghowugh', 'carousel', ''))
                    ->setDefaultValue('0')
                    ->export(),
                array(
                    'key' => 'field_5bb7e85ffa1f9',
                    'label' => 'Image Rows',
                    'name' => 'image_rows',
                    'type' => 'repeater',
                    'instructions' => '',
                    'required' => 1,
                    'conditional_logic' => 0,
                    'wrapper' => array(
                        'width' => '',
                        'class' => '',
                        'id' => '',
                    ),
                    'collapsed' => '',
                    'min' => 0,
                    'max' => 0,
                    'layout' => 'table',
                    'button_label' => '',
                    'sub_fields' => array(
                        array(
                            'key' => 'field_5bb7e8d1e2ea3',
                            'label' => 'Row Layout',
                            'name' => 'row_layout',
                            'type' => 'select',
                            'instructions' => 'Select the layout for this row',
                            'required' => 1,
                            'conditional_logic' => 0,
                            'wrapper' => array(
                                'width' => '',
                                'class' => '',
                                'id' => '',
                            ),
                            'choices' => array(
                                2 => 'Two images across',
                                3 => 'Three images across',
                                4 => 'Four Images across',
                            ),
                            'default_value' => array(
                            ),
                            'allow_null' => 0,
                            'multiple' => 0,
                            'ui' => 0,
                            'return_format' => 'value',
                            'ajax' => 0,
                            'placeholder' => '',
                        ),
                        array(
                            'key' => 'field_5bb7e926e2ea4',
                            'label' => 'First Image',
                            'name' => 'first_image',
                            'type' => 'image',
                            'instructions' => 'Select the first image to show. You should probably only use square images.',
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
                            'key' => 'field_5bb7f148c9dd7',
                            'label' => 'First Image Link',
                            'name' => 'first_image_link',
                            'type' => 'url',
                            'instructions' => 'Enter an optional link to take the user to when they click on the image.',
                            'required' => 0,
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
                            'key' => 'field_5bb7e991e2ea5',
                            'label' => 'Second Image',
                            'name' => 'second_image',
                            'type' => 'image',
                            'instructions' => 'Select the second image to show. You should probably only use square images.',
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
                            'key' => 'field_5bb7f1adc9dd8',
                            'label' => 'Second Image Link',
                            'name' => 'second_image_link',
                            'type' => 'url',
                            'instructions' => 'Enter an optional link to take the user to when they click on the image.',
                            'required' => 0,
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
                            'key' => 'field_5bb7e9afe2ea6',
                            'label' => 'Third Image',
                            'name' => 'third_image',
                            'type' => 'image',
                            'instructions' => 'Select the third image to show. You should probably only use square images.',
                            'required' => 1,
                            'conditional_logic' => array(
                                array(
                                    array(
                                        'field' => 'field_5bb7e8d1e2ea3',
                                        'operator' => '==',
                                        'value' => '3',
                                    ),
                                ),
                                array(
                                    array(
                                        'field' => 'field_5bb7e8d1e2ea3',
                                        'operator' => '==',
                                        'value' => '4',
                                    ),
                                ),
                            ),
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
                            'key' => 'field_5bb7f1c6c9dd9',
                            'label' => 'Third Image Link',
                            'name' => 'third_image_link',
                            'type' => 'url',
                            'instructions' => 'Enter an optional link to take the user to when they click on the image.',
                            'required' => 0,
                            'conditional_logic' => array(
                                array(
                                    array(
                                        'field' => 'field_5bb7e8d1e2ea3',
                                        'operator' => '==',
                                        'value' => '3',
                                    ),
                                ),
                                array(
                                    array(
                                        'field' => 'field_5bb7e8d1e2ea3',
                                        'operator' => '==',
                                        'value' => '4',
                                    ),
                                ),
                            ),
                            'wrapper' => array(
                                'width' => '',
                                'class' => '',
                                'id' => '',
                            ),
                            'default_value' => '',
                            'placeholder' => '',
                        ),
                        array(
                            'key' => 'field_5bb7e9e2e2ea8',
                            'label' => 'Forth Image',
                            'name' => 'forth_image',
                            'type' => 'image',
                            'instructions' => 'Select the forth image to show. You should probably only use square images.',
                            'required' => 1,
                            'conditional_logic' => array(
                                array(
                                    array(
                                        'field' => 'field_5bb7e8d1e2ea3',
                                        'operator' => '==',
                                        'value' => '4',
                                    ),
                                ),
                            ),
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
                            'key' => 'field_5bb7f273c9ddc',
                            'label' => 'Forth Image Link',
                            'name' => 'forth_image_link',
                            'type' => 'url',
                            'instructions' => 'Enter an optional link to take the user to when they click on the image.',
                            'required' => 0,
                            'conditional_logic' => array(
                                array(
                                    array(
                                        'field' => 'field_5bb7e8d1e2ea3',
                                        'operator' => '==',
                                        'value' => '4',
                                    ),
                                ),
                            ),
                            'wrapper' => array(
                                'width' => '',
                                'class' => '',
                                'id' => '',
                            ),
                            'default_value' => '',
                            'placeholder' => '',
                        ),
                    ),
                ),
            ),
        );
    }
}