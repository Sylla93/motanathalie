<?php get_header(); ?>

<main class="wrap page-content" style="padding:50px 0;">
    <?php 
    if ( have_posts() ) :
        while ( have_posts() ) : the_post(); 
    ?>
            <h1><?php the_title(); ?></h1>
            <div class="entry-content">
                <?php the_content(); ?>
            </div>
    <?php
        endwhile;
    else :
        echo "<p>Aucun contenu disponible.</p>";
    endif;
    ?>
</main>

<?php get_footer(); ?>
