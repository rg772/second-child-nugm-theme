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


/*
 *
 */

add_action('after_setup_theme', function() {

    $menu_name_slug = 'menu-upper-nav';
    $menu_location_name = 'upper-nav';
    $theme_mod_name = 'nav_menu_locations';
    $soc_menu_array = ['', 'about', 'news', 'support', 'contact'];


    $menu_object = wp_get_nav_menu_object($menu_name_slug);

    // if menu doesn't exist create it
    if (!$menu_object) {
        $menu_id = wp_create_nav_menu($menu_name_slug);
        $menu_object = wp_get_nav_menu_object($menu_name_slug);
    }

    // force location
    $locations = get_theme_mod($theme_mod_name);
    $locations[$menu_location_name] = $menu_object->term_id;
    set_theme_mod($theme_mod_name, $locations);

    // does it have items
    $current_menu_items = wp_get_nav_menu_items($menu_name_slug);
    if (count($current_menu_items) == 0) {

        foreach($soc_menu_array as $soc_menu_item) {
            $menu_item_title = strtoupper(($soc_menu_item == '') ? 'home' : $soc_menu_item);
            $menu_item_url = $soc_menu_item;
            wp_update_nav_menu_item($menu_object->term_id, 0, [
                'menu-item-title' =>  __($menu_item_title),
                'menu-item-classes' => 'home',
                'menu-item-url' => 'http://communication.northwestern.edu/' . $menu_item_url,
                'menu-item-status' => 'publish'
            ]);
        }


    }



});