<?php
declare(strict_types=1);

namespace PomeloProductions\Templates;

use PomeloProductions\Admin\ACFHelpers\Fields\SelectField;
use PomeloProductions\Admin\ACFHelpers\ParentGroup;
use PomeloProductions\Contracts\CanRenderContentContract;
use PomeloProductions\Theme;
use PomeloProductions\Traits\CanProcessContentTrait;
use PomeloProductions\Traits\InteractsWithOptionsTrait;
use WP_Post;

/**
 * Class BaseTemplate
 * @package Theme\Templates
 */
abstract class BaseTemplate implements CanRenderContentContract
{
    use CanProcessContentTrait, InteractsWithOptionsTrait;

    /**
     * @var Theme
     */
    protected $theme;

    /**
     * @var WP_Post
     */
    protected $page;

    /**
     * BaseTemplate constructor.
     * @param Theme $theme
     * @param WP_Post $page
     * @param $options
     */
    public function __construct(Theme $theme, WP_Post $page, $options)
    {
        $this->theme = $theme;
        $this->page = $page;
        $this->options = $options;
    }

    /**
     * Gets the slug for the page
     *
     * @return string
     */
    public function getSlug() : string
    {
        return $this->page->post_name;
    }

    /**
     * Override this and return false to
     *
     * @return bool
     */
    public function hasHeader(): bool
    {
        return true;
    }

    /**
     * @return string
     */
    public function getHeaderClass(): string
    {
        return $this->getOption('header_style', 'simple');
    }

    /**
     * @return array
     */
    public static function getHeaderStyleACFGroup(): array
    {
        $group = new ParentGroup('group_oir3htoihgr3owk', 'Header Style');
        $group->showOnAllPages();
        $group->addField(
            (new SelectField(
                'field_oierghwiorghot4r3',
                'header_style',
                'Select the header style for this page', [
                    'simple' => 'Simple',
                    'splash' => 'Splash',
                ]
            ))
            ->setDefaultValue('simple')
        );

        return $group->export();
    }
}