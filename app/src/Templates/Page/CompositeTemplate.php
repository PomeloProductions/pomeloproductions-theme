<?php
declare(strict_types=1);

namespace PomeloProductions\Templates\Page;

use Handlebars\Handlebars;
use PomeloProductions\Admin\ACFHelpers\ImageField;
use PomeloProductions\Sections\BackgroundImageOverlay;
use PomeloProductions\Sections\BaseSection;
use PomeloProductions\Sections\Featured;
use PomeloProductions\Sections\FeaturedImage;
use PomeloProductions\Sections\ImageGrid;
use PomeloProductions\Sections\PageTitle;
use PomeloProductions\Sections\Projects;
use PomeloProductions\Sections\Slider;
use PomeloProductions\Sections\SocialMediaIcons;
use PomeloProductions\Sections\Spacer;
use PomeloProductions\Sections\StandardContent;
use PomeloProductions\Sections\ThreeColumn;
use PomeloProductions\Sections\TwoColumn;
use PomeloProductions\Sections\Video;
use PomeloProductions\Templates\BaseTemplate;

/**
 * Class CompositeTemplate
 * @package Theme\Templates\Page
 */
class CompositeTemplate extends BaseTemplate
{
    /**
     * Renders this particular template
     *
     * @param Handlebars $templateEngine
     * @param array $templateVariables
     * @return string
     */
    public function render(Handlebars $templateEngine, array $templateVariables): string
    {
        $pageSectionCount = (int) $this->getOption('page_sections', 0);
        $currentSection = 0;

        $templateVariables['sections'] = [];

        while ($currentSection < $pageSectionCount) {
            /** @var BaseSection $section */
            $section = null;
            $currentKeyName = 'page_sections_' . $currentSection;
            switch ($this->getOption($currentKeyName . '_section_type', '')) {
                case 'background_image_overlay':
                    $currentKeyName.= '_background_image_overlay_editor';

                    $section = new BackgroundImageOverlay(
                        $this->getOption($currentKeyName . '_id', ''),
                        ImageField::getFeaturedImageUrl($this->getOption($currentKeyName . '_background_image', null)),
                        $this->getOption($currentKeyName . '_content', ''),
                        $this->getOption($currentKeyName . '_color', 'white'),
                        $this->getOption($currentKeyName . '_background_color', 'transparent'),
                        $this->getOption($currentKeyName . '_height', '83.3')
                    );
                    break;

                case 'featured_image':
                    $currentKeyName.= '_featured_image_editor';
                    $section = new FeaturedImage(
                        $this->getOption($currentKeyName . '_content', ''),
                        ImageField::getFeaturedImageUrl($this->getOption($currentKeyName . '_image', null))
                    );
                    break;

                case 'featured':
                    $currentKeyName.= '_featured_editor';

                    $section = new Featured(
                        $this->getOption($currentKeyName . '_primary_title', ''),
                        $this->getOption($currentKeyName . '_primary_subtitle', ''),
                        $this->getOption($currentKeyName . '_action_text', ''),
                        $this->getOption($currentKeyName . '_primary_link', ''),
                        ImageField::getFeaturedImageUrl($this->getOption($currentKeyName . '_primary_background_image', null)),
                        $this->getOption($currentKeyName . '_second_title', ''),
                        $this->getOption($currentKeyName . '_second_link', ''),
                        Featured::getSecondaryImageUrl($this->getOption($currentKeyName . '_second_background_image', null)),
                        $this->getOption($currentKeyName . '_third_title', ''),
                        $this->getOption($currentKeyName . '_third_link', ''),
                        Featured::getSecondaryImageUrl($this->getOption($currentKeyName . '_third_background_image', null))
                    );
                    break;

                case 'image_grid':
                    $section = $this->buildImageGridSection($currentKeyName);
                    break;

                case 'page_title':
                    $section = new PageTitle($this->page->post_title, '');
                    break;

                case 'spacer':
                    $currentKeyName.= '_spacer_editor';
                    $section = new Spacer((int)$this->getOption($currentKeyName . '_pixels', 0));
                    break;

                case 'slider':
                    $currentKeyName.= '_slider_editor';
                    $section = new Slider(
                        $this->getOption($currentKeyName . '_slider_shortcode', ''),
                        $this->getOption($currentKeyName . '_featured_style', "1") == "1"
                    );
                    break;

                case 'social_media_icons':
                    $section = new SocialMediaIcons($templateVariables['social_links']);
                    break;

                case 'standard_content':
                    $currentKeyName.= '_standard_content_editor';
                    $section = new StandardContent(
                        $this->getOption($currentKeyName . '_id', ''),
                        $this->getOption($currentKeyName . '_title', ''),
                        $this->getOption($currentKeyName . '_subtitle', ''),
                        $this->getOption($currentKeyName . '_content', ''),
                        $this->getOption($currentKeyName . '_full_width', '0') == '1'
                    );
                    break;

                case 'three_column':
                    $currentKeyName.= '_three_column_editor';
                    $section = new ThreeColumn(
                        $this->getOption($currentKeyName . '_id', ''),
                        $this->getOption($currentKeyName . '_top_content', ''),
                        $this->getOption($currentKeyName . '_row_column_1', ''),
                        $this->getOption($currentKeyName . '_row_column_2', ''),
                        $this->getOption($currentKeyName . '_row_column_3', '')
                    );
                    break;

                case 'two_column':
                    $currentKeyName.= '_two_column_editor';
                    $topContent = $this->getOption($currentKeyName . '_top_content', null);

                    $currentKeyName.= '_columns';
                    $rowCount = (int)$this->getOption($currentKeyName, 0);
                    $currentRow = 0;
                    $rows = [];

                    while ($currentRow < $rowCount) {

                        $rows[] = [
                            'column_1' => $this->getOption($currentKeyName . '_' . $currentRow . '_row_column_1', ''),
                            'column_2' => $this->getOption($currentKeyName . '_' . $currentRow . '_row_column_2', ''),
                            'layout_class' => $this->getOption($currentKeyName . '_' . $currentRow . '_layout_style', '')
                        ];

                        $currentRow++;
                    }

                    $section = new TwoColumn(
                        $this->getOption($currentKeyName . '_id', ''),
                        $topContent,
                        $rows
                    );
                    break;

                case 'projects':
                    $currentKeyName.= '_projects_editor';
                    $section = new Projects(
                        $this->getOption($currentKeyName . '_id', ''),
                        $this->getOption($currentKeyName . '_content', ''),
                    );
                    break;

                case 'video':
                    $currentKeyName.= '_video_editor';
                    $section = new Video(
                        $this->getOption($currentKeyName . '_title', ''),
                        $this->getOption($currentKeyName . '_subtitle', ''),
                        $this->getOption($currentKeyName . '_video_url', ''),
                        Video::getThumbnailImageUrl($this->getOption($currentKeyName . '_thumbnail_url', ''))
                    );
                    break;
            }

            if ($section) {
                $templateVariables['sections'][] = $section->render($templateEngine, $templateVariables);
            }
            $currentSection++;
        }

        $templateVariables['page_content'] = $this->processContentString($this->page->post_content);

        return $templateEngine->render('page/composite', $templateVariables);
    }

