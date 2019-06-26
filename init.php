<?php
/**
 * Simply include this file to display a page :)
 */
use PomeloProductions\Theme;

$theme = new Theme();
$page = get_post();

if ($post == null) {
    echo $theme->showError(404);
} else {
    echo $theme->showPage($page);
}
