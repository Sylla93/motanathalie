<?php
get_header();

while (have_posts()) : the_post();
    // Affiche le titre
    the_title('<h1>', '</h1>');

    // Affiche le contenu
    the_content();

    // Exemple d'affichage d'un champ ACF ou SCF
    if (function_exists('get_field')) {
        $custom_field = get_field('mon_champ_personnalise');
        if ($custom_field) {
            echo '<p>' . esc_html($custom_field) . '</p>';
        }
    }

endwhile;

get_footer();
