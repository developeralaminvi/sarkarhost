<?php
/**
 * Template Name: Sarkar Host - Domain & Hosting
 * Description: Dedicated Domain & BDIX Hosting Page.
 */

get_header();
?>

<!-- Banner -->
<section class="inner-page-banner">
    <div class="container">
        <div class="breadcrumbs">
            <a href="<?php echo esc_url(home_url('/')); ?>"><i class="fa-solid fa-house"></i> হোম</a>
            <i class="fa-solid fa-chevron-right"></i>
            <span>Domain + Hosting</span>
        </div>
        <h1 class="page-title">
            Domain & Fast BDIX Hosting<br>
            <span class="highlight-text">নিরাপদ, দ্রুতগতির ও সাশ্রয়ী হোস্টিং সলিউশন</span>
        </h1>
        <p class="page-desc">
            আপনার ওয়েবসাইটের জন্য নির্ভরযোগ্য Domain ও Fast Hosting Solution। ব্যবসা বা ব্যক্তিগত ওয়েবসাইটের জন্য প্রয়োজন অনুযায়ী Domain ও Hosting প্যাকেজ বেছে নিন।
        </p>
    </div>
</section>

<!-- Hosting Services -->
<?php echo do_shortcode('[sarkarhost_hosting_domain]'); ?>

<!-- CTA -->
<?php echo do_shortcode('[sarkarhost_cta_banner]'); ?>

<?php
get_footer();
