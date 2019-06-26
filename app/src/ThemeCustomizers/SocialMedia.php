<?php
declare(strict_types=1);

namespace PomeloProductions\ThemeCustomizers;

use PomeloProductions\Utility\OptionsManager;

/**
 * Class SocialMedia
 * @package Theme\Settings
 */
class SocialMedia
{
    /**
     * @param \WP_Customize_Manager $customizer
     */
    public function register(\WP_Customize_Manager $customizer)
    {
        $customizer->add_section('pomelo_social_media', array(
            'title'    => 'Social Media',
            'description' => 'Modify the social media links used by the theme. Leave fields blank in order to not use them.',
            'priority' => 120,
        ));

        $customizer->add_setting(OptionsManager::OPTION_PREFIX . '[social][facebook]', array(
            'default'        => '',
            'capability'     => 'edit_theme_options',
            'type'           => 'option',
        ));
        $customizer->add_control('facebook', array(
            'label'      => 'Facebook URL',
            'section'    => 'pomelo_social_media',
            'settings'   => OptionsManager::OPTION_PREFIX .  '[social][facebook]',
        ));

        $customizer->add_setting(OptionsManager::OPTION_PREFIX . '[social][github]', array(
            'default'        => '',
            'capability'     => 'edit_theme_options',
            'type'           => 'option',
        ));
        $customizer->add_control('github', array(
            'label'      => 'Github URL',
            'section'    => 'pomelo_social_media',
            'settings'   => OptionsManager::OPTION_PREFIX .  '[social][github]',
        ));
    }

    /**
     * Returns all social media links that have urls
     *
     * @param OptionsManager $optionManager
     * @return array
     */
    public function getSocialLinks(OptionsManager $optionManager)
    {
        $socialLinks = $optionManager->getOption('social');

        return count($socialLinks) ? array_filter($socialLinks, 'strlen') : [];
    }
}