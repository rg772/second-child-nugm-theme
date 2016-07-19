<?php
/**
 * Created by PhpStorm.
 * User: carbon
 * Date: 7/18/16
 * Time: 2:40 PM
 */



add_action('wp_enqueue_scripts', 'nugm_soc_theme_enqueue_styles');
function nugm_soc_theme_enqueue_styles()
{
    wp_enqueue_style('parent-style', get_template_directory_uri() . '/style.css');
    wp_enqueue_style('nugm_soc_style', get_stylesheet_directory_uri() . '/style.css');


}