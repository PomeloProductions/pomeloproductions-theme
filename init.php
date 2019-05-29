<?php
/**
 * Simply include this file to display a page :)
 */
use Theme\Theme;

$theme = new Theme();
$page = get_post();
echo $theme->showPage($page);
