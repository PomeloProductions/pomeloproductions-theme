<?php
declare(strict_types=1);

namespace PomeloProductions\Admin;

use Handlebars\Handlebars;
use PomeloProductions\ChildTheme;
use PomeloProductions\Templates\Page\CompositeTemplate;
use wpdb;

/**
 * Class RootController
 * @package Theme\Admin
 */
class RootController
{
    /**
     * @var Handlebars
     */
    private $templateEngine;

    /**
     * @var object
     */
    private $buildManifest;

    /**
     * @var ChildTheme
     */
    private $childTheme;

    /**
     * RootController constructor.
     * @param wpdb $wpdb
     * @param Handlebars $templateEngine
     * @param $buildManifest
     * @param ChildTheme|null $childTheme
     */
    public function __construct(wpdb $wpdb, Handlebars $templateEngine, $buildManifest, ChildTheme $childTheme = null)
    {
        $this->templateEngine = $templateEngine;
        $this->buildManifest = $buildManifest;
        $this->childTheme = $childTheme;

        if (function_exists('acf_add_local_field_group')) {

            acf_add_local_field_group(CompositeTemplate::getACFGroup());

            if ($this->childTheme) {
                $this->childTheme->registerAdmin();
            }
        }

    //    add_action('admin_enqueue_scripts', [$this, 'registerAdminScripts'], 100);
    }

    /**
     * Registers all admin scripts
     *
     */
    public function registerAdminScripts()
    {
        $admin = $this->buildManifest->admin;

        wp_enqueue_script('admin-js', get_template_directory_uri() . "/build/" . $admin->js);
        wp_enqueue_style('admin-css', get_template_directory_uri() . "/build/" . $admin->css);
        add_editor_style( get_template_directory_uri() . "/build/" . $admin->css);
    }
}