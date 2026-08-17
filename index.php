<?php
/**
 * Sarkar Host Main Index / Fallback Template
 */

get_header();
?>

<main id="primary" class="site-main" style="padding: 5rem 0;">
    <div class="container">
        <?php if (have_posts()) : ?>
            <div class="services-grid">
                <?php while (have_posts()) : the_post(); ?>
                    <article id="post-<?php the_ID(); ?>" <?php post_class('service-card'); ?>>
                        <h2 class="service-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
                        <div class="service-summary">
                            <?php the_excerpt(); ?>
                        </div>
                        <a href="<?php the_permalink(); ?>" class="btn btn-outline"><?php _e('Read More', 'sarkarhost'); ?> <i class="fa-solid fa-arrow-right"></i></a>
                    </article>
                <?php endwhile; ?>
            </div>
            <div style="margin-top: 3rem; text-align: center;">
                <?php the_posts_pagination(); ?>
            </div>
        <?php else : ?>
            <div class="text-center">
                <h2><?php _e('Nothing Found', 'sarkarhost'); ?></h2>
                <p><?php _e('It seems we can&rsquo;t find what you&rsquo;re looking for.', 'sarkarhost'); ?></p>
            </div>
        <?php endif; ?>
    </div>
</main>

<?php
get_footer();
