<?php
/**
 * Template part for the contact modal
 */
?>

<div id="contact-modal" class="modal-overlay">
  <div class="modal-content">
    
    
    <button class="modal-close" aria-label="Fermer la modale">&times;</button>
    <!-- === HEADER SVG === -->
    <div class="modal-header-graphic">
      <img src="<?php echo get_template_directory_uri(); ?>/images/Contactheader.svg" 
           alt="Contact"
           class="modal-header-svg">
    </div>
    <!-- ==================== -->
    
    <!-- <h2>CONTACT</h2> -->

    <?php echo do_shortcode('[contact-form-7 id="41a65b3" title="Contact"]'); ?>
  </div>
</div>





<!-- <div id="contact-modal" class="modal-overlay">
  <div class="modal-content">
    <button class="modal-close" aria-label="Fermer la modale">&times;</button>
    <h2>Contactez-nous</h2>
    <?php echo do_shortcode('[contact-form-7 id="41a65b3" title="Contact"]'); ?>
  </div>
</div> -->
