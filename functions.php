<?php
/**
 * Created by PhpStorm.
 * User: carbon
 * Date: 7/18/16
 * Time: 2:40 PM
 */

add_action('wp_enqueue_scripts', function () {


    /*
     * Use our own version of this CSS file. Explicitly cancel it from
     * going into the CSS and inject the local copy.
     */
    wp_dequeue_style('nu_gm-styles');
    wp_deregister_script('nu_gm-styles');
    wp_enqueue_style('nu_gm-styles', get_stylesheet_directory_uri() . '/library/css/gm-styles.css');

    /*
     * Font definitions coming from media.soc
     */
    wp_enqueue_style('nugm_soc_fonts', get_stylesheet_directory_uri() . '/fonts.css');

    wp_enqueue_style('parent-style', get_template_directory_uri() . '/style.css');
    wp_enqueue_style('nugm_soc_style', get_stylesheet_directory_uri() . '/style.css');
    wp_enqueue_style('res_tabs', get_stylesheet_directory_uri() . '/_rt.css');
    wp_enqueue_script("jquery");
    wp_enqueue_script('soc_nugm_force_search_action', get_stylesheet_directory_uri() . '/soc_gmnu_force_search_action.js', true);
    // wp_enqueue_script('nu-forgotten-script', get_stylesheet_directory_uri() . '/nu-scripts.js', true);


});

/* Add standard-page class to everything except homepage. Thanks to Alex Miner */
add_filter('body_class', function ($classes) {
    if (!is_front_page() && $key = array_search('landing-page', $classes)) {
        $classes[] = 'standard-page';
    }
    return $classes;
}, 11);

/*
 * Enforce SoC Menu in this theme. Decided to go with a dynamic menu to remove need
 * to hand make this menu in each site.
 */
add_action('after_setup_theme', function () {

    // Menu name as used in parent theme
    $menu_name_slug = 'menu-upper-nav';

    // menu location name as used in the NUGM
    $menu_location_name = 'upper-nav';

    // theme mod key name
    $theme_mod_name = 'nav_menu_locations';

    // array of SoC STandard Items
    $soc_menu_array = ['', 'about', 'news', 'support', 'contact'];

    // Get the menu if it exists
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
        foreach ($soc_menu_array as $soc_menu_item) {
            $menu_item_title = strtoupper(($soc_menu_item == '') ? 'home' : $soc_menu_item);
            $menu_item_url = $soc_menu_item;
            wp_update_nav_menu_item($menu_object->term_id, 0, [
                'menu-item-title' => __($menu_item_title),
                'menu-item-classes' => 'home',
                'menu-item-url' => 'http://communication.northwestern.edu/' . $menu_item_url,
                'menu-item-status' => 'publish',
            ]);
        }
    }
});

add_action('widgets_init', function () {
    register_sidebar([
        'name' => 'Template Footer Widget Left',
        'id' => 'template_left',
        'before_widget' => '<div>',
        'after_widget' => '</div>',
        'before_title' => '<strong>',
        'after_title' => '</strong>',
    ]);
    register_sidebar([
        'name' => 'Template Footer Widget Left Center',
        'id' => 'template_left_center',
        'before_widget' => '<div>',
        'after_widget' => '</div>',
        'before_title' => '<strong>',
        'after_title' => '</strong>',
    ]);
});

/*
 * Try to curb TinyMCE's from messing too much with
 */

add_filter('tiny_mce_before_init', function ($init) {
    // html elements being stripped
    $init['extended_valid_elements'] = 'div[*], article[*]';

    // don't remove line breaks
    $init['remove_linebreaks'] = false;

    // convert newline characters to BR
    $init['convert_newlines_to_brs'] = false;

    // don't remove redundant BR
    $init['remove_redundant_brs'] = false;

    // pass back to wordpress
    return $init;
});

/**
 * Text Changeroo
 *
 * This is an applied filter of gettext. It string overrides no content warnings coming from archive-nu_gm_*.php
 * pages.
 */
function soc_text_strings_changer_roo($translated_text, $text, $domain)
{
    $uri = $_SERVER['REQUEST_URI'];

    // events
    if (strpos($uri, '/events') === 0) {
        $name_helper = 'Events';
        $icon_helper = "&#128197;"; // 128197 calendar
    } // /projects
    elseif (strpos($uri, '/projects') === 0) {
        $name_helper = 'Projects';
        $icon_helper = "&#128220;"; // &#128220; = scroll
    } // directory/
    elseif (strpos($uri, '/directory') === 0) {
        $name_helper = 'Directory';
        $icon_helper = "&#128566;"; // &#128566; = face
    } // other
    else {
        $name_helper = "";
        $icon_helper = "&#128195;"; // &#128195;= curled paper

    }

    switch ($translated_text) {
        case 'Oops, Post Not Found!':
            $translated_text = __("$name_helper", 'soc');
            break;

        case 'Uh Oh. Something is missing. Try double checking things.':
            $translated_text = __("There appears to be no $name_helper at this time", 'soc');
            break;

        case 'This is the error message in the archive.php template.':
            $translated_text = __("<!-- This is the error message in the archive.php template. -->", 'soc');
            break;

    }
    return $translated_text;
}

add_filter('gettext', 'soc_text_strings_changer_roo', 2000, 3);


/**
 * Function rewrites choices for post type. Only executes if "soc_`custom`izer_override" is set to true
 * (checked in the customizer itself.
 *
 * @param WP_Customize_Manager $wp_customize
 */
function soc_customizer(WP_Customize_Manager $wp_customize)
{


    $wp_customize->add_control(
        new WP_Customize_Control(
            $wp_customize,
            'post_list_format',
            array(
                'label' => 'Display Format of Posts in Lists',
                'section' => 'post_format',
                'type' => 'radio',
                'choices' => array(
                    'standard' => __('Textual Preview', 'nu_gm'),
                    'feature-box' => __('Feature Box', 'nu_gm'),
                    'photo-feature' => __('Photo Feature', 'nu_gm'),
                    'news-listing' => __('Just use News', 'nu_gm'),
                    'soc-news-listing' => __('5th option / SoC Specific', 'nu_gm')
                ),
                'settings' => 'post_list_format_setting',
            )
        )
    );

}

add_action('customize_register', 'soc_customizer', 9000001);


/*
 * Require Theme options and actions
 */
require_once 'soc_theme_options_and_actions.php';

