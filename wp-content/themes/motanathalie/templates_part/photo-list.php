<?php
$image_id    = get_post_thumbnail_id();
$image_medium = wp_get_attachment_image_src($image_id, 'medium');
$image_full   = wp_get_attachment_image_src($image_id, 'full');
$image_alt    = get_post_meta($image_id, '_wp_attachment_image_alt', true);
?>

<?php if ($image_medium) : ?>
  <div class="motanathalie-photo">
    <a href="<?php the_permalink(); ?>" class="photo-link">
      <?php
        // IMPORTANT : on garde l’<img> “classique” pour éviter que le plugin ne modifie trop la structure
        echo wp_get_attachment_image($image_id, 'medium', false, [
          'class' => 'photo-thumb',
          'alt'   => $image_alt ?: get_the_title(),
        ]);
      ?>

      <!-- Overlay -->
      <div class="photo-hover" aria-hidden="true">
        <svg xmlns="http://www.w3.org/2000/svg" class="eye-icon" width="38" height="38" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2">
          <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/>
          <circle cx="12" cy="12" r="3"/>
        </svg>
        <p class="photo-hover-title"><?php the_title(); ?></p>
      </div>
    </a>
  </div>
<?php endif; ?>
