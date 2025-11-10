<footer>
  
  <nav class="footer-navigation" aria-label="Menu footer">
    <?php
if ( has_nav_menu( 'footer-menu' ) ) :
    wp_nav_menu( array(
        'theme_location' => 'footer-menu',
        'menu_class'     => 'footer-menu-class'  // classe CSS pour personnaliser le menu
    ) );
endif;
?>

  </nav>

    </footer>
        <?php get_template_part('templates_part/modal-contact'); ?>
    <?php wp_footer(); ?>

    <!-- ************************************************************* -->

   

<!--  LIGHTBOX GLOBALE -->
<div id="lightbox-overlay" class="lightbox hidden">
  <div class="lightbox-header">
    <h3 id="lightbox-title"></h3>
    <button class="lightbox-close" aria-label="Fermer la lightbox">&times;</button>
  </div>

  <div class="lightbox-content">
    <button class="lightbox-prev" aria-label="Photo précédente">← Précédente</button>

    <div class="lightbox-image-wrapper">
      <img id="lightbox-img" src="" alt="">
    </div>

    <button class="lightbox-next" aria-label="Photo suivante">Suivante →</button>
  </div>

  <div class="lightbox-footer">
    <p class="lightbox-ref" id="lightbox-ref"></p>
    <p class="lightbox-cat" id="lightbox-cat"></p>
  </div>
</div>


    
    
    <?php get_footer(); ?>
  </body>
</html>