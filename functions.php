<?php

/**
 *
 * Filename: functions.php
 * Version: 1.0.0
 * Created: 03/11/2017
 *
 * @author Jacob Boomgaarde, Pomelo Productions
 * @link https://github.com/quixotical/pomeloproductions-website
 *
 */
require_once 'vendor/autoload.php';
require_once 'vendor/cmb2/cmb2/init.php';

// Clean up wordpres <head>
remove_action('wp_head', 'rsd_link'); // remove really simple discovery link
remove_action('wp_head', 'wp_generator'); // remove wordpress version
remove_action('wp_head', 'feed_links', 2); // remove rss feed links (make sure you add them in yourself if youre using feedblitz or an rss service)
remove_action('wp_head', 'feed_links_extra', 3); // removes all extra rss feed links
remove_action('wp_head', 'index_rel_link'); // remove link to index page
remove_action('wp_head', 'wlwmanifest_link'); // remove wlwmanifest.xml (needed to support windows live writer)
remove_action('wp_head', 'start_post_rel_link', 10); // remove random post link
remove_action('wp_head', 'parent_post_rel_link', 10); // remove parent post link
remove_action('wp_head', 'adjacent_posts_rel_link', 10); // remove the next and previous post links
remove_action('wp_head', 'adjacent_posts_rel_link_wp_head', 10);
remove_action('wp_head', 'wp_shortlink_wp_head', 10);

$theme = new \PomeloProductions\Theme();
$theme->register();
