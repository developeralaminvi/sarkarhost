<?php
/**
 * Template Name: Sarkar Host - Graphics Design
 * Description: Dedicated Graphics & Creative Branding Design Page.
 */

get_header();
?>

<!-- Banner -->
<section class="inner-page-banner">
    <div class="container">
        <div class="breadcrumbs">
            <a href="<?php echo esc_url(home_url('/')); ?>"><i class="fa-solid fa-house"></i> হোম</a>
            <i class="fa-solid fa-chevron-right"></i>
            <span>Graphics & Design Service</span>
        </div>
        <h1 class="page-title">
            Creative Graphics & Branding<br>
            <span class="highlight-text">আপনার ব্র্যান্ডকে দিন নজরকাড়া ও প্রিমিয়াম লুক</span>
        </h1>
        <p class="page-desc">
            আপনার ব্যবসা ও ব্র্যান্ডের জন্য আকর্ষণীয়, আন্তর্জাতিক মানের ও প্রফেশনাল Graphics Design Service যা কাস্টমারদের সহজেই আকৃষ্ট করবে।
        </p>
    </div>
</section>

<!-- Graphics Design Services -->
<?php echo do_shortcode('[sarkarhost_graphics_design]'); ?>

<!-- CTA -->
<?php echo do_shortcode('[sarkarhost_cta_banner]'); ?>

<?php
get_footer();
