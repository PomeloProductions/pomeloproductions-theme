<?php
declare(strict_types=1);

namespace Theme\Sections;

use Theme\Contracts\CanRenderContentContract;
use Theme\Traits\CanProcessContentTrait;

/**
 * Class BaseSection
 * @package Theme\Sections
 */
abstract class BaseSection implements CanRenderContentContract
{
    use CanProcessContentTrait;
}