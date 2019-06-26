<?php
declare(strict_types=1);

namespace PomeloProductions\Sections;

use PomeloProductions\Contracts\CanRenderContentContract;
use PomeloProductions\Traits\CanProcessContentTrait;

/**
 * Class BaseSection
 * @package Theme\Sections
 */
abstract class BaseSection implements CanRenderContentContract
{
    use CanProcessContentTrait;
}