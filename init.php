<?php
/**
 * Simply include this file to display a page :)
 */

$page = get_post();

if ($post == null) {
    echo $mainTheme->showError(404);
} else {
    echo $mainTheme->showPage($page);
}
