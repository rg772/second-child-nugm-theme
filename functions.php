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



/* Add standard-page class to everything except homepage. Thanks to Alex Miner */
add_filter( 'body_class', function ( $classes ) {
    if ( !is_front_page() && $key = array_search('landing-page', $classes) ) {
        $classes[] = 'standard-page';
    }
    return $classes;
}, 11 );


