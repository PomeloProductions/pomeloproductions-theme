<?php
declare(strict_types=1);

namespace PomeloProductions;

use Handlebars\Handlebars;
use Handlebars\Loader\FilesystemLoader;
use PomeloProductions\Admin\RootController;
use PomeloProductions\Navigation\Footer;
use PomeloProductions\Navigation\Main;
use PomeloProductions\Templates\BaseTemplate;
use PomeloProductions\Templates\DefaultTemplate;
use PomeloProductions\Templates\Page\CompositeTemplate;
use PomeloProductions\Templates\Page\SplashTemplate;
use PomeloProductions\ThemeCustomizers\SocialMedia;
use PomeloProductions\Utility\OptionsManager;
use WP_Post;

/**
 * Class Theme
 * @package Theme
 */
class Theme
{
    /**
     * @var Handlebars
     */
    private $templateEngine;

    /**
     * @var Main
     */
    private $mainNavigation;

    /**
     * @var Footer
     */
    private $footerNavigation;

    /**
     * @var SocialMedia
     */
    private $socialMediaSettings;

    /**
     * @var OptionsManager
     */
    private $optionsManager;

    /**
     * @var WP_Post[]
     */
    private $mainNavigationPages;

    /**
     * Theme constructor.
     */
    public function __construct()
    {
        $this->templateEngine = new Handlebars([
            'loader' => new FilesystemLoader(__DIR__ . '/../resources/handlebars'),
            'partials_loader' => new FilesystemLoader(__DIR__ . '/../resources/handlebars/partials')
        ]);

        $this->optionsManager = new OptionsManager();

        $this->mainNavigation = new Main();
        $this->footerNavigation = new Footer();
        $this->socialMediaSettings = new SocialMedia();
    }

    /**
     * Registers theme core functionality
     */
    public function register()
    {
        $this->mainNavigation->registrationNavigation();
        $this->footerNavigation->registrationNavigation();

        add_action('wp_enqueue_scripts', [$this, 'registerScripts'], 100);
        add_action('customize_register', [$this, 'registerCustomizers']);
        add_action('admin_menu', [$this, 'initAdmin']);
        add_filter('upload_mimes', [$this, 'filterMimeTypes']);
    }

    /**
     * Inits the admin properly
     */
    public function initAdmin()
    {
        global $wpdb;

        new RootController($wpdb, $this->templateEngine, $this->loadBuildManifest());
    }

    /**
     * Enables svg uploads
     *
     * @param $mimeTypes
     * @return mixed
     */
    public function filterMimeTypes($mimeTypes)
    {
        $mimeTypes['svg'] = 'application/svg+xml';
        $mimes['svgz'] = 'application/svg+xml';
        return $mimeTypes;
    }

    /**
     * Loads the build manifest from file
     *
     * @return object
     */
    private function loadBuildManifest()
    {
        return json_decode(file_get_contents(__DIR__ . '/../../build/assets.json'));
    }

    /**
     * Registers all scripts to load properly within wordpress
     */
    public function registerScripts()
    {
        $manifest = $this->loadBuildManifest();
        $main = $manifest->main;
        wp_enqueue_style('theme-css', get_template_directory_uri() . "/build/" . $main->css);
        wp_enqueue_script('theme-js', get_template_directory_uri() . "/build/" . $main->js);
    }

    /**
     * Registers admin functionality
     * @param \WP_Customize_Manager $customizer
     */
    public function registerCustomizers(\WP_Customize_Manager $customizer)
    {
        $this->socialMediaSettings->register($customizer);
    }

    /**
     * Shows a single wordpress page
     *
     * @param \WP_Post $page
     * @return string
     */
    public function showPage(\WP_Post $page)
    {
        $template = null;

        $template = $this->buildPageTemplate($page);

        $baseTemplateVariables = [
            'theme_url' => get_template_directory_uri()
        ];

        $pageContent = $this->renderHeader($baseTemplateVariables, $template);
        $pageContent.= $template->render($this->templateEngine, $baseTemplateVariables);
        $pageContent.= $this->renderFooter($baseTemplateVariables);

        return $pageContent;
    }

    /**
     * Gets all options for a page
     *
     * @param WP_Post $page
     * @return array
     */
    public function getPageOptions(WP_Post $page) : array
    {
        $meta = get_post_meta($page->ID);
        $options = [];
        foreach ($meta as $key => $field) {
            $options[$key] = count($field) == 1 ? $field[0] : $field;
        }

        return $options;
    }

    /**
     * Builds the template needed for a post
     *
     * @param WP_Post $page
     * @return BaseTemplate
     */
    public function buildPageTemplate(WP_Post $page) : BaseTemplate
    {
        $options = $this->getPageOptions($page);

        switch ($page->page_template) {
            case 'page-composite.php':
                return new CompositeTemplate($this, $page, $options);
            case 'page-splash.php':
                return new SplashTemplate($this, $page, $options);
        }

        return new DefaultTemplate($this, $page, $options);
    }

    /**
     * Renders the header properly
     *
     * @param $templateVariables
     * @return string
     */
    private function renderHeader($templateVariables, BaseTemplate $template)
    {
        $templateVariables['language_attributes'] = get_language_attributes();
        $templateVariables['charset'] = get_bloginfo('charset');

        ob_start();
        wp_head();
        $wpHead = ob_get_clean();

        $templateVariables['wp_head'] = $wpHead;
        $templateVariables['stylesheet_url'] = get_stylesheet_uri();
        $templateVariables['title'] = get_the_title();
        $templateVariables['body_class'] = join(" ", get_body_class());

        $templateVariables['has_header'] = $

        $templateVariables['navigation'] = $this->mainNavigation->getNavigationItems();

        return $this->templateEngine->render('header', $templateVariables);
    }

    /**
     * Renders the footer properly
     *
     * @param $templateVariables
     * @return string
     */
    public function renderFooter($templateVariables)
    {
        ob_start();
        wp_footer();
        $wpFooter = ob_get_clean();

        $templateVariables['wp_footer'] = $wpFooter;
        $templateVariables['analytics_key'] = '';

        $templateVariables['navigation'] = $this->footerNavigation->getNavigationItems();
        $templateVariables['year'] = date('Y');
        $templateVariables['social_links'] = $this->socialMediaSettings->getSocialLinks($this->optionsManager);

        return $this->templateEngine->render('footer', $templateVariables);
    }

    /**
     * @return Handlebars
     */
    public function getTemplateEngine(): Handlebars
    {
        return $this->templateEngine;
    }

    /**
     * Returns all items in the main navigation
     *
     * @return WP_Post[]
     */
    public function getMainNavigationPages()
    {
        if (!$this->mainNavigationPages) {
            $this->mainNavigationPages = [];

            foreach ($this->mainNavigation->getNavigationItems() as $item) {
                $pageId = get_post_meta( $item->ID, '_menu_item_object_id', true );
                $this->mainNavigationPages[] = get_post($pageId);
            }
        }
        return $this->mainNavigationPages;
    }
}