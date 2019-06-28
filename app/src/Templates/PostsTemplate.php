<?php
declare(strict_types=1);

namespace PomeloProductions\Templates;

use Handlebars\Handlebars;
use PomeloProductions\Templates\Traits\HasCompositeSectionTrait;

/**
 * Class PostsTemplate
 * @package PomeloProductions\Templates
 */
class PostsTemplate extends BaseTemplate
{
    use HasCompositeSectionTrait;

    /**
     * Whether or not we want to wrap the posts title with a header tag
     * @var bool
     */
    protected $wrapTitle = false;

    /**
     * Whether or not we want to show the full post link, or simply allow the user to expand the post
     * @var bool
     */
    protected $showFullPostLink = false;

    /**
     * Renders this particular template
     *
     * @param Handlebars $templateEngine
     * @param array $templateVariables
     * @return string
     */
    public function render(Handlebars $templateEngine, array $templateVariables): string
    {
        $templateVariables['posts'] = [];
        $templateVariables['post_link_text'] = 'Read More';

        /** @var \WP_Post $post */
        foreach (get_posts($this->getPostsQuery()) as $post) {
            $excerptLength = 50;
            $excerpt = strip_shortcodes($post->post_content); //Strips tags and images
            $words = explode(' ', $excerpt, $excerptLength + 1);

            if(count($words) > $excerptLength) {
                $words = array_splice($words, 0, $excerptLength);
                $excerpt = implode(' ', $words);

                if (endsWith($excerpt, ',') || endsWith($excerpt, '.')) {
                    $excerpt = substr($excerpt, 0, strlen($excerpt) - 1);
                }

                $excerpt.= '...';
            }

            while (substr_count($excerpt, '<div') != substr_count($excerpt, '</div>')) {
                if (substr_count($excerpt, '<div') > substr_count($excerpt, '</div>')) {
                    $excerpt.= '</div>';
                } else {
                    $excerpt = preg_replace('<\/div>', '', $excerpt, 1);
                }
            }

            $postData = [
                'excerpt' => $this->processContentString($excerpt),
                'thumbnail' => get_the_post_thumbnail_url($post, 'full'),
                'title' => $post->post_title,
                'wrap_title' => $this->wrapTitle,
            ];
            if ($this->showFullPostLink) {
                $postData['link'] = get_permalink($post);
            } else {
                $postData['content'] = $this->processContentString($post->post_content);
            }
            $templateVariables['posts'][] = $postData;
        }

        $templateVariables['sections'] = $this->renderPageSections($templateEngine, $templateVariables);

        return $templateEngine->render('posts', $templateVariables);
    }

    /**
     * @return array
     */
    public function getPostsQuery() : array
    {
        return ['numberposts' => 1000 ];
    }
}