<?php
/**
 * Affichage d'un post unique – Thème Motanathalie
 */

get_header();
?>

<div class="main-content single motanathalie-single">
    <?php if (have_posts()) : ?>
        <?php while (have_posts()) : the_post(); ?>
            <article id="post-<?php the_ID(); ?>" <?php post_class('motanathalie-article'); ?>>
                <header class="entry-header">
                    <h1 class="entry-title"><?php the_title(); ?></h1>
                    <p class="entry-meta">
                        Publié le <?php the_date(); ?> dans <?php the_category(', '); ?> par <?php the_author(); ?>
                    </p>
                </header>
                <div class="entry-content">
                    <?php the_content(); ?>
                </div>
                <?php
                // Navigation parent si attachement
                if (is_attachment()) {
                    the_post_navigation([
                        'prev_text' => sprintf('<span class="meta-nav">Publié dans</span><span class="post-title">%s</span>', '%title'),
                    ]);
                }

                // Zone commentaires
                if (comments_open() || get_comments_number()) {
                    comments_template();
                }

                // Navigation précédent/suivant
                the_post_navigation([
                    'next_text' => '<span class="meta-nav">Article suivant</span><span class="post-title">%title</span>',
                    'prev_text' => '<span class="meta-nav">Article précédent</span><span class="post-title">%title</span>',
                ]);
                ?>
            </article>
        <?php endwhile; ?>
    <?php endif; ?>
</div>

<?php get_sidebar(); ?>
<?php get_footer(); ?>
