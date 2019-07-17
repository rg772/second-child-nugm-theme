<?php


// Theme Option: soc_use_narrow_branding
// Narrow Branding menu. A theme option that adds class to main navigation menu
add_filter('nu_gm_top_nav_classes', function ($classes) {
    if (get_theme_mod('soc_use_narrow_branding', FALSE)) {
        $classes[] = 'narrow-dropdown';
        return $classes;
    } else {
        return '';
    }
});

// ENQUEUE
// -> Sticky Menu
// -> Gray Bars
// -> Trailing Menu highlights
// -> IE/Edge Issue fix (default is true)
// loads CSS or JS files to enhance functionality
add_action('wp_enqueue_scripts', function () {
    if (get_theme_mod('soc_use_sticky_menu', FALSE)) {
        wp_enqueue_script('soc_sticky_menu', get_stylesheet_directory_uri() . '/soc_stickymenu.js', TRUE);
    }


    if (get_theme_mod('soc_grey_bar_on_menu', FALSE)) {
        wp_enqueue_style('menu_grey_bar_on_menu', get_stylesheet_directory_uri() . '/css/menu_grey_bar_on_menu.css');
    }


    if (get_theme_mod('soc_trailing_menu_css', FALSE)) {
        wp_enqueue_style('soc_trailing_menu_css', get_stylesheet_directory_uri() . '/css/trailing_menu_item.css');
    }

    if (get_theme_mod('soc_ie_fix', TRUE)) {
        wp_enqueue_style('soc_ie_fix', get_stylesheet_directory_uri() . '/css/ie-fix.css');
    }

});


// Stop WP from stripping out data various
// inspiration from http://mawaha.com/allowing-data-attributes-in-wordpress-posts/
add_filter('wp_kses_allowed_html', function ($allowed, $context) {
    if (is_array($context)) {
        return $allowed;
    }

    if ($context === 'post') {
        if (get_theme_mod('soc_kses_override', FALSE)) {
            $allowed['div']['data-collapse'] = TRUE;
        }
    }
    return $allowed;
}, 10, 2);


/*
 * after_setup_theme
 *
 * This action, gets the users current roles and executes an array
 * intersect to see if the user is a member of the top classes:
 * 'administrator', 'editor', 'author'. If not, the admin bar is
 * set to false.
 */
add_action('after_setup_theme', function () {

    if (get_theme_mod('soc_hide_adminbar_subscriber', FALSE)) {

        $user = wp_get_current_user();
        // print_r($user->roles);

        $role_intersection = array_intersect($user->roles, [
            'administrator', 'editor', 'author',
        ]);

        if (in_array('subscriber', (array)$user->roles)) {
            show_admin_bar(FALSE);
        }

        if (count($role_intersection) == 0) {
            show_admin_bar(FALSE);
        }
    }
}, 99);


/*
* Add SoC options
*/
add_action('customize_register', function ($wp_customize) {


    // SoC Section
    $wp_customize->add_section('SOC', [
        'title' => 'SOC level options',
        'priority' => 1700,
    ]);

    // Use narrow branding in the main nav menu
    $wp_customize->add_setting(
        'soc_use_narrow_branding', [
        'default' => FALSE,
        'sanitize_callback' => 'nu_gm_sanitize_checkbox',
    ]);
    $wp_customize->add_control(new WP_Customize_Control(
        $wp_customize,
        'soc_use_narrow_branding',
        [
            'label' => 'Use narrow-branding menus',
            'description' => 'This instructs the theme to insert <code>narrow-branding</code> into the top nav as a class.',
            'section' => 'SOC',
            'type' => 'checkbox',
            'settings' => 'soc_use_narrow_branding',
        ]));

    // Use sticky menu
    $soc_sticky_additional_desc = 'Loads javascript file that will create a "sticky" menu when the visitor scrolls';

    $wp_customize->add_setting('soc_use_sticky_menu', [
        'default' => FALSE,
        'sanitize_callback' => 'nu_gm_sanitize_checkbox',
    ]);
    $wp_customize->add_control(new WP_Customize_Control($wp_customize, 'soc_use_sticky_menu', [
        'label' => 'Use sticky menus',
        'description' => $soc_sticky_additional_desc,
        'section' => 'SOC',
        'type' => 'checkbox',
        'settings' => 'soc_use_sticky_menu',
    ]));

    // kses override
    $wp_customize->add_setting('soc_kses_override', [
        'default' => FALSE,
        'sanitize_callback' => 'nu_gm_sanitize_checkbox',
    ]);
    $wp_customize->add_control(new WP_Customize_Control($wp_customize, 'soc_kses_override', [
        'label' => 'kses Override',
        'section' => 'SOC',
        'default' => 'default',
        'type' => 'checkbox',
        'settings' => 'soc_kses_override',
    ]));

    // kses override
    $wp_customize->add_setting('soc_hide_adminbar_subscriber', [
        'default' => FALSE,
        'sanitize_callback' => 'nu_gm_sanitize_checkbox',
    ]);
    $wp_customize->add_control(new WP_Customize_Control($wp_customize, 'soc_hide_adminbar_subscriber', [
        'label' => 'Hide admin tool bar from Subscriber role',
        'section' => 'SOC',
        'type' => 'checkbox',
        'settings' => 'soc_hide_adminbar_subscriber',
    ]));


    // grey bars on menu
    $wp_customize->add_setting('soc_grey_bar_on_menu', [
        'default' => FALSE,
        'sanitize_callback' => 'nu_gm_sanitize_checkbox',
    ]);
    $wp_customize->add_control(new WP_Customize_Control($wp_customize, 'soc_grey_bar_on_menu', [
        'label' => 'Put grey bars on the menu',
        'section' => 'SOC',
        'type' => 'checkbox',
        'settings' => 'soc_grey_bar_on_menu',
    ]));

    // trailing menu
    $wp_customize->add_setting('soc_trailing_menu_css', [
        'default' => FALSE,
        'sanitize_callback' => 'nu_gm_sanitize_checkbox',
    ]);
    $wp_customize->add_control(new WP_Customize_Control($wp_customize, 'soc_trailing_menu_css', [
        'label' => 'Add trailing menu CSS coloring',
        'section' => 'SOC',
        'type' => 'checkbox',
        'settings' => 'soc_trailing_menu_css',
    ]));


    // IE Fix
    $wp_customize->add_setting('soc_ie_fix', [
        'default' => TRUE,
        'sanitize_callback' => 'nu_gm_sanitize_checkbox',
    ]);
    $wp_customize->add_control(new WP_Customize_Control($wp_customize, 'soc_ie_fix', [
        'label' => 'Use CSS to fix drop down menus in IE/Edge',
        'section' => 'SOC',
        'type' => 'checkbox',
        'settings' => 'soc_ie_fix',
    ]));

    // Read More Optional Text override 
    $wp_customize->add_setting( 'soc_readmore_optional_text_override' , array(
        'default' => 'Read More',
        'type' => 'theme_mod',
        'sanitize_callback' => 'soc_readmore_optional_text_override_sanitize',
    ) );
    $wp_customize->add_control(new WP_Customize_Control($wp_customize, 'soc_readmore_optional_text_override', [
        'label' => __( 'Read More Optional Text override (SoC News) ', 'soc' ),
        'type' => 'text',
        'section' => 'post_format',
        'settings'=>'soc_readmore_optional_text_override',
    ]));

   


});



/**
 * Sanitization function for text input. 
 */
function soc_readmore_optional_text_override_sanitize($input) {
    return filter_var($input, FILTER_SANITIZE_STRING);
}

