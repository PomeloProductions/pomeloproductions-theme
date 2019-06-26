<?php
declare(strict_types=1);

namespace PomeloProductions\Sections;

use Handlebars\Handlebars;
use PomeloProductions\Admin\ACFHelpers\TextField;
use PomeloProductions\Admin\ACFHelpers\WYSIWYGField;

/**
 * Class Projects
 * @package Theme\Sections
 */
class Projects extends BaseSection
{
    /**
     * @var string
     */
    private $id;

    /**
     * @var string
     */
    private $content;

    /**
     * Projects constructor.
     * @param string $id
     * @param string $content
     */
    public function __construct(string $id, string $content)
    {
        $this->id = $id;
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
        $templateVariables['id'] = $this->id;
        $templateVariables['content'] = $this->processContentString($this->content);

        $query = new \WP_Query([
            'post_type' => 'projects',
            'posts_per_page' => 100,
        ]);

        $projects = $query->get_posts();

        shuffle($projects);

        $templateVariables['projects'] = [];

        for ($x = 0; $x < ceil(count($projects) / 3); $x++) {

            $projectsRow = [];

            for ($y = 0; $y < (count($projects) - $x * 3) && $y < 3; $y++) {

                $project = $projects[($x * 3) + $y];
                $postMeta = get_post_meta($project->ID);
                $links = [];

                if (isset($postMeta['project_remote_information_website']) && $postMeta['project_remote_information_website']) {
                    $links['website'] = $postMeta['project_remote_information_website'][0];
                }
                if (isset($postMeta['project_remote_information_android']) && $postMeta['project_remote_information_android']) {
                    $links['android'] = $postMeta['project_remote_information_android'][0];
                }
                if (isset($postMeta['project_remote_information_ios']) && $postMeta['project_remote_information_ios']) {
                    $links['ios'] = $postMeta['project_remote_information_ios'][0];
                }
                if (isset($postMeta['project_remote_information_github']) && $postMeta['project_remote_information_github']) {
                    $links['github'] = $postMeta['project_remote_information_github'][0];
                }

                $projectsRow[] = [
                    'title' => $project->post_title,
                    'content' => $this->processContentString($project->post_content),
                    'links' => $links,
                ];
            }

            $templateVariables['projects'][] = $projectsRow;
        }

        $templateVariables['multiple_rows'] = count($templateVariables['projects']);

        return $templateEngine->render('sections/projects', $templateVariables);
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
            'key' => 'field_rehergee459a',
            'label' => 'Projects',
            'name' => 'projects_editor',
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
                (new TextField('field_eiu45tgh4b', 'id', 'The optional id for the section if this section should respond to link clicks'))->export(),
                (new WYSIWYGField('field_6generegergwe43', 'content', 'Enter any content above the listed projects'))
                    ->export(),
            ),
        );
    }
}