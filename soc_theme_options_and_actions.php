<?php


// Theme Option: soc_use_narrow_branding
// Narrow Branding menu. A theme option that adds class to main navigation menu
add_filter( 'nu_gm_top_nav_classes', function ($classes) {
    if (get_theme_mod('soc_use_narrow_branding', false)) {
        $classes[] = 'narrow-dropdown';
        return $classes;
    } else {
        return '';
    }
});

// Theme Option: soc_use_sticky_menu
// loads 
add_action('wp_enqueue_scripts', function () {
    if (get_theme_mod('soc_use_sticky_menu', false)) {
        wp_enqueue_script('soc_sticky_menu', get_stylesheet_directory_uri()  . '/soc_stickymenu.js', true);
    }
});



/*
* Add SoC options
*/
add_action('customize_register', function ($wp_customize) {

    
   // SoC Section
    $wp_customize->add_section('SOC', array(
    'title' => 'SOC level options',
    'priority' => 1700,
    ));

   // Use narrow branding in the main nav menu
    $wp_customize->add_setting(
         'soc_use_narrow_branding', array(
            'default' => false,
            'sanitize_callback' => 'nu_gm_sanitize_checkbox',
    ));
    $wp_customize->add_control(new WP_Customize_Control(
      $wp_customize,
      'soc_use_narrow_branding',
      array(
        'label' => 'Use narrow-branding menus',
        'description'=>'This insructs the theme to insert <code>narrow-branding</code> into the top nav as a class.',
        'section' => 'SOC',
        'type' => 'checkbox',
        'settings' => 'soc_use_narrow_branding',
    )));

    // Use sticky menu
    $soc_sticky_additional_desc =  'Loads javascript file that will create a "sticky" menu when the visitor scrolls';
    
    $wp_customize->add_setting(
        'soc_use_sticky_menu', array(
            'default'=>false,
            'sanitize_callback' => 'nu_gm_sanitize_checkbox',
        )
    );
      $wp_customize->add_control(new WP_Customize_Control($wp_customize, 'soc_use_sticky_menu',
      array(
        'label' => 'Use sticky menus',
        'description'=> $soc_sticky_additional_desc,
        'section' => 'SOC',
        'type' => 'checkbox',
        'settings' => 'soc_use_sticky_menu',
      )));
});
