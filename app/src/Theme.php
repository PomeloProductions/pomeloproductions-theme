<?php
declare(strict_types=1);

namespace PomeloProductions;

use Handlebars\Handlebars;
use Handlebars\Loader\FilesystemLoader;
use PomeloProductions\Admin\RootController;
use PomeloProductions\Contracts\UsesChildTemplateEngineContract;
use PomeloProductions\Navigation\Footer;
use PomeloProductions\Navigation\Main;
use PomeloProductions\Templates\BaseTemplate;
use PomeloProductions\Templates\DefaultTemplate;
use PomeloProductions\Templates\Page\CompositeTemplate;
use PomeloProductions\Templates\Page\SplashTemplate;
use PomeloProductions\Templates\PostsTemplate;
use PomeloProductions\ThemeCustomizers\SocialMedia;
use PomeloProductions\Utility\OptionsManager;
use WP_Post;

/**
 * Class Theme
 * @package PomeloProductions
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
     * @var ChildTheme
     */
    private $childTheme;

    /**
     * @var string
     */
    private $buildAssetsDirectory;

    /**
     * @var string
     */
    private $publicBuildDirectory;

    /**
     * Theme constructor.
     */
    public function __construct()
    {
        $this->templateEngine = $this->buildTemplateEngine(__DIR__);

        $this->optionsManager = new OptionsManager();

        $this->mainNavigation = new Main();
        $this->footerNavigation = new Footer();
        $this->socialMediaSettings = new SocialMedia();
        $this->buildAssetsDirectory = __DIR__ . '/../../build/';
        $this->publicBuildDirectory = get_template_directory_uri() . "/build/";
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
        add_filter('wp_handle_upload_prefilter', [$this, 'sanitizeSvgUpload']);
    }

    /**
     * @param string $buildAssetsDirectory
     */
    public function setBuildAssetsDirectory(string $buildAssetsDirectory): void
    {
        $this->buildAssetsDirectory = $buildAssetsDirectory;
    }

    /**
     * @param ChildTheme $childTheme
     */
    public function setChildTheme(ChildTheme $childTheme)
    {
        $this->childTheme = $childTheme;
    }

    /**
     * @param string $publicBuildDirectory
     */
    public function setPublicBuildDirectory(string $publicBuildDirectory): void
    {
        $this->publicBuildDirectory = $publicBuildDirectory;
    }

    /**
     * @param $directory
     * @return Handlebars
     */
    public function buildTemplateEngine($directory)
    {
        return new Handlebars([
            'loader' => new FilesystemLoader($directory . '/../resources/handlebars'),
            'partials_loader' => new FilesystemLoader($directory . '/../resources/handlebars/partials')
        ]);
    }

    /**
     * Inits the admin properly
     */
    public function initAdmin()
    {
        global $wpdb;

        new RootController($wpdb, $this->templateEngine, $this->loadBuildManifest(__DIR__), $this->childTheme);
    }

    /**
     * Enables svg uploads
     *
     * Uploaded SVGs are sanitized on the way in via sanitizeSvgUpload() below,
     * which strips scripts, event handlers, external references and XXE vectors.
     *
     * @param $mimeTypes
     * @return mixed
     */
    public function filterMimeTypes($mimeTypes)
    {
        $mimeTypes['svg'] = 'image/svg+xml';
        $mimeTypes['svgz'] = 'image/svg+xml';
        return $mimeTypes;
    }

    /**
     * Sanitizes SVG files on upload.
     *
     * WordPress does not sanitize SVGs natively, so an uploaded SVG can carry
     * inline <script>, on* event handlers, javascript: URIs or external entity
     * references and become a stored-XSS / XXE vector. This prefilter rewrites
     * the file's contents in place, removing those dangerous constructs before
     * the upload is persisted. Non-SVG uploads pass through untouched.
     *
     * @param array $file The $_FILES entry being processed by WordPress.
     * @return array
     */
    public function sanitizeSvgUpload($file)
    {
        if (empty($file['tmp_name']) || empty($file['type'])) {
            return $file;
        }

        $isSvg = $file['type'] === 'image/svg+xml'
            || $file['type'] === 'application/svg+xml'
            || (isset($file['name']) && preg_match('/\.svgz?$/i', $file['name']));

        if (!$isSvg) {
            return $file;
        }

        $contents = @file_get_contents($file['tmp_name']);

        if ($contents === false || $contents === '') {
            $file['error'] = 'The uploaded SVG could not be read for sanitization.';
            return $file;
        }

        $sanitized = $this->sanitizeSvgMarkup($contents);

        if ($sanitized === null) {
            $file['error'] = 'The uploaded SVG is invalid and could not be sanitized.';
            return $file;
        }

        if (@file_put_contents($file['tmp_name'], $sanitized) === false) {
            $file['error'] = 'The uploaded SVG could not be sanitized.';
        }

        return $file;
    }

    /**
     * Strips dangerous constructs out of an SVG document.
     *
     * Removes <script> elements, inline event handlers (on*), javascript:
     * URIs, external references (xlink:href / href to remote resources) and
     * blocks DOCTYPE/entity declarations to prevent XXE. Returns null when the
     * markup cannot be parsed as XML.
     *
     * @param string $markup
     * @return string|null
     */
    private function sanitizeSvgMarkup(string $markup)
    {
        // Reject documents that declare a DOCTYPE/entities (XXE vector).
        if (preg_match('/<!DOCTYPE/i', $markup) || preg_match('/<!ENTITY/i', $markup)) {
            return null;
        }

        $previousErrors = libxml_use_internal_errors(true);
        $previousEntityLoader = null;
        if (function_exists('libxml_disable_entity_loader')) {
            // Deprecated in PHP 8+, but harmless and protective on older stacks.
            $previousEntityLoader = libxml_disable_entity_loader(true);
        }

        $document = new \DOMDocument();
        $loaded = $document->loadXML($markup, LIBXML_NONET | LIBXML_NOENT);

        if (!$loaded) {
            libxml_clear_errors();
            libxml_use_internal_errors($previousErrors);
            if ($previousEntityLoader !== null && function_exists('libxml_disable_entity_loader')) {
                libxml_disable_entity_loader($previousEntityLoader);
            }
            return null;
        }

        $xpath = new \DOMXPath($document);

        // Remove <script> elements wholesale.
        $scripts = $xpath->query('//*[local-name()="script"]');
        if ($scripts !== false) {
            foreach (iterator_to_array($scripts) as $script) {
                if ($script->parentNode) {
                    $script->parentNode->removeChild($script);
                }
            }
        }

        // Strip dangerous attributes from every element.
        $elements = $xpath->query('//*');
        if ($elements !== false) {
            foreach ($elements as $element) {
                if (!$element->hasAttributes()) {
                    continue;
                }

                foreach (iterator_to_array($element->attributes) as $attribute) {
                    $name = strtolower($attribute->nodeName);
                    $value = $attribute->nodeValue;
                    $localName = strtolower($attribute->localName);

                    // Inline event handlers (onload, onclick, ...).
                    if (strpos($name, 'on') === 0) {
                        $element->removeAttributeNode($attribute);
                        continue;
                    }

                    $normalizedValue = preg_replace('/\s+/', '', (string) $value);

                    // javascript: / data: URIs in any reference attribute.
                    if (preg_match('/^(javascript|vbscript|data):/i', $normalizedValue)) {
                        $element->removeAttributeNode($attribute);
                        continue;
                    }

                    // External references via href / xlink:href.
                    if (($localName === 'href') && preg_match('#^(https?:)?//#i', $normalizedValue)) {
                        $element->removeAttributeNode($attribute);
                        continue;
                    }
                }
            }
        }

        $output = $document->saveXML();

        libxml_clear_errors();
        libxml_use_internal_errors($previousErrors);
        if ($previousEntityLoader !== null && function_exists('libxml_disable_entity_loader')) {
            libxml_disable_entity_loader($previousEntityLoader);
        }

        return $output === false ? null : $output;
    }

    /**
     * Loads the build manifest from file
     *
     * @return object
     */
    private function loadBuildManifest()
    {
        return json_decode(file_get_contents($this->buildAssetsDirectory . 'assets.json'));
    }

    /**
     * Registers all scripts to load properly within wordpress
     */
    public function registerScripts()
    {
        if (!$this->childTheme || !$this->childTheme->registerScripts()) {
            $manifest = $this->loadBuildManifest(__DIR__);
            $main = $manifest->main;
            wp_enqueue_style('theme-css', $this->publicBuildDirectory . $main->css);
            wp_enqueue_script('theme-js', $this->publicBuildDirectory . $main->js);
        }
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
     * @param int $statusCode
     * @return string
     */
    public function showError(int $statusCode)
    {
        status_header($statusCode);

        $baseTemplateVariables = [
            'theme_url' => get_template_directory_uri(),
            'social_links' => $this->socialMediaSettings->getSocialLinks($this->optionsManager),
            'header_image' => get_header_image(),
        ];

        $pageContent = $this->renderHeader($baseTemplateVariables);
        $pageContent.= $this->templateEngine->render('default', [
            'page_content' => '<h1 id="error-code">' . $statusCode . '</h1>',
        ]);
        $pageContent.= $this->renderFooter($baseTemplateVariables);

        return $pageContent;
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
        if ($template instanceof UsesChildTemplateEngineContract) {
            $pageContent.= $template->render($this->childTheme->templateEngine, $baseTemplateVariables);
        } else {
            $pageContent.= $template->render($this->templateEngine, $baseTemplateVariables);
        }
        $pageContent.= $this->renderFooter($baseTemplateVariables, $template);

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

        if ($this->childTheme) {
            $template = $this->childTheme->buildPageTemplate($page, $options);

            if ($template) {
                return $template;
            }
        }

        switch ($page->page_template) {
            case 'page-composite.php':
                return new CompositeTemplate($this, $page, $options);
            case 'page-splash.php':
                return new SplashTemplate($this, $page, $options);
        }
        // WordPress is dumb, but you already knew that
        // This doesn't check for the home page, but instead checks for the blog index
        if (is_home()) {
            $page = get_post(get_option('page_for_posts', true));
            $options = $this->getPageOptions($page);
            return new PostsTemplate($this, $page, $options);
        }

        return new DefaultTemplate($this, $page, $options);
    }

    /**
     * Renders the header properly
     *
     * @param $templateVariables
     * @param BaseTemplate $template
     * @return string
     */
    private function renderHeader($templateVariables, BaseTemplate $template = null)
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

        if ($template) {
            $templateVariables['has_header'] = $template->hasHeader();
        } else {
            $templateVariables['has_header'] = true;
        }

        $templateVariables['header_style'] = $template ? $template->getHeaderClass() : 'simple';

        $templateVariables['navigation'] = $this->mainNavigation->getNavigationItems();

        if ($this->childTheme) {
            $templateVariables['branding'] = $this->childTheme->getBrandingName();
            $templateVariables = $this->childTheme->filterHeaderVariables($templateVariables);
        }

        return $this->templateEngine->render('header', $templateVariables);
    }

    /**
     * Renders the footer properly
     *
     * @param $templateVariables
     * @return string
     */
    public function renderFooter($templateVariables, BaseTemplate $template = null)
    {
        ob_start();
        wp_footer();
        $wpFooter = ob_get_clean();

        $templateVariables['wp_footer'] = $wpFooter;
        $templateVariables['analytics_key'] = '';

        if ($template) {
            $templateVariables['has_footer'] = $template->hasFooter();
        } else {
            $templateVariables['has_footer'] = true;
        }

        $templateVariables['navigation'] = $this->footerNavigation->getNavigationItems();
        $templateVariables['year'] = date('Y');
        $templateVariables['social_links'] = $this->socialMediaSettings->getSocialLinks($this->optionsManager);

        if ($this->childTheme) {
            $templateVariables['branding'] = $this->childTheme->getBrandingName() ?? "Pomelo Productions";
            $templateVariables['child_theme_social_media_links'] = $this->childTheme->getChildThemeSocialMediaLinks();
        }

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