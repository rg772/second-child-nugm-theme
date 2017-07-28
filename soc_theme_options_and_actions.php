<?php


// Theme Option: soc_use_narrow_branding
// Narrow Branding menu. A theme option that adds class to main navigation menu
add_filter('nu_gm_top_nav_classes', function ($classes) {
	if (get_theme_mod('soc_use_narrow_branding', FALSE)) {
		$classes[] = 'narrow-dropdown';
		return $classes;
	}
	else {
		return '';
	}
});

// Theme Option: soc_use_sticky_menu
// loads 
add_action('wp_enqueue_scripts', function () {
	if (get_theme_mod('soc_use_sticky_menu', FALSE)) {
		wp_enqueue_script('soc_sticky_menu', get_stylesheet_directory_uri() . '/soc_stickymenu.js', TRUE);
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


// Theme option: Hide admin bar. If checked in settings, this will
// load the user and see if they belong to the subscriber role. If 
// they do, show_admin_bar will be used to set a false value. 
add_action('after_setup_theme', function () {

  if (get_theme_mod('soc_hide_adminbar_subscriber', FALSE)) {

    $user = wp_get_current_user();
    if (in_array('subscriber', (array) $user->roles)) {
      show_admin_bar(FALSE);
    }
  }
});


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
});
