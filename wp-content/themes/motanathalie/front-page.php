<?php get_header(); ?>

<?php 
$image_hero = get_field('image_hero'); // SCF/ACF fonction pour récupérer l'image
if ($image_hero) : ?>
  <section class="hero" style="background-image: url('<?php echo esc_url($image_hero['url']); ?>');">
    <div class="hero-content">
      <h1><?php the_title(); ?></h1>
      <p><?php the_field('accroche_hero'); // Par exemple un texte d'accroche ?></p>
    </div>
  </section>
<?php endif; ?>

<?php 
// Le reste de ton contenu / loop ou autres sections du template ici
?>

<section class="hero" style="background-image: url('<?php echo get_template_directory_uri(); ?>/images/hero.jpg');">
  <div class="hero-content">
    <h1>PHOTOGRAPHE EVENT</h1>
  </div>
</section>



<?php get_footer(); ?>