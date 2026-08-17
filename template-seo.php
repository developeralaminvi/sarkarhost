<?php
/**
 * Template Name: Sarkar Host - SEO Service
 * Description: Dedicated Professional SEO Service Page.
 */

get_header();
?>

<!-- Banner -->
<section class="inner-page-banner">
    <div class="container">
        <div class="breadcrumbs">
            <a href="<?php echo esc_url(home_url('/')); ?>"><i class="fa-solid fa-house"></i> হোম</a>
            <i class="fa-solid fa-chevron-right"></i>
            <span>Professional SEO Service</span>
        </div>
        <h1 class="page-title">
            Professional SEO Service<br>
            <span class="highlight-text">আপনার ওয়েবসাইটকে Google-এ আরও ভালো অবস্থানে নিয়ে আসুন</span>
        </h1>
        <p class="page-desc">
            আপনার ব্যবসার জন্য শুধু একটি ওয়েবসাইট থাকলেই হবে না—সঠিক কাস্টমারের কাছে ওয়েবসাইটটি পৌঁছানোও জরুরি। আমাদের Professional SEO Service আপনার ওয়েবসাইটের Search Engine Ranking, Organic Traffic এবং Online Visibility বাড়াতে সাহায্য করবে।
        </p>
    </div>
</section>

<!-- SEO Details & Process -->
<?php echo do_shortcode('[sarkarhost_seo_service]'); ?>

<!-- CTA -->
<?php echo do_shortcode('[sarkarhost_cta_banner]'); ?>

<?php
get_footer();
