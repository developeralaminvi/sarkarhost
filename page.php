<?php
/**
 * Sarkar Host Default Page Template
 * Supports standard page content, Elementor, and Shortcodes.
 */

get_header();
?>

<main id="primary" class="site-main">
    <?php
    while (have_posts()) :
        the_post();
        ?>
        <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
            <?php the_content(); ?>
        </article>
        <?php
    endwhile;
    ?>
</main>

<?php
get_footer();