    /**
     * Build an image grid section properly
     *
     * @param string $currentKeyName
     * @return ImageGrid
     */
    public function buildImageGridSection(string $currentKeyName) : ImageGrid
    {
        $currentKeyName.= '_image_grid_editor';
        $title = $this->getOption($currentKeyName . '_title', null);
        $subtitle = $this->getOption($currentKeyName . '_subtitle', null);
        $carousel = $this->getOption($currentKeyName . '_carousel', '0') == '1';

        $rows = [];
        $currentKeyName.= '_image_rows';
        $rowCount = (int)$this->getOption($currentKeyName, 0);
        $currentRow = 0;

        while ($currentRow < $rowCount) {
            $rowKeyName = $currentKeyName . '_' . $currentRow;
            $rowLayout = $this->getOption($rowKeyName . '_row_layout', '2');

            $images = [];

            switch ($rowLayout) {
                case '4':
                    $images[] = [
                        'link' => $this->getOption($rowKeyName . '_forth_image_link', null),
                        'src' => ImageGrid::getImageUrl($this->getOption($rowKeyName . '_forth_image', null)) ?? null,
                    ];
                case '3':
                    $images[] = [
                        'link' => $this->getOption($rowKeyName . '_third_image_link', null),
                        'src' => ImageGrid::getImageUrl($this->getOption($rowKeyName . '_third_image', null)) ?? null,
                    ];
                default:
                    $images[] = [
                        'link' => $this->getOption($rowKeyName . '_second_image_link', null),
                        'src' => ImageGrid::getImageUrl($this->getOption($rowKeyName . '_second_image', null)) ?? null,
                    ];
                    $images[] = [
                        'link' => $this->getOption($rowKeyName . '_first_image_link', null),
                        'src' => ImageGrid::getImageUrl($this->getOption($rowKeyName . '_first_image', null)) ?? null,
                    ];
            }

            $rows[] = [
                'class' => $rowLayout,
                'images' => array_reverse($images),
            ];

            $currentRow++;
        }

        return new ImageGrid($title, $rows, $subtitle, $carousel);
    }

