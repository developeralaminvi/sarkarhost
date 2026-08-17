<?php
/**
 * Template Name: Sarkar Host - Digital Marketing
 * Description: Dedicated Facebook Promotion, Setup & Boosting Page.
 */

get_header();
?>

<!-- Banner -->
<section class="inner-page-banner">
    <div class="container">
        <div class="breadcrumbs">
            <a href="<?php echo esc_url(home_url('/')); ?>"><i class="fa-solid fa-house"></i> হোম</a>
            <i class="fa-solid fa-chevron-right"></i>
            <span>Digital Marketing & Ads</span>
        </div>
        <h1 class="page-title">
            Digital Marketing & Boosting<br>
            <span class="highlight-text">সঠিক অডিয়েন্সের কাছে পৌঁছান ও বিক্রি বাড়ান</span>
        </h1>
        <p class="page-desc">
            আপনার ফেসবুক পেজ, বিজনেস বা ব্র্যান্ডের পরিচিতি, ফলোয়ার, রিচ এবং বিক্রয় বৃদ্ধি করতে সুপরিকল্পিত মার্কেটিং ও প্রফেশনাল অ্যাড ক্যাম্পেইন পরিচালনা করুন।
        </p>
    </div>
</section>

<!-- Digital Marketing Services -->
<?php echo do_shortcode('[sarkarhost_digital_marketing]'); ?>

<!-- CTA -->
<?php echo do_shortcode('[sarkarhost_cta_banner]'); ?>

<?php
get_footer();
