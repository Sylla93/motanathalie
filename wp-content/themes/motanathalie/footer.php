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
  </body>
</html>


<?php get_footer(); ?>