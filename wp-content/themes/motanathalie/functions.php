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