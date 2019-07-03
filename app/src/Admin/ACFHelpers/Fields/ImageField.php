<?php
declare(strict_types=1);

namespace PomeloProductions\Admin\ACFHelpers\Fields;

/**
 * Class ImageField
 * @package Theme\Admin\ACFHelpers\Fields
 */
class ImageField extends BaseField
{
    /**
     * ImageField constructor.
     * @param string $key
     * @param string $name
     * @param string $instructions
     */
    public function __construct(string $key, string $name, string $instructions)
    {
        parent::__construct('image', $key, $name, $instructions);
    }

    /**
     * @return array
     */
    public function export(): array
    {
        $export = parent::export();

        $export['return_format'] = 'url';
        $export['preview_size'] = 'featured-image';
        $export['library'] = 'all';
        $export['min_width'] = '';
        $export['min_height'] = '';
        $export['min_size'] = '';
        $export['max_width'] = '';
        $export['max_height'] = '';
        $export['max_size'] = '';
        $export['mime_types'] = '';

        return $export;
    }

    /**
     * Gets an image url based on an attachment id
     *
     * @param int $attachmentId
     * @return string|null
     */
    public static function getFeaturedImageUrl($attachmentId)
    {
        $image = wp_get_attachment_image_src($attachmentId, ['1920', '1080']);

        return $image ? $image[0] : null;
    }
}