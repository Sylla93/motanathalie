<!DOCTYPE html>
<html lang="en">
<head>
 <title><?php bloginfo('name'); ?> &raquo; <?php is_front_page() ? bloginfo('description') : wp_title(''); ?></title>
 <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
       <link href="https://fonts.googleapis.com/css2?family=Space+Mono:ital,wght@0,400;0,700;1,400;1,700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?php bloginfo('stylesheet_url'); ?>">
    <?php wp_head(); ?>
</head>
 <body <?php body_class(); ?>>
   <header class="my-logo">
   <h1><a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php bloginfo('name'); ?></a></h1>

    <!-- BOUTON BURGER -->
    <div class="burger" id="burger-btn">
        <span></span>
        <span></span>
        <span></span>
    </div>


<?php
if ( has_nav_menu( 'header-menu' ) ) :
    wp_nav_menu( array(
        'theme_location' => 'header-menu',
        'menu_class'     => 'header-menu-class' // classe CSS pour personnaliser le menu
    ) );
endif;
?>

   
 </header>
