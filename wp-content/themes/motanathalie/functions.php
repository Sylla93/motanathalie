<?php
function mon_theme_styles() {
    wp_enqueue_style('mon-theme-style', get_stylesheet_uri());
}
add_action('wp_enqueue_scripts', 'mon_theme_styles');


// Register a new navigation menu 
function register_my_menus() {
    register_nav_menus( array(
        'header-menu' => __( 'Header Menu' ),
        'footer-menu' => __( 'Footer Menu' )
    ) );
}
add_action( 'init', 'register_my_menus' );

// ***********************javascript***************************
function theme_scripts() {
    wp_enqueue_script(
        'custom-js',
        get_template_directory_uri() . '/js/script.js',
        array('jquery'), // si vous utilisez jQuery
        null,
        true // charge dans le footer
    );
}
add_action('wp_enqueue_scripts', 'theme_scripts');
