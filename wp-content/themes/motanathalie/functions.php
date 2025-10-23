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

// ***********************javascript***************************
function theme_scripts() {
    wp_enqueue_script(
        'custom-js',
        get_template_directory_uri() . '/js/script.js',
        array('jquery'), // si vous utilisez jQuery
        null,
        true // charge dans le footer
    );
    // Ceci définit la variable JS ajaxurl pour utiliser admin-ajax.php dans ton script.js
    wp_localize_script('custom-js', 'ajaxurl', admin_url('admin-ajax.php'));
}
add_action('wp_enqueue_scripts', 'theme_scripts');





// *******************************************
function my_theme_setup() {
    add_theme_support('post-thumbnails');
}
add_action('after_setup_theme', 'my_theme_setup');

add_filter('acf/settings/remove_wp_meta_box', '__return_false', 20);


// **************************Pagination infinie***********************

function ajax_load_more_photos() {
    $paged = isset($_POST['page']) ? intval($_POST['page']) : 1;

    $args = array(
        'post_type' => 'photos',
        'posts_per_page' => 8,
        'paged' => $paged,
    );

    $query = new WP_Query($args);

    if($query->have_posts()) :
        while($query->have_posts()): $query->the_post();
            // Exemple d'affichage simplifié, adapte selon ton bloc photo
            ?>
            <div class="photo-item">
                <h2><?php the_title(); ?></h2>
                <div class="photo-thumbnail">
                    <?php if (has_post_thumbnail()) { the_post_thumbnail('medium'); } ?>
                </div>
                <button class="contact-btn" data-photo-ref="<?php the_ID(); ?>">Contact</button>
            </div>
            <?php
        endwhile;
    endif;
    wp_reset_postdata();
    wp_die(); // Terminer proprement
}
add_action('wp_ajax_load_more_photos', 'ajax_load_more_photos');
add_action('wp_ajax_nopriv_load_more_photos', 'ajax_load_more_photos');