    /**
     * Gets all acf fields needed for this template
     *
     * @return array
     */
    public static function getACFGroup()
    {
        return array(
            'key' => 'group_5bb7daabf102c',
            'title' => 'Composite',
            'fields' => array(
                array(
                    'key' => 'field_5bb7daf56ea0c',
                    'label' => 'Page Sections',
                    'name' => 'page_sections',
                    'type' => 'repeater',
                    'instructions' => 'Organize all sections for this page',
                    'required' => 1,
                    'conditional_logic' => 0,
                    'wrapper' => array(
                        'width' => '',
                        'class' => '',
                        'id' => '',
                    ),
                    'collapsed' => 'field_5bb7db296ea0d',
                    'min' => 0,
                    'max' => 0,
                    'layout' => 'block',
                    'button_label' => '',
                    'sub_fields' => array(
                        array(
                            'key' => 'field_5bb7db296ea0d',
                            'label' => 'Section Type',
                            'name' => 'section_type',
                            'type' => 'select',
                            'instructions' => 'Select What type of section this will be',
                            'required' => 1,
                            'conditional_logic' => 0,
                            'wrapper' => array(
                                'width' => '',
                                'class' => '',
                                'id' => '',
                            ),
                            'choices' => array(
                                'background_image_overlay' => 'Background Image With Text Overlay',
                                'featured' => 'Featured Section',
                                'featured_image' => 'Featured Image',
                                'full_width_cta' => 'Full Width CTA',
                                'image_grid' => 'Image Grid',
                                'page_title' => 'Page Title',
                                'sign_up' => 'Sign Up',
                                'slider' => 'Slider',
                                'spacer' => 'Spacer',
                                'social_media_icons' => 'Social Media Icons',
                                'standard_content' => 'Single Column Content Section',
                                'three_column' => 'Three Column Content Section',
                                'two_column' => 'Two Column Content Section',
                                'projects' => 'Projects',
                                'video' => 'Video',
                            ),
                            'default_value' => array(),
                            'allow_null' => 0,
                            'multiple' => 0,
                            'ui' => 0,
                            'return_format' => 'value',
                            'ajax' => 0,
                            'placeholder' => '',
                        ),
                        BackgroundImageOverlay::getACFGroup(array(
                            array(
                                array(
                                    'field' => 'field_5bb7db296ea0d',
                                    'operator' => '==',
                                    'value' => 'background_image_overlay',
                                ),
                            ),
                        )),
                        Featured::getACFGroup(array(
                            array(
                                array(
                                    'field' => 'field_5bb7db296ea0d',
                                    'operator' => '==',
                                    'value' => 'featured',
                                ),
                            ),
                        )),
                        FeaturedImage::getACFGroup(array(
                            array(
                                array(
                                    'field' => 'field_5bb7db296ea0d',
                                    'operator' => '==',
                                    'value' => 'featured_image',
                                ),
                            ),
                        )),
                        ImageGrid::getACFGroup(array(
                            array(
                                array(
                                    'field' => 'field_5bb7db296ea0d',
                                    'operator' => '==',
                                    'value' => 'image_grid',
                                ),
                            ),
                        )),
                        Slider::getACFGroup(array(
                            array(
                                array(
                                    'field' => 'field_5bb7db296ea0d',
                                    'operator' => '==',
                                    'value' => 'slider',
                                ),
                            ),
                        )),
                        Spacer::getACFGroup(array(
                            array(
                                array(
                                    'field' => 'field_5bb7db296ea0d',
                                    'operator' => '==',
                                    'value' => 'spacer',
                                ),
                            ),
                        )),
                        StandardContent::getACFGroup(array(
                            array(
                                array(
                                    'field' => 'field_5bb7db296ea0d',
                                    'operator' => '==',
                                    'value' => 'standard_content',
                                ),
                            ),
                        )),
                        ThreeColumn::getACFGroup(array(
                            array(
                                array(
                                    'field' => 'field_5bb7db296ea0d',
                                    'operator' => '==',
                                    'value' => 'three_column',
                                ),
                            ),
                        )),
                        TwoColumn::getACFGroup(array(
                            array(
                                array(
                                    'field' => 'field_5bb7db296ea0d',
                                    'operator' => '==',
                                    'value' => 'two_column',
                                ),
                            ),
                        )),
                        Projects::getACFGroup(array(
                            array(
                                array(
                                    'field' => 'field_5bb7db296ea0d',
                                    'operator' => '==',
                                    'value' => 'projects',
                                ),
                            ),
                        )),
                        Video::getACFGroup(array(
                            array(
                                array(
                                    'field' => 'field_5bb7db296ea0d',
                                    'operator' => '==',
                                    'value' => 'video',
                                ),
                            ),
                        )),
                    ),
                ),
            ),
            'location' => array(
                array(
                    array(
                        'param' => 'page_template',
                        'operator' => '==',
                        'value' => 'page-composite.php',
                    ),
                ),
            ),
            'menu_order' => 0,
            'position' => 'normal',
            'style' => 'seamless',
            'label_placement' => 'top',
            'instruction_placement' => 'label',
            'hide_on_screen' => array(
                0 => 'the_content',
                1 => 'excerpt',
                2 => 'comments',
                3 => 'featured_image',
            ),
            'active' => 1,
            'description' => '',
        );
    }
}