<?php
/**
 * Template Name: Sarkar Host - Web Development
 * Description: Dedicated Web & Mobile App Solutions Page.
 */

get_header();
?>

<!-- Banner -->
<section class="inner-page-banner">
    <div class="container">
        <div class="breadcrumbs">
            <a href="<?php echo esc_url(home_url('/')); ?>"><i class="fa-solid fa-house"></i> হোম</a>
            <i class="fa-solid fa-chevron-right"></i>
            <span>Web & App Development</span>
        </div>
        <h1 class="page-title">
            Web & Mobile App Solutions<br>
            <span class="highlight-text">আধুনিক প্রযুক্তিতে তৈরি শক্তিশালী ডিজিটাল প্ল্যাটফর্ম</span>
        </h1>
        <p class="page-desc">
            আপনার ব্যবসা ও আইডিয়াকে বাস্তবে রূপ দিতে আমরা তৈরি করি দ্রুতগতির ই-কমার্স, এলএমএস, কর্পোরেট ওয়েবসাইট, হাই-কনভার্টিং ল্যান্ডিং পেজ এবং কাস্টম মোবাইল অ্যাপ।
        </p>
    </div>
</section>

<!-- Web & App Development Services -->
<?php echo do_shortcode('[sarkarhost_web_development]'); ?>

<!-- CTA -->
<?php echo do_shortcode('[sarkarhost_cta_banner]'); ?>

<?php
get_footer();
