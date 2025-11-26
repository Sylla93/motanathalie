<!DOCTYPE html>
<html lang="en">
<head>

  <!-- ===============================
        TITRE DYNAMIQUE DU SITE
       =============================== -->
  <!-- 
    Si on est sur la page d’accueil :
        Titre = Nom du site + Description
    Sinon :
        Titre = Nom du site + Titre de la page
  -->
  <title>
    <?php bloginfo('name'); ?> &raquo;
    <?php is_front_page() ? bloginfo('description') : wp_title(''); ?>
  </title>

  <!-- ===============================
       METADONNÉES DE BASE
       =============================== -->
  <meta charset="<?php bloginfo( 'charset' ); ?>">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <!-- ===============================
       POLICE GOOGLE FONT
       =============================== -->
  <link href="https://fonts.googleapis.com/css2?family=Space+Mono:ital,wght@0,400;0,700;1,400;1,700&display=swap" rel="stylesheet">

  <!-- ===============================
       FEUILLE DE STYLE PRINCIPALE
       =============================== -->
  <link rel="stylesheet" href="<?php bloginfo('stylesheet_url'); ?>">

  <!-- 
      wp_head() est indispensable :
      - Charge scripts WP
      - Charge Gutenberg, plugins
      - Charge scripts AJAX
      - Insère metas
  -->
  <?php wp_head(); ?>
</head>

<!-- Ajoute des classes automatiques au <body> pour styling -->
<body <?php body_class(); ?>>

  <!-- ==========================================================
        HEADER DU SITE (Logo + menu + burger mobile)
       ========================================================== -->
  <header class="my-logo">

    <!--  LOGO / NOM DU SITE -->
    <h1>
      <a href="<?php echo esc_url( home_url( '/' ) ); ?>">
        <?php bloginfo('name'); ?>
      </a>
    </h1>

    <!-- ===============================
          BOUTON BURGER (Mobile/Tablet)
         =============================== -->
    <div class="burger" id="burger-btn">
        <span></span>
        <span></span>
        <span></span>
    </div>

    <!-- ===============================
          MENU PRINCIPAL (Header)
         Généré uniquement si un menu
         est assigné dans WordPress
         =============================== -->
    <?php
    if ( has_nav_menu( 'header-menu' ) ) :
        wp_nav_menu( array(
            'theme_location' => 'header-menu',
            'menu_class'     => 'header-menu-class', // Classe CSS du UL généré
        ) );
    endif;
    ?>

  </header>
